<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationChartController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        abort_unless($request->session()->get('doctor_authenticated'), 403);

        $firstDay = today()->subDays(6)->startOfDay();
        $lastDay = now();

        $registrationsByDate = DB::table('users')
            ->selectRaw('DATE(created_at) AS registration_date, COUNT(*) AS total')
            ->whereBetween('created_at', [$firstDay, $lastDay])
            ->groupByRaw('DATE(created_at)')
            ->pluck('total', 'registration_date');

        $days = collect(range(0, 6))
            ->map(function (int $offset) use ($firstDay, $registrationsByDate): array {
                $date = $firstDay->copy()->addDays($offset)->toDateString();

                return [
                    'date' => $date,
                    'count' => (int) $registrationsByDate->get($date, 0),
                ];
            })
            ->all();

        return response()->json([
            'days' => $days,
            'total' => array_sum(array_column($days, 'count')),
            'updatedAt' => now()->toIso8601String(),
        ])->header('Cache-Control', 'no-store');
    }
}
