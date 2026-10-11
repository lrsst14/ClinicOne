<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorWeeklySchedule extends Model
{
    protected $fillable = [
        'day_of_week',
        'is_open',
        'start_time',
        'end_time',
    ];

    protected function casts(): array
    {
        return [
            'day_of_week' => 'integer',
            'is_open' => 'boolean',
        ];
    }
}
