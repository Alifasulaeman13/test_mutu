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
    private function generateMonthsArray($year)
    {
        $months = [];
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::createFromDate($year, $month, 1);
            $months[] = [
                'month_year' => $date->format('F Y'),
                'month_num' => $month,
                'avg_achievement' => 0,
                'indicator_details' => ''
            ];
        }
        return $months;
    }

    public function getChartData(Request $request)
    {
        try {
            // Log incoming request parameters
            Log::info('Filter parameters received', [
                'year' => $request->input('year'),
                'unit_id' => $request->input('unit_id'),
                'all_parameters' => $request->all()
            ]);

            $year = $request->input('year', Carbon::now()->year);
            
            // Generate array of all months
            $allMonths = $this->generateMonthsArray($year);
            
            // Log query parameters
            Log::info('Query parameters', [
                'year' => $year,
                'unit_id' => $request->input('unit_id')
            ]);

            // Create a CTE (Common Table Expression) for monthly averages
            $monthlyData = DB::table('monthly_indicator_data as m')
                ->join('indicators as i', 'm.indicator_id', '=', 'i.id')
                ->select(
                    DB::raw('EXTRACT(MONTH FROM date) as month_num'),
                    DB::raw('TO_CHAR(date, \'Month YYYY\') as month_year'),
                    DB::raw('ROUND(AVG(achievement_percentage)::numeric, 2) as avg_achievement'),
                    DB::raw('STRING_AGG(CONCAT(i.name, \':\', ROUND(achievement_percentage::numeric, 2)), \'|\') as indicator_details')
                )
                ->whereYear('date', $year);

            // Filter by unit if unit_id is provided (for non-admin users)
            if ($request->has('unit_id')) {
                $monthlyData->where('i.unit_id', $request->input('unit_id'));
            }

            $monthlyData = $monthlyData
                ->groupBy(
                    DB::raw('EXTRACT(MONTH FROM date)'),
                    DB::raw('TO_CHAR(date, \'Month YYYY\')')
                )
                ->get();

            // Log raw monthly data
            Log::info('Raw monthly data', [
                'data' => $monthlyData,
                'count' => $monthlyData->count()
            ]);

            // Merge actual data with all months array
            $mergedData = collect($allMonths)->map(function($month) use ($monthlyData) {
                $actualData = $monthlyData->first(function($item) use ($month) {
                    return $item->month_num == $month['month_num'];
                });

                if ($actualData) {
                    $month['avg_achievement'] = (float)$actualData->avg_achievement;
                    $month['indicator_details'] = $actualData->indicator_details;
                }

                return $month;
            })->sortBy('month_num');

            // Format final data
            $formattedData = $mergedData->map(function($item) {
                // Parse indicator details safely
                $details = [];
                if (!empty($item['indicator_details'])) {
                    $details = collect(explode('|', $item['indicator_details']))
                        ->map(function($detail) {
                            $parts = explode(':', $detail);
                            return [
                                'name' => $parts[0] ?? '',
                                'value' => isset($parts[1]) ? (float)$parts[1] : 0
                            ];
                        })
                        ->sortByDesc('value')
                        ->values()
                        ->toArray();
                }

                return [
                    'month_year' => $item['month_year'],
                    'avg_achievement' => $item['avg_achievement'],
                    'details' => $details
                ];
            });

            $labels = $formattedData->pluck('month_year')->toArray();
            $chartData = $formattedData->pluck('avg_achievement')->toArray();
            $details = $formattedData->pluck('details')->toArray();

            // Log final formatted data
            Log::info('Formatted chart data', [
                'labels' => $labels,
                'data' => $chartData,
                'details' => $details
            ]);

            return response()->json([
                'labels' => $labels,
                'data' => $chartData,
                'details' => $details,
                'chartConfig' => [
                    'scales' => [
                        'y' => [
                            'beginAtZero' => true,
                            'max' => 100,
                            'ticks' => [
                                'stepSize' => 25
                            ]
                        ]
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Chart data error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'error' => 'Failed to fetch chart data',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 