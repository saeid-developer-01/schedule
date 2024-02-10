<?php

namespace IICN\Schedule\Commands;

use Carbon\Carbon;
use IICN\Schedule\Models\Schedule;
use IICN\Schedule\ScheduleBuilder;
use Illuminate\Console\Command;

class RunSchedulerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:run-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now('UTC')->format('Y-m-d H:i:00');

        $schedules = Schedule::query()->where('next_run' , $date)->get();

        foreach ($schedules as $schedule) {
            try {
                $this->runClass($schedule);
            } catch (\Exception) {
            }
        }
    }

    protected function runClass(Schedule $schedule)
    {
        if (app($schedule->class_runner) instanceof ScheduleBuilder) {
            $classRunner = new ${$schedule->class_runner}($schedule->input_parameters);
            $classRunner->handle($schedule);
        }
    }
}
