<?php

use Carbon\CarbonImmutable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropIndex(['scheduled_at']);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->renameColumn('patient_id', 'user_id');
            $table->date('appointment_date')->nullable();
            $table->time('appointment_time')->nullable();
        });

        DB::table('appointments')
            ->select(['id', 'scheduled_at'])
            ->orderBy('id')
            ->chunkById(500, function ($appointments): void {
                foreach ($appointments as $appointment) {
                    $scheduledAt = CarbonImmutable::parse($appointment->scheduled_at);

                    DB::table('appointments')
                        ->where('id', $appointment->id)
                        ->update([
                            'appointment_date' => $scheduledAt->toDateString(),
                            'appointment_time' => $scheduledAt->format('H:i:s'),
                        ]);
                }
            });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('scheduled_at');
            $table->date('appointment_date')->nullable(false)->change();
            $table->time('appointment_time')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index(['user_id', 'appointment_date']);
            $table->index(['appointment_date', 'status']);
        });

        DB::table('appointments')
            ->whereIn('status', ['pending', 'confirmed'])
            ->select(['id', 'appointment_date', 'appointment_time', 'created_at', 'updated_at'])
            ->orderBy('id')
            ->chunkById(500, function ($appointments): void {
                DB::table('appointment_slot_reservations')->insertOrIgnore(
                    $appointments->map(static fn (object $appointment): array => [
                        'appointment_date' => $appointment->appointment_date,
                        'appointment_time' => $appointment->appointment_time,
                        'appointment_id' => $appointment->id,
                        'created_at' => $appointment->created_at,
                        'updated_at' => $appointment->updated_at,
                    ])->all(),
                );
            });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id', 'appointment_date']);
            $table->dropIndex(['appointment_date', 'status']);
            $table->dateTime('scheduled_at')->nullable();
        });

        DB::table('appointments')
            ->select(['id', 'appointment_date', 'appointment_time'])
            ->orderBy('id')
            ->chunkById(500, function ($appointments): void {
                foreach ($appointments as $appointment) {
                    $scheduledAt = CarbonImmutable::parse(
                        $appointment->appointment_date.' '.$appointment->appointment_time,
                    );

                    DB::table('appointments')
                        ->where('id', $appointment->id)
                        ->update(['scheduled_at' => $scheduledAt->format('Y-m-d H:i:s')]);
                }
            });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['appointment_date', 'appointment_time']);
            $table->renameColumn('user_id', 'patient_id');
            $table->dateTime('scheduled_at')->nullable(false)->change();
            $table->foreign('patient_id')->references('id')->on('users')->restrictOnDelete();
            $table->index('scheduled_at');
        });
    }
};
