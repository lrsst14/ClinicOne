<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\DoctorScheduleClosure;
use App\Models\DoctorWeeklySchedule;
use Carbon\CarbonImmutable;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        view()->composer([
            'dokter.dashboard',
            'dokter.janji-database',
            'dokter.kelola-janji',
            'dokter.profil',
        ], function (View $view): void {
            $today = CarbonImmutable::today(Appointment::TIMEZONE);
            $todaySchedule = DoctorWeeklySchedule::query()
                ->where('day_of_week', $today->dayOfWeekIso)
                ->first();
            $isClosedToday = DoctorScheduleClosure::query()
                ->whereDate('closed_on', $today->toDateString())
                ->exists();

            $view->with([
                'clinicIsOpenToday' => $todaySchedule?->is_open === true && ! $isClosedToday,
                'clinicTodaySchedule' => $todaySchedule,
            ]);
        });
    }
}
