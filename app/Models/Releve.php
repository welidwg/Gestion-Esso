<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Releve extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "date_systeme",
        "heure_d",
        "heure_f",
        "espece",
        "carte_bleu",
        "carte_pro",
        "cheque",
        "boutique",
        "client_compte",
        "totalSaisie",
        "especePdf",
        "carte_bleuPdf",
        "carte_proPdf",
        "chequePdf",
        "boutiquePdf",
        "client_comptePdf",
        "totalPdf",
        "diff",
        "explication",
        "vente",
        "vente_cigarette",
        "tva",
        "divers",
        "pmi",
        "fdg",
        "mode_paiement",
        "isLast"
    ];

    public function caissier(): BelongsTo
    {
        # code...
        return $this->belongsTo(User::class, "user_id");
    }
    public function boutique_recette(): HasOne
    {
        # code...
        return $this->hasOne(ReleveBoutique::class);
    }
}
