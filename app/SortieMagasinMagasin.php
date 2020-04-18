<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SortieMagasinMagasin extends Model
{
    protected $fillable = [
       'magasin_jour_id', 'magasin_id', 'magasin', 'magasin_stock_id', 'user_id', 'quantite',
    ];
	public function myMagasin()
    {
        return $this->belongsTo(Magasin::class);
    }
    public function autherMagasin()
    {
        return $this->belongsTo(Magasin::class,'magasin');
    }
    public function jour()
    {
        return $this->belongsTo(MagasinJour::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function stock()
    {
        return $this->belongsTo(MagasinStock::class,'magasin_stock_id');
    }
}
