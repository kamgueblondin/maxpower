<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoutiqueHistorique extends Model
{
    protected $fillable = [
       'boutique_jour_id', 'boutique_id', 'description', 'entite',
    ];
	public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    public function jour()
    {
        return $this->belongsTo(BoutiqueJour::class,'boutique_jour_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}