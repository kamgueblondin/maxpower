<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    protected $fillable = [
        'nom', 'localisation', 'slogan', 'adresse',
    ];

    public function boutiques()
    {
        return $this->belongsToMany(Boutique::class, 'magasin_boutiques');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_magasins');
    }
	public function stocks()
    {
        return $this->hasMany(MagasinStock::class);
    }
    public function jours()
    {
        return $this->hasMany(MagasinJour::class);
    }
    public function magasins()
    {
        return $this->belongsToMany(Magasin::class, 'magasin_magasins','magasin');
    }
    public function historiques()
    {
        return $this->hasMany(MagasinHistorique::class);
    }
    public function entrees()
    {
        return $this->hasMany(EntreeMagasin::class);
    }
    public function sortieBoutiques()
    {
        return $this->hasMany(SortieMagasinBoutique::class);
    }
    public function sortieMagasins()
    {
        return $this->hasMany(SortieMagasinMagasin::class);
    }
}
