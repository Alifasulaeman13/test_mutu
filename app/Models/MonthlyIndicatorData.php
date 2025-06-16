<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MonthlyIndicatorData extends Model
{
    use HasFactory;

    protected $table = 'monthly_indicator_data';
    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'numerator' => 'integer',
        'denominator' => 'integer',
        'achievement_percentage' => 'decimal:2'
    ];

    // Relasi ke model Indicator
    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }

    // Accessor untuk mendapatkan bulan dalam format nama
    public function getMonthNameAttribute()
    {
        return Carbon::parse($this->date)->format('F');
    }

    // Accessor untuk mendapatkan tahun
    public function getYearAttribute()
    {
        return Carbon::parse($this->date)->year;
    }

    // Accessor untuk mendapatkan bulan (angka)
    public function getMonthNumberAttribute()
    {
        return Carbon::parse($this->date)->month;
    }

    // Scope untuk filter berdasarkan bulan
    public function scopeMonth($query, $month)
    {
        return $query->whereMonth('date', $month);
    }

    // Scope untuk filter berdasarkan tahun
    public function scopeYear($query, $year)
    {
        return $query->whereYear('date', $year);
    }

    // Scope untuk filter berdasarkan periode
    public function scopePeriod($query, $month, $year)
    {
        return $query->month($month)->year($year);
    }
} 