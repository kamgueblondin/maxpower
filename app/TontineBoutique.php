<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TontineBoutique extends Model
{
    protected $fillable = [
       'boutique_jour_id', 'boutique_id', 'montant', 'description', 'user_id', 'nom',
    ];
	public function myBoutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    public function jour()
    {
        return $this->belongsTo(BoutiqueJour::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
