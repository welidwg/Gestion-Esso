<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveSolde extends Model
{
    use HasFactory;
    protected $fillable=["date","solde"];
}
