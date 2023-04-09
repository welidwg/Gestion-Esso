<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeureTravail extends Model
{
    use HasFactory;
    protected $fillable = ["user_id", "heures"];

    public function caissier(): BelongsTo
    {
        # code...
        return $this->belongsTo(User::class, "user_id");
    }
}
