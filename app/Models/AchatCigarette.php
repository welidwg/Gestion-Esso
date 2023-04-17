<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchatCigarette extends Model
{
    use HasFactory;
    protected $fillable = ["date_achat", "achat", "total"];
}
