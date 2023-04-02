<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kiosque extends Model
{
    use HasFactory;
    protected $fillable = ["user_id", "date_today", "date_d", "date_f", "espece", "carte_bleu", "carte_pro", "cheque", "boutique", "compte_provisoir", "litres"];
}
