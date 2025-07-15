<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Desiderata extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'choosen_date',
        'shift_start',
        'shift_end',
        'is_splittable'
    ];
    public function caissier(): BelongsTo
    {
        # code...
        return $this->belongsTo(User::class, "user_id");
    }
}
