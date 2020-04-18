<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'localisation', 'slogan', 'adresse', 'telephone_1', 'telephone_2', 'email', 'latitude', 'longitude', 'logo', 'numero_rc', 'boite_postale', 'fax',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_boutiques');
    }
    public function magasins()
    {
        return $this->belongsToMany(Magasin::class, 'magasin_boutiques');
    }
	public function stocks()
    {
        return $this->hasMany(BoutiqueStock::class);
    }
    public function jours()
    {
        return $this->hasMany(BoutiqueJour::class);
    }
    public function boutiques()
    {
        return $this->belongsToMany(Boutique::class, 'boutique_boutiques','boutique');
    }
    public function historiques()
    {
        return $this->hasMany(BoutiqueHistorique::class);
    }
    public function ventes()
    {
        return $this->hasMany(VenteBoutique::class);
    }
    public function soldes()
    {
        return $this->hasMany(SoldeBoutique::class);
    }
    public function factures()
    {
        return $this->hasMany(FactureBoutique::class);
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
    public function sortieMagasins()
    {
        return $this->hasMany(SortieBoutiqueMagasin::class);
    }
}
