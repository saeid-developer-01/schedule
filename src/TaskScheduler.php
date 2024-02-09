<?php
namespace IICN\Schedule;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \IICN\Schedule\Services\Scheduler do(string $class, array $parameters = [])
 * @method static \IICN\Schedule\Services\Scheduler at(string $dateTime, string|array $timezone = null)
 *
 * @see \IICN\Schedule\Services\Scheduler
 */
class TaskScheduler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'scheduler';
    }
}
