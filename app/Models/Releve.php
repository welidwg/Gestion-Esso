<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        "client_comptePdf",
        "totalPdf",
        "qte_sp98",
        "qte_sp95",
        "qte_denergie",
        "qte_diesel",
        "qte_gpl",
        "qte_petrol",
        "qte_gnr",
        "diff",
        "explication",
    ];

    public function caissier(): BelongsTo
    {
        # code...
        return $this->belongsTo(User::class, "user_id");
    }
}
