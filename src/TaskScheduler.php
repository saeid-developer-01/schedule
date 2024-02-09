<?php
namespace IICN\Schedule;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \IICN\Subscription\Services\Subscription command(string $class, array $parameters = [])
 * @method static \IICN\Subscription\Services\Subscription inTimezone(string $timezone)
 * @method static \IICN\Subscription\Services\Subscription inAllTimezone()
 * @method static \IICN\Subscription\Services\Subscription call($callbackFunction)
 *
 * @see \IICN\Subscription\Services\Subscription
 */
class TaskScheduler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'scheduler';
    }
}
