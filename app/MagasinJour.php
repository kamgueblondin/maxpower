<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MagasinJour extends Model
{
    protected $fillable = [
        'magasin_id', 'description', 'actif',
    ];
	public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }
    public function historiques()
    {
        return $this->hasMany(MagasinHistorique::class);
    }
    public function entrees()
    {
        return $this->hasMany(EntreeMagasin::class);
    }
    public function sortieMagasins()
    {
        return $this->hasMany(SortieMagasinMagasin::class);
    }
    public function sortieBoutiques()
    {
        return $this->hasMany(SortieMagasinBoutique::class);
    }
}
