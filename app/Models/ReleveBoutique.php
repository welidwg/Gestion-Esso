<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReleveBoutique extends Model
{
    use HasFactory;
    protected $fillable = [
        "releve_id",
        "espece",
        "carte_bleue",
        "cheque",
        "client_compte",
        "divers",
        "cigarettes_qte",
        "cigarettes_recette"
    ];

    public function releve(): BelongsTo
    {
        return $this->belongsTo(Releve::class, "releve_id");
    }
}
