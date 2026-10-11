<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\AppointmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

#[Fillable(['user_id', 'appointment_date', 'appointment_time', 'complaint', 'status'])]
class Appointment extends Model
{
    public const TIMEZONE = 'Asia/Jakarta';

    /** @use HasFactory<AppointmentFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_CONFIRMED = 'confirmed';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    public const ACTIVE_STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_COMPLETED,
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function appointmentStartsAt(): CarbonImmutable
    {
        return CarbonImmutable::parse(
            $this->appointment_date->toDateString().' '.$this->appointment_time,
            self::TIMEZONE,
        );
    }

    public function canBeMarkedCompleted(): bool
    {
        return $this->appointmentStartsAt()->lessThanOrEqualTo(CarbonImmutable::now(self::TIMEZONE));
    }

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
        ];
    }

    /**
     * @return list<string>
     */
    public static function availableTimesFor(string $date): array
    {
        $day = CarbonImmutable::parse($date, self::TIMEZONE)->startOfDay();
        $now = CarbonImmutable::now(self::TIMEZONE);

        if ($day->lt($now->startOfDay()) || self::isClosedOn($day)) {
            return [];
        }

        $schedule = DB::table('doctor_weekly_schedules')
            ->where('day_of_week', $day->dayOfWeekIso)
            ->first(['is_open', 'start_time', 'end_time']);

        if (
            $schedule === null
            || ! (bool) $schedule->is_open
            || ! is_string($schedule->start_time)
            || ! is_string($schedule->end_time)
        ) {
            return [];
        }

        $reservedTimes = DB::table('appointment_slot_reservations')
            ->whereDate('appointment_date', $day->toDateString())
            ->pluck('appointment_time')
            ->map(static fn (string $time): string => substr($time, 0, 5))
            ->all();

        return self::timesForDay(
            $day,
            substr($schedule->start_time, 0, 5),
            substr($schedule->end_time, 0, 5),
            $reservedTimes,
            $now,
        );
    }

    /**
     * @return list<string>
     */
    public static function scheduledTimesFor(string $date): array
    {
        $day = CarbonImmutable::parse($date, self::TIMEZONE)->startOfDay();
        $schedule = DB::table('doctor_weekly_schedules')
            ->where('day_of_week', $day->dayOfWeekIso)
            ->first(['is_open', 'start_time', 'end_time']);

        if (
            $schedule === null
            || ! (bool) $schedule->is_open
            || ! is_string($schedule->start_time)
            || ! is_string($schedule->end_time)
        ) {
            return [];
        }

        return self::timesForDay(
            $day,
            substr($schedule->start_time, 0, 5),
            substr($schedule->end_time, 0, 5),
            [],
            CarbonImmutable::createFromTimestamp(0, self::TIMEZONE),
        );
    }

    public static function nextAvailableDate(): string
    {
        $now = CarbonImmutable::now(self::TIMEZONE);
        $date = $now->startOfDay();
        $lastDate = $date->addDays(369);
        $weeklySchedules = DB::table('doctor_weekly_schedules')
            ->get(['day_of_week', 'is_open', 'start_time', 'end_time'])
            ->keyBy('day_of_week');
        $reservationsByDate = DB::table('appointment_slot_reservations')
            ->whereBetween('appointment_date', [$date->toDateString(), $lastDate->toDateString()])
            ->get(['appointment_date', 'appointment_time'])
            ->groupBy(static fn (object $reservation): string => CarbonImmutable::parse($reservation->appointment_date, self::TIMEZONE)->toDateString());
        $closedDates = DB::table('doctor_schedule_closures')
            ->whereBetween('closed_on', [$date->toDateString(), $lastDate->toDateString()])
            ->pluck('closed_on')
            ->all();

        for ($day = 0; $day < 370; $day++) {
            $reservedTimes = $reservationsByDate
                ->get($date->toDateString(), collect())
                ->map(static fn (object $reservation): string => substr($reservation->appointment_time, 0, 5))
                ->all();
            $schedule = $weeklySchedules->get($date->dayOfWeekIso);

            if (
                ! in_array($date->toDateString(), $closedDates, true)
                && $schedule !== null
                && (bool) $schedule->is_open
                && is_string($schedule->start_time)
                && is_string($schedule->end_time)
                && self::timesForDay(
                    $date,
                    substr($schedule->start_time, 0, 5),
                    substr($schedule->end_time, 0, 5),
                    $reservedTimes,
                    $now,
                ) !== []
            ) {
                return $date->toDateString();
            }

            $date = $date->addDay();
        }

        return $date->toDateString();
    }

    /**
     * @param  list<string>  $reservedTimes
     * @return list<string>
     */
    private static function timesForDay(
        CarbonImmutable $day,
        string $startTime,
        string $endTime,
        array $reservedTimes,
        CarbonImmutable $now,
    ): array {
        if ($day->lt($now->startOfDay())) {
            return [];
        }

        $openingTime = CarbonImmutable::createFromFormat('!H:i', $startTime, self::TIMEZONE);
        $closingTime = CarbonImmutable::createFromFormat('!H:i', $endTime, self::TIMEZONE);

        if (! $openingTime instanceof CarbonImmutable || ! $closingTime instanceof CarbonImmutable) {
            return [];
        }

        $slot = $day->setTime($openingTime->hour, $openingTime->minute);
        $closingTime = $day->setTime($closingTime->hour, $closingTime->minute);
        $availableTimes = [];

        while ($slot->lt($closingTime)) {
            $time = $slot->format('H:i');

            if ($slot->greaterThan($now) && ! in_array($time, $reservedTimes, true)) {
                $availableTimes[] = $time;
            }

            $slot = $slot->addMinutes(30);
        }

        return $availableTimes;
    }

    private static function isClosedOn(CarbonImmutable $day): bool
    {
        if ($day->isToday()) {
            return DB::table('doctor_schedule_closures')
                ->whereDate('closed_on', $day->toDateString())
                ->exists();
        }

        return false;
    }
}
