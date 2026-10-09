<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RegistrationChartTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_registration_chart_returns_daily_counts_for_the_last_seven_days(): void
    {
        $this->travelTo(now()->setDate(2026, 10, 9)->setTime(12, 0));

        User::factory()->create([
            'created_at' => now()->subDays(6)->startOfDay(),
            'updated_at' => now(),
        ]);
        User::factory()->create([
            'created_at' => now()->startOfDay(),
            'updated_at' => now(),
        ]);
        User::factory()->create([
            'created_at' => now()->subDays(7),
            'updated_at' => now(),
        ]);
        User::factory()->create([
            'created_at' => now()->addDay(),
            'updated_at' => now()->addDay(),
        ]);

        $response = $this->getJson(route('dashboard.registration-chart'));

        $response->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private')
            ->assertJsonPath('total', 2)
            ->assertJsonPath('days', [
                ['date' => '2026-10-03', 'count' => 1],
                ['date' => '2026-10-04', 'count' => 0],
                ['date' => '2026-10-05', 'count' => 0],
                ['date' => '2026-10-06', 'count' => 0],
                ['date' => '2026-10-07', 'count' => 0],
                ['date' => '2026-10-08', 'count' => 0],
                ['date' => '2026-10-09', 'count' => 1],
            ]);
    }

    public function test_home_page_displays_the_registration_chart(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Pendaftaran akun')
            ->assertSee('data-registration-chart', false)
            ->assertSee(route('dashboard.registration-chart'), false);
    }
}
