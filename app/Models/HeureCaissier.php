<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeureCaissier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_hours',
        'total_hours',
    ];

    protected $casts = [
        'date_hours' => 'date',
        'total_hours' => 'decimal:2',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope to get records for specific month and year
     */
    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('date_hours', $year)->whereMonth('date_hours', $month);
    }

    /**
     * Format date attribute to show only year-month
     */
    public function getMonthYearAttribute()
    {
        return $this->date_hours->format('Y-m');
    }
}
