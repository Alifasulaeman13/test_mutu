<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;

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

    public function index()
    {
        // Initialize default values
        $stats = $this->getDefaultStats();
        $labels = [];
        $data = [];
        $error = null;
        $debug = [
            'raw_indicators' => [],
            'raw_monthly' => []
        ];

        try {
            // Debug database connection
            $dbName = DB::connection()->getDatabaseName();
            Log::info("Database connection", ['database' => $dbName]);

            // Get raw data first to verify
            $debug['raw_indicators'] = DB::select("SELECT * FROM indicators") ?? [];
            $debug['raw_monthly'] = DB::select("SELECT * FROM monthly_indicator_data") ?? [];
            
            Log::info("Raw data check", [
                'indicators_count' => count($debug['raw_indicators']),
                'monthly_data_count' => count($debug['raw_monthly']),
                'first_indicator' => $debug['raw_indicators'][0] ?? null,
                'first_monthly' => $debug['raw_monthly'][0] ?? null
            ]);

            // Get total indicators
            $totalQuery = DB::select("SELECT COUNT(*) as total FROM indicators");
            $stats['total_indicators'] = $totalQuery[0]->total ?? 0;
            
            // Get active indicators
            $activeQuery = DB::select("SELECT COUNT(*) as total FROM indicators WHERE is_active = 1");
            $stats['active_indicators'] = $activeQuery[0]->total ?? 0;
            
            // Get achievement counts
            $achievementQuery = DB::select("
                SELECT 
                    COUNT(CASE WHEN achievement_percentage >= 80 THEN 1 END) as above_target,
                    COUNT(CASE WHEN achievement_percentage < 80 THEN 1 END) as below_target
                FROM monthly_indicator_data
            ");
            
            $stats['above_target'] = $achievementQuery[0]->above_target ?? 0;
            $stats['below_target'] = $achievementQuery[0]->below_target ?? 0;

            Log::info("Stats calculated", ['stats' => $stats]);

            // Get chart data
            $chartQuery = DB::select("
                SELECT 
                    DATE_FORMAT(date, '%M %Y') as month_year,
                    MONTH(date) as month_num,
                    ROUND(AVG(achievement_percentage), 2) as avg_achievement
                FROM monthly_indicator_data
                WHERE YEAR(date) = YEAR(CURRENT_DATE())
                GROUP BY month_year, MONTH(date)
                ORDER BY MONTH(date) ASC
            ");

            $labels = array_column($chartQuery, 'month_year');
            $data = array_column($chartQuery, 'avg_achievement');

            Log::info("Chart data prepared", [
                'labels' => $labels,
                'data' => $data
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
        return view('dashboard', compact('stats', 'labels', 'data', 'error', 'debug'));
    }
} 