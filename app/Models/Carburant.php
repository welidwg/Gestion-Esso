<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Carburant
 *
 * @property $id
 * @property $titre
 * @property $prixA
 * @property $prixV
 * @property $qtiteStk
 * @property $qtiteJg
 * @property $seuil
 * @property $valeur_stock
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Carburant extends Model
{

    static $rules = [
        'titre' => 'required',
        'prixA' => 'required',
        'prixV' => 'required',
        'qtiteStk' => 'required',
        'qtiteJg' => 'required',
        'seuil' => 'required',
        'marge_beneficiere' => 'required',
        'valeur_stock' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['titre', 'prixA', 'prixV', 'qtiteStk', 'qtiteJg', 'seuil', 'seuilA', 'marge_beneficiere', 'valeur_stock'];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('priority', 'ASC');
        });
    }
}
