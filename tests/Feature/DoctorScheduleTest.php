<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DoctorScheduleTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_doctor_schedule_page_requires_a_doctor_session(): void
    {
        $this->get(route('dokter.jadwal'))
            ->assertRedirect(route('dokter.login'));
    }

    public function test_schedule_write_actions_require_a_doctor_session(): void
    {
        $this->post(route('dokter.jadwal.update'))
            ->assertForbidden();

        $this->post(route('dokter.jadwal.status'), ['status' => 'closed'])
            ->assertRedirect(route('dokter.login'));

        $this->assertDatabaseCount('doctor_schedule_closures', 0);
    }

    public function test_doctor_can_save_weekly_schedule_and_patient_slots_follow_it(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-10 07:00:00', Appointment::TIMEZONE));
        $patient = User::factory()->create();

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->post(route('dokter.jadwal.update'), $this->schedulePayload([
                1 => ['is_open' => '1', 'start_time' => '09:00', 'end_time' => '10:30'],
            ]))
            ->assertRedirect(route('dokter.jadwal'))
            ->assertSessionHas('schedule_success');

        $this->assertDatabaseHas('doctor_weekly_schedules', [
            'day_of_week' => 1,
            'is_open' => true,
            'start_time' => '09:00',
            'end_time' => '10:30',
        ]);

        $this->actingAs($patient)
            ->get(route('pasien.pendaftaran', ['date' => '2026-10-12']))
            ->assertOk()
            ->assertViewHas('availableTimes', ['09:00', '09:30', '10:00']);
    }

    public function test_doctor_cannot_save_a_weekly_schedule_that_conflicts_with_an_active_appointment(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-10 07:00:00', Appointment::TIMEZONE));
        Appointment::factory()->create([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'status' => Appointment::STATUS_PENDING,
        ]);

        $this->withSession(['doctor_authenticated' => true])
            ->from(route('dokter.jadwal'))
            ->post(route('dokter.jadwal.update'), $this->schedulePayload([
                1 => ['is_open' => '1', 'start_time' => '10:00', 'end_time' => '12:00'],
            ]))
            ->assertRedirect(route('dokter.jadwal'))
            ->assertSessionHasErrors([
                'schedule' => 'Perubahan jam berbenturan dengan janji pasien yang masih aktif.',
            ]);

        $this->assertDatabaseHas('doctor_weekly_schedules', [
            'day_of_week' => 1,
            'is_open' => true,
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
        ]);
    }

    public function test_doctor_cannot_save_a_schedule_with_end_time_before_start_time(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-10 07:00:00', Appointment::TIMEZONE));

        $this->withSession(['doctor_authenticated' => true])
            ->from(route('dokter.jadwal'))
            ->post(route('dokter.jadwal.update'), $this->schedulePayload([
                1 => ['is_open' => '1', 'start_time' => '12:00', 'end_time' => '09:00'],
            ]))
            ->assertRedirect(route('dokter.jadwal'))
            ->assertSessionHasErrors('schedule');

        $this->assertDatabaseHas('doctor_weekly_schedules', [
            'day_of_week' => 1,
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
        ]);
    }

    public function test_closing_today_disables_only_today_and_can_be_reopened(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-12 07:00:00', Appointment::TIMEZONE));
        $patient = User::factory()->create();

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->post(route('dokter.jadwal.status'), ['status' => 'closed'])
            ->assertRedirect(route('dokter.jadwal'))
            ->assertSessionHas('schedule_success');

        $this->assertDatabaseCount('doctor_schedule_closures', 1);

        $this->actingAs($patient)
            ->get(route('pasien.pendaftaran', ['date' => '2026-10-12']))
            ->assertOk()
            ->assertViewHas('availableTimes', []);

        $this->get(route('pasien.pendaftaran', ['date' => '2026-10-13']))
            ->assertOk()
            ->assertViewHas('availableTimes', fn (array $times): bool => count($times) === 8);

        $this->withSession(['doctor_authenticated' => true])
            ->post(route('dokter.jadwal.status'), ['status' => 'open'])
            ->assertRedirect(route('dokter.jadwal'))
            ->assertSessionHas('schedule_success');

        $this->assertDatabaseCount('doctor_schedule_closures', 0);

        $this->get(route('pasien.pendaftaran', ['date' => '2026-10-12']))
            ->assertOk()
            ->assertViewHas('availableTimes', fn (array $times): bool => count($times) === 8);
    }

    public function test_doctor_cannot_open_practice_on_a_weekly_day_off(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-11 07:00:00', Appointment::TIMEZONE));

        $this->withSession(['doctor_authenticated' => true])
            ->from(route('dokter.jadwal'))
            ->post(route('dokter.jadwal.status'), ['status' => 'open'])
            ->assertRedirect(route('dokter.jadwal'))
            ->assertSessionHasErrors([
                'status' => 'Hari ini libur sesuai jadwal praktik mingguan.',
            ]);

        $this->assertDatabaseCount('doctor_schedule_closures', 0);
    }

    public function test_doctor_schedule_page_displays_dynamic_today_status_and_slots(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-12 07:00:00', Appointment::TIMEZONE));
        $appointment = Appointment::factory()->create([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '08:30',
            'status' => Appointment::STATUS_PENDING,
        ]);
        DB::table('appointment_slot_reservations')->insert([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '08:30',
            'appointment_id' => $appointment->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.jadwal'))
            ->assertOk()
            ->assertSee('Status Praktik')
            ->assertSee('OPEN')
            ->assertSee('08:00 – 12:00')
            ->assertSee('Sudah ada janji')
            ->assertViewHas('availableSlotCount', 7)
            ->assertViewHas('reservedSlotCount', 1);
    }

    /**
     * @param  array<int, array{is_open: string, start_time: string, end_time: string}>  $overrides
     * @return array{schedule: array<int, array{is_open: string, start_time: string, end_time: string}>}
     */
    private function schedulePayload(array $overrides = []): array
    {
        $schedule = [];

        foreach (range(1, 7) as $dayOfWeek) {
            $isOpen = $dayOfWeek <= 5;
            $schedule[$dayOfWeek] = [
                'is_open' => $isOpen ? '1' : '0',
                'start_time' => $isOpen ? '08:00' : '',
                'end_time' => match ($dayOfWeek) {
                    1, 2, 3, 4 => '12:00',
                    5 => '11:00',
                    default => '',
                },
            ];
        }

        foreach ($overrides as $dayOfWeek => $values) {
            $schedule[$dayOfWeek] = $values;
        }

        return ['schedule' => $schedule];
    }
}
