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
                $this->info("start schedule id: " . $schedule->id);
                $this->runClass($schedule);
                $this->info("end schedule id: " . $schedule->id);
            } catch (\Exception $exception) {
                $this->error("end schedule id: " . $schedule->id . "&& error: " . $exception->getMessage());
            }
        }
    }

    protected function runClass(Schedule $schedule)
    {
        $classRunner = new $schedule->class_runner(...$schedule->input_parameters);
        if ($classRunner instanceof ScheduleBuilder) {
            $classRunner->handle($schedule);
        }
    }
}
