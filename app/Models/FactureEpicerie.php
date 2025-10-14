<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureEpicerie extends Model
{
    use HasFactory;
    protected $table = 'facture_epiceries';

    // Allow mass assignment for these fields
    protected $fillable = [
        'nom_de_fournisseur',
        'date',
        'articles',
    ];

    // Cast the articles JSON column to an array automatically
    protected $casts = [
        'articles' => 'array',
        'date' => 'date',
    ];
}
