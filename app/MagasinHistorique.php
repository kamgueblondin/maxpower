<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MagasinHistorique extends Model
{
    protected $fillable = [
       'magasin_jour_id', 'magasin_id', 'description', 'entite',
    ];
	public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }
    public function jour()
    {
        return $this->belongsTo(MagasinJour::class,'magasin_jour_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
