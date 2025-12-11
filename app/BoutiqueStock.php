<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoutiqueStock extends Model
{
    protected $fillable = [
        'produit_id', 'boutique_id', 'initial', 'valeur','avant_inventaire','apres_inventaire',
    ];
	public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
	public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
