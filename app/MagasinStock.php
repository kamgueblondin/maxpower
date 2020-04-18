<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MagasinStock extends Model
{
    protected $fillable = [
        'produit_id', 'magasin_id',  'initial', 'valeur',
    ];
	public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }
	public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
