<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indicator extends Model
{
    protected $fillable = [
        'unit_id',
        'name',
        'target_percentage',
        'type',
        'is_active'
    ];

    protected $casts = [
        'target_percentage' => 'decimal:2',
        'is_active' => 'boolean'
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

    // Get active formula
    public function activeFormula()
    {
        return $this->formulas()->where('is_active', true)->first();
    }
} 