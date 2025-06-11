<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicatorFormula extends Model
{
    protected $fillable = [
        'indicator_id',
        'name',
        'numerator_label',
        'numerator_type',
        'denominator_label',
        'denominator_type',
        'calculation_type',
        'multiplier',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'multiplier' => 'decimal:2'
    ];

    // Relationship with Indicator
    public function indicator(): BelongsTo
    {
        return $this->belongsTo(Indicator::class);
    }

    // Calculate result based on formula expression
    public function calculateResult($numerator, $denominator)
    {
        // Konversi input sesuai tipe
        $num = $this->convertValue($numerator, $this->numerator_type);
        $den = $this->convertValue($denominator, $this->denominator_type);
        
        if ($den == 0) return 0;
        
        // Hitung sesuai tipe perhitungan
        $result = match($this->calculation_type) {
            'percentage' => ($num / $den) * $this->multiplier,
            'ratio' => $num / $den,
            'average' => $num / $den,
            default => 0
        };

        return round($result, 2);
    }

    private function convertValue($value, $type)
    {
        return match($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
            'count', 'sum' => floatval($value),
            default => 0
        };
    }
} 