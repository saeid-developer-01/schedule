<?php

namespace IICN\Schedule\Services;


use Carbon\Carbon;
use IICN\Schedule\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Scheduler
{
    public string|null $timezone;
    public string|null $classRunner;
    public array $parameters;
    public bool $justOnce = false;

    public function __construct()
    {

    }

    public function do(string $class, array $parameters = []): self
    {
        $this->classRunner = $class;

        $this->parameters = $parameters;

        return $this;
    }

//    public function cron(string $cron, string $timezone): void
//    {
//        $this->storeInDB($cron, $timezone);
//    }

    public function at(string $dateTime, string|array $timezone = null): void
    {
        $validator = Validator::make(['dateTime' => $dateTime], [
            'dateTime' => 'required|date_format:Y-m-d H:i',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages(['message' => trans('validation.date_format', ['format' => 'Y-m-d H:i'])]);
        }

        $this->justOnce = true;

        //minute(0 - 59) hour(0 - 23) day of the month(1 - 31) month(1 - 12) day of the week(0 - 6)(Sunday to Saturday)
        $cron = null;

        if (!$timezone) {
            $timezone = config('schedule.timezones');
        }

        if (is_string($timezone)) {
            $time = Carbon::createFromFormat('Y-m-d H:i', $dateTime, $timezone)->setTimezone('UTC');
            $this->storeInDB($time, $timezone, $cron, $time->year);

        } elseif (is_array($timezone)) {
            foreach ($timezone as $zone) {
                $time = Carbon::createFromFormat('Y-m-d H:i', $dateTime, $zone)->setTimezone('UTC');
                $this->storeInDB($time, $zone, $cron, $time->year);
            }
        }
        $this->resetConfig();
    }

    private function storeInDB(Carbon $nextRun, string $timezone, string $cron = null, int|null $year = null): void
    {
        Schedule::query()->create([
            'next_run' => $nextRun->toDateTimeLocalString(),
            'cron' => $cron,
            'year' => $year,
            'class_runner' => $this->classRunner,
            'input_parameters' => $this->parameters,
            'user_id' => Auth::check() ? Auth::id() : null,
            'enabled' => true,
            'just_once' => $this->justOnce,
            'timezone' => $timezone
        ]);
    }


//    public function call($callbackFunction): void
//    {
//        $this->resetConfig();
//    }

    private function resetConfig(): void
    {
        $this->classRunner = null;
        $this->parameters = [];
        $this->justOnce = false;
    }

}
