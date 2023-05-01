<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactureCaissier extends Model
{
    use HasFactory;
    

    public function caissier():BelongsTo
    {
       
        return $this->belongsTo(User::class,"user_id");
    }
}
