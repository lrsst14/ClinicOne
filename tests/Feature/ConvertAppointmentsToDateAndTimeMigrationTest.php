<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ConvertAppointmentsToDateAndTimeMigrationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_existing_appointments_are_converted_and_active_slots_are_reserved(): void
    {
        $patient = User::factory()->create();
        Schema::dropIfExists('appointment_slot_reservations');
        Schema::dropIfExists('appointments');

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->restrictOnDelete();
            $table->dateTime('scheduled_at')->index();
            $table->string('status', 20)->default('pending');
            $table->text('complaint')->nullable();
            $table->timestamps();
        });

        $pendingAppointmentId = DB::table('appointments')->insertGetId([
            'patient_id' => $patient->id,
            'scheduled_at' => '2026-10-12 09:30:00',
            'status' => 'pending',
            'complaint' => 'Demam dan pusing.',
            'created_at' => '2026-10-01 08:00:00',
            'updated_at' => '2026-10-01 08:00:00',
        ]);
        $rejectedAppointmentId = DB::table('appointments')->insertGetId([
            'patient_id' => $patient->id,
            'scheduled_at' => '2026-10-12 10:00:00',
            'status' => 'rejected',
            'complaint' => null,
            'created_at' => '2026-10-01 08:00:00',
            'updated_at' => '2026-10-01 08:00:00',
        ]);

        Schema::create('appointment_slot_reservations', function (Blueprint $table) {
            $table->id();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->foreignId('appointment_id')->nullable()->unique()->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['appointment_date', 'appointment_time']);
        });

        $migration = require database_path('migrations/2026_10_11_101408_convert_appointments_to_date_and_time.php');
        $migration->up();

        $this->assertFalse(Schema::hasColumn('appointments', 'patient_id'));
        $this->assertFalse(Schema::hasColumn('appointments', 'scheduled_at'));
        $this->assertDatabaseHas('appointments', [
            'id' => $pendingAppointmentId,
            'user_id' => $patient->id,
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:30:00',
            'complaint' => 'Demam dan pusing.',
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('appointments', [
            'id' => $rejectedAppointmentId,
            'user_id' => $patient->id,
            'appointment_date' => '2026-10-12',
            'appointment_time' => '10:00:00',
            'complaint' => null,
            'status' => 'rejected',
        ]);
        $this->assertDatabaseHas('appointment_slot_reservations', [
            'appointment_id' => $pendingAppointmentId,
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:30:00',
        ]);
        $this->assertDatabaseMissing('appointment_slot_reservations', [
            'appointment_id' => $rejectedAppointmentId,
        ]);

        $migration->down();

        $this->assertTrue(Schema::hasColumn('appointments', 'patient_id'));
        $this->assertTrue(Schema::hasColumn('appointments', 'scheduled_at'));
        $this->assertDatabaseHas('appointments', [
            'id' => $pendingAppointmentId,
            'patient_id' => $patient->id,
            'scheduled_at' => '2026-10-12 09:30:00',
            'complaint' => 'Demam dan pusing.',
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('appointments', [
            'id' => $rejectedAppointmentId,
            'patient_id' => $patient->id,
            'scheduled_at' => '2026-10-12 10:00:00',
            'complaint' => null,
            'status' => 'rejected',
        ]);
    }
}
