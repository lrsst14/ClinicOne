<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_weekly_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('day_of_week')->unique();
            $table->boolean('is_open')->default(false);
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();
        });

        Schema::create('doctor_schedule_closures', function (Blueprint $table) {
            $table->id();
            $table->date('closed_on')->unique();
            $table->timestamps();
        });

        $now = now();
        $weeklySchedules = [];

        foreach (range(1, 7) as $dayOfWeek) {
            $isOpen = $dayOfWeek <= 5;
            $weeklySchedules[] = [
                'day_of_week' => $dayOfWeek,
                'is_open' => $isOpen,
                'start_time' => $isOpen ? '08:00:00' : null,
                'end_time' => match ($dayOfWeek) {
                    1, 2, 3, 4 => '12:00:00',
                    5 => '11:00:00',
                    default => null,
                },
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('doctor_weekly_schedules')->insert($weeklySchedules);
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedule_closures');
        Schema::dropIfExists('doctor_weekly_schedules');
    }
};
