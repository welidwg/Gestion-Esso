<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Compte
 *
 * @property $id
 * @property $montant
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Compte extends Model
{
    
    static $rules = [
		'montant' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['montant'];



}
