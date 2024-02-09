<?php

namespace IICN\Schedule;

use IICN\Schedule\Models\Schedule;

abstract class ScheduleBuilder
{
    public Schedule $schedule;

    public string|null $timezone = null;

    public function handle(Schedule $schedule)
    {
        $this->schedule = $schedule;

        $this->timezone = $schedule->timezone;

        $this->run();

        $this->onTaskCompleted();
    }

    private function onTaskCompleted()
    {
        if ($this->schedule->just_once || !$this->schedule->cron) {
            $this->schedule->enabled = false;
            $this->schedule->save();
        } else {
            $this->schedule->next_run = \Cron\CronExpression::factory($this->schedule->cron)->getNextRunDate()->format('Y-m-d H:i');
            $this->schedule->save();
        }
    }

    abstract public function run();
}
