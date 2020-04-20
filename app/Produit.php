<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'reference', 'nom', 'description', 'prix', 'prix_achat', 'categorie_id',
    ];
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
