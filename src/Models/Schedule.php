<?php

namespace IICN\Schedule\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'next_run', 'cron', 'year', 'class_runner', 'input_parameters', 'user_id', 'enabled', 'just_once', 'timezone'
    ];

    protected $casts = [
        'input_parameters' => 'json',
        'next_run' => 'datetime:Y-m-d H:i:00',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('enabled', function (Builder $builder) {
            $builder->where('enabled', true);
        });
    }
}
