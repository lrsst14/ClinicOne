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

        if ($day->isWeekend() || $day->lt($now->startOfDay())) {
            return [];
        }

        $reservedTimes = DB::table('appointment_slot_reservations')
            ->whereDate('appointment_date', $day->toDateString())
            ->pluck('appointment_time')
            ->map(static fn (string $time): string => substr($time, 0, 5))
            ->all();

        return self::timesForDay($day, $reservedTimes, $now);
    }

    public static function nextAvailableDate(): string
    {
        $now = CarbonImmutable::now(self::TIMEZONE);
        $date = $now->startOfDay();
        $lastDate = $date->addDays(369);
        $reservationsByDate = DB::table('appointment_slot_reservations')
            ->whereBetween('appointment_date', [$date->toDateString(), $lastDate->toDateString()])
            ->get(['appointment_date', 'appointment_time'])
            ->groupBy(static fn (object $reservation): string => CarbonImmutable::parse($reservation->appointment_date, self::TIMEZONE)->toDateString());

        for ($day = 0; $day < 370; $day++) {
            $reservedTimes = $reservationsByDate
                ->get($date->toDateString(), collect())
                ->map(static fn (object $reservation): string => substr($reservation->appointment_time, 0, 5))
                ->all();

            if (self::timesForDay($date, $reservedTimes, $now) !== []) {
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
    private static function timesForDay(CarbonImmutable $day, array $reservedTimes, CarbonImmutable $now): array
    {
        if ($day->isWeekend() || $day->lt($now->startOfDay())) {
            return [];
        }

        $closingTime = $day->setTime(8, 0)->addHours($day->isFriday() ? 3 : 4);
        $slot = $day->setTime(8, 0);
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
}
