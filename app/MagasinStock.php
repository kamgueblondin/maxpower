<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MagasinStock extends Model
{
    protected $fillable = [
        'produit_id', 'magasin_id',  'initial', 'valeur','avant_inventaire','apres_inventaire',
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
