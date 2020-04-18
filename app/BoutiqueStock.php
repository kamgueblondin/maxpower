<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoutiqueStock extends Model
{
    protected $fillable = [
        'produit_id', 'boutique_id', 'initial', 'valeur',
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
