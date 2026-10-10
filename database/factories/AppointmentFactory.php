<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'appointment_date' => now()->addWeek()->toDateString(),
            'appointment_time' => '08:00',
            'complaint' => fake()->sentence(),
            'status' => Appointment::STATUS_PENDING,
        ];
    }
}
