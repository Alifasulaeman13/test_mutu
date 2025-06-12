<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Indicator extends Model
{
    protected $fillable = [
        'unit_id',
        'name',
        'target_percentage',
        'type',
        'is_active',
        'reporting_start_day',
        'reporting_end_day',
        'is_period_active'
    ];

    protected $casts = [
        'target_percentage' => 'decimal:2',
        'is_active' => 'boolean',
        'reporting_start_day' => 'integer',
        'reporting_end_day' => 'integer',
        'is_period_active' => 'boolean'
    ];

    // Relationship with Unit
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    // Relationship with daily data
    public function dailyData(): HasMany
    {
        return $this->hasMany(DailyIndicatorData::class);
    }

    // Relationship with formulas
    public function formulas(): HasMany
    {
        return $this->hasMany(IndicatorFormula::class);
    }

    // Get active formula relationship
    public function activeFormula(): HasOne
    {
        return $this->hasOne(IndicatorFormula::class)->where('is_active', true);
    }

    // Check if current date is within reporting period
    public function isWithinReportingPeriod(): bool
    {
        if (!$this->is_period_active) {
            return true; // Jika periode tidak aktif, selalu bisa input
        }

        $today = now();
        $currentDay = $today->day;
        $currentMonth = $today->month;
        $currentYear = $today->year;

        // Jika hari ini di bulan yang sama dengan periode pelaporan
        if ($currentDay >= $this->reporting_start_day && $currentDay <= $this->reporting_end_day) {
            return true;
        }

        // Jika hari ini di bulan setelah periode pelaporan
        if ($currentDay < $this->reporting_start_day) {
            $lastMonth = $currentMonth - 1;
            if ($lastMonth < 1) {
                $lastMonth = 12;
                $currentYear--;
            }
            
            // Cek apakah hari ini masih dalam periode pelaporan bulan sebelumnya
            return $currentDay <= $this->reporting_end_day;
        }

        return false;
    }

    // Get current reporting period
    public function getCurrentReportingPeriod(): array
    {
        $today = now();
        $currentMonth = $today->month;
        $currentYear = $today->year;

        // Jika hari ini sebelum tanggal mulai pelaporan
        if ($today->day < $this->reporting_start_day) {
            $currentMonth--;
            if ($currentMonth < 1) {
                $currentMonth = 12;
                $currentYear--;
            }
        }

        return [
            'month' => $currentMonth,
            'year' => $currentYear,
            'start_date' => $this->reporting_start_day,
            'end_date' => $this->reporting_end_day
        ];
    }
} 