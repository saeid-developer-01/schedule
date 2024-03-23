# Schedule Package

Welcome to the Schedule package!

## Getting Started

### add Command to Kernel Schedule:

add command to `app/Console/Kernel.php` in method `shedule`:

```php
$schedule->command('scheduler:run-command')->everyMinute();
```

### use:

create class for schedule and extend from: 
```\IICN\Schedule\Models\Schedule\ScheduleBuilder```

example: 

```php
<?php

use IICN\Schedule\ScheduleBuilder;

class TestRunSchedule extends ScheduleBuilder
{

    public function __construct($arg1, $arg2) {
    
    }
    public function run()
    {
        // TODO: Implement run() method.
    }
}
```

run code based on UTC:

```php
use IICN\Schedule\TaskScheduler;

TaskScheduler::do(TestRunSchedule::class, [$arg1, $arg2])->at('2024-02-02 20:28', "UTC");
```


run code in multi timezone:

```php
use IICN\Schedule\TaskScheduler;

TaskScheduler::do(TestRunSchedule::class, [$arg1, $arg2])->at('2024-02-02 20:28', ["UTC", "Tehran"]);
```


run code in all timezones:

```php
use IICN\Schedule\TaskScheduler;

TaskScheduler::do(TestRunSchedule::class, [$arg1, $arg2])->at('2024-02-02 20:28');
```
