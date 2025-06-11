<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyIndicatorData extends Model
{
    protected $table = 'daily_indicator_data';

    protected $fillable = [
        'indicator_id',
        'date',
        'numerator',
        'denominator',
        'achievement_percentage'
    ];

    protected $casts = [
        'date' => 'date',
        'numerator' => 'integer',
        'denominator' => 'integer',
        'achievement_percentage' => 'decimal:2',
        'month' => 'integer',
        'year' => 'integer'
    ];

    // Relationship with Indicator
    public function indicator(): BelongsTo
    {
        return $this->belongsTo(Indicator::class);
    }

    // Calculate achievement percentage
    public function calculateAchievement()
    {
        if ($this->denominator > 0) {
            $this->achievement_percentage = ($this->numerator / $this->denominator) * 100;
        } else {
            $this->achievement_percentage = 0;
        }
        return $this->achievement_percentage;
    }
} 