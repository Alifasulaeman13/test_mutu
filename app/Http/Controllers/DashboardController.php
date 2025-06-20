<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getDefaultStats()
    {
        return [
            'total_indicators' => 0,
            'active_indicators' => 0,
            'above_target' => 0,
            'below_target' => 0
        ];
    }

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

    public function index()
    {
        // Initialize default values
        $stats = $this->getDefaultStats();
        $labels = [];
        $data = [];
        $details = [];
        $error = null;
        $debug = [
            'raw_indicators' => [],
            'raw_monthly' => []
        ];

        try {
            // Debug database connection
            $dbName = DB::connection()->getDatabaseName();
            Log::info("Database connection", ['database' => $dbName]);

            // Get user's unit ID if not admin
            $isAdmin = auth()->user()->isAdmin();
            $unitId = !$isAdmin ? auth()->user()->unit_id : null;

            // Base query for indicators
            $indicatorQuery = DB::table('indicators');
            if ($unitId) {
                $indicatorQuery->where('unit_id', $unitId);
            }

            // Get raw data first to verify
            $debug['raw_indicators'] = $indicatorQuery->get() ?? [];
            
            // Get monthly data query
            $monthlyQuery = DB::table('monthly_indicator_data')
                ->join('indicators', 'monthly_indicator_data.indicator_id', '=', 'indicators.id');
            if ($unitId) {
                $monthlyQuery->where('indicators.unit_id', $unitId);
            }
            $debug['raw_monthly'] = $monthlyQuery->get() ?? [];
            
            Log::info("Raw data check", [
                'indicators_count' => count($debug['raw_indicators']),
                'monthly_data_count' => count($debug['raw_monthly']),
                'first_indicator' => $debug['raw_indicators'][0] ?? null,
                'first_monthly' => $debug['raw_monthly'][0] ?? null,
                'unit_id' => $unitId,
                'is_admin' => $isAdmin
            ]);

            // Get total indicators
            $stats['total_indicators'] = $indicatorQuery->count() ?? 0;
            
            // Get active indicators
            $stats['active_indicators'] = $indicatorQuery->where('is_active', true)->count() ?? 0;
            
            // Get achievement counts for the current year
            $currentYear = date('Y');
            $achievementQuery = $monthlyQuery
                ->whereYear('date', $currentYear)
                ->select(
                    DB::raw('COUNT(CASE WHEN achievement_percentage >= 80 THEN 1 END) as above_target'),
                    DB::raw('COUNT(CASE WHEN achievement_percentage < 80 THEN 1 END) as below_target')
                )->first();
            
            $stats['above_target'] = $achievementQuery->above_target ?? 0;
            $stats['below_target'] = $achievementQuery->below_target ?? 0;

            Log::info("Stats calculated", ['stats' => $stats]);

            // Generate array of all months in current year
            $allMonths = $this->generateMonthsArray($currentYear);

            // Create a CTE (Common Table Expression) for monthly averages
            $monthlyData = DB::table('monthly_indicator_data as m')
                ->join('indicators as i', 'm.indicator_id', '=', 'i.id')
                ->select(
                    DB::raw('EXTRACT(MONTH FROM date) as month_num'),
                    DB::raw('TO_CHAR(date, \'Month YYYY\') as month_year'),
                    DB::raw('ROUND(AVG(achievement_percentage)::numeric, 2) as avg_achievement'),
                    DB::raw('STRING_AGG(CONCAT(i.name, \':\', ROUND(achievement_percentage::numeric, 2)), \'|\') as indicator_details')
                )
                ->whereYear('date', $currentYear);

            if ($unitId) {
                $monthlyData->where('i.unit_id', $unitId);
            }

            $monthlyData = $monthlyData
                ->groupBy(
                    DB::raw('EXTRACT(MONTH FROM date)'),
                    DB::raw('TO_CHAR(date, \'Month YYYY\')')
                )
                ->get();

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
            foreach ($mergedData as $item) {
                $labels[] = $item['month_year'];
                $data[] = $item['avg_achievement'];
                
                // Parse indicator details
                $itemDetails = [];
                if (!empty($item['indicator_details'])) {
                    $itemDetails = collect(explode('|', $item['indicator_details']))
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
                $details[] = $itemDetails;
            }

            Log::info("Chart data prepared", [
                'labels' => $labels,
                'data' => $data,
                'details' => $details
            ]);

        } catch (\Exception $e) {
            Log::error("Dashboard error", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            $error = $e->getMessage();
        }

        // Debug final data before view
        Log::info("Final data for view", [
            'stats' => $stats,
            'labels' => $labels,
            'data' => $data,
            'has_stats' => !empty($stats),
            'has_labels' => !empty($labels),
            'has_data' => !empty($data),
            'has_error' => !empty($error)
        ]);

        // Always return view with data, whether it succeeded or failed
        return view('dashboard', compact('stats', 'labels', 'data', 'details', 'error', 'debug'));
    }
} 