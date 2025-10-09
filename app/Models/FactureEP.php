<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureEP extends Model
{
    use HasFactory;
    protected $table = "facture_ep";

    protected $fillable = [
        'nom_de_fournisseur',
        'date',
        'designation',
        'prix_unite',
        'qte',
        'prix_ht',
        'tva',
        'prix_ttc'
    ];
}
