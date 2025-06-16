<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonthlyIndicatorData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardChartController extends Controller
{
    public function getChartData(Request $request)
    {
        // Log incoming request parameters
        Log::info('Filter parameters received', [
            'year' => $request->input('year'),
            'period' => $request->input('period'),
            'all_parameters' => $request->all()
        ]);

        $year = $request->input('year', Carbon::now()->year);
        $period = $request->input('period', '12');

        // Calculate start date based on period
        $endDate = Carbon::create($year, 12, 31);
        $startDate = $period === '6' 
            ? Carbon::now()->subMonths(6)->startOfMonth()
            : Carbon::create($year, 1, 1);

        $data = DB::table('monthly_indicator_data')
            ->join('indicators', 'monthly_indicator_data.indicator_id', '=', 'indicators.id')
            ->select(
                DB::raw('DATE_FORMAT(date, "%M %Y") as month_year'),
                DB::raw('MONTH(date) as month_num'),
                DB::raw('ROUND(AVG(achievement_percentage), 2) as avg_achievement'),
                DB::raw('MIN(date) as ordering_date'),
                DB::raw('GROUP_CONCAT(CONCAT(indicators.name, ":", achievement_percentage) SEPARATOR "|") as indicator_details')
            )
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('month_year', 'month_num')
            ->orderBy('ordering_date', 'asc')
            ->get();

        $formattedData = $data->map(function($item) {
            // Parse indicator details
            $details = collect(explode('|', $item->indicator_details))
                ->map(function($detail) {
                    list($name, $value) = explode(':', $detail);
                    return [
                        'name' => $name,
                        'value' => (float)$value
                    ];
                })
                ->sortByDesc('value')
                ->values();

            return [
                'month_year' => $item->month_year,
                'avg_achievement' => (float)$item->avg_achievement,
                'details' => $details
            ];
        });

        $labels = $formattedData->pluck('month_year')->toArray();
        $chartData = $formattedData->pluck('avg_achievement')->toArray();
        $details = $formattedData->pluck('details')->toArray();

        // Debug log
        Log::info('Processed chart data', [
            'labels' => $labels,
            'data' => $chartData,
            'details' => $details,
            'sample_data' => $formattedData->first()
        ]);

        return response()->json([
            'labels' => $labels,
            'data' => $chartData,
            'details' => $details
        ]);
    }
} 