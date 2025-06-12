<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

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

    // Relationship with monthly data
    public function monthlyData(): HasMany
    {
        return $this->hasMany(MonthlyIndicatorData::class);
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
            return false;
        }

        $now = Carbon::now();
        $currentDay = $now->day;

        return $currentDay >= $this->reporting_start_day && $currentDay <= $this->reporting_end_day;
    }

    // Get current reporting period
    public function getCurrentReportingPeriod(): array
    {
        $now = Carbon::now();
        $currentDay = $now->day;
        $currentMonth = $now->month;
        $currentYear = $now->year;

        // Jika tanggal saat ini lebih besar dari tanggal selesai pelaporan,
        // maka periode pelaporan adalah bulan berikutnya
        if ($currentDay > $this->reporting_end_day) {
            $now->addMonth();
            $currentMonth = $now->month;
            $currentYear = $now->year;
        }

        return [
            'month' => $currentMonth,
            'year' => $currentYear
        ];
    }
} 