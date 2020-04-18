<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoutiqueJour extends Model
{
    protected $fillable = [
        'boutique_id', 'description', 'actif',
    ];
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    public function historiques()
    {
        return $this->hasMany(BoutiqueHistorique::class);
    }
    public function sortieMagasins()
    {
        return $this->hasMany(SortieBoutiqueMagasin::class);
    }
    public function ventes()
    {
        return $this->hasMany(VenteBoutique::class);
    }
    public function soldes()
    {
        return $this->hasMany(SoldeBoutique::class);
    }
    public function charges()
    {
        return $this->hasMany(ChargeBoutique::class);
    }
    public function tontines()
    {
        return $this->hasMany(TontineBoutique::class);
    }
    public function versements()
    {
        return $this->hasMany(VersementBoutique::class);
    }
    public function dettes()
    {
        return $this->hasMany(DetteBoutique::class);
    }
}
