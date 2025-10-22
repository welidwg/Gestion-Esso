<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockCarburant extends Model
{
    use HasFactory;
    protected $fillable = ['date_stock', 'carburant', 'stock_reel'];
}
