<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementFournisseur extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'fournisseur', 'montant_ttc', 'mode_de_paiement'];
}
