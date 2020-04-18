<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactureBoutique extends Model
{
    protected $fillable = [
       'nom', 'client', 'description', 'numero', 'boutique_id',
    ];
    public function ventes()
    {
        return $this->hasMany(VenteBoutique::class);
    }
    public function soldes()
    {
        return $this->hasMany(SoldeBoutique::class);
    }
}
