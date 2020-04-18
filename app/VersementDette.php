<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VersementDette extends Model
{
    protected $fillable = [
       'dette_boutique_id', 'montant', 'description', 'user_id',
    ];
    public function dette()
    {
        return $this->belongsTo(DetteBoutique::class,'dette_boutique_id');
    }
}
