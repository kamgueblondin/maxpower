<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SortieBoutiqueMagasin extends Model
{
    protected $fillable = [
       'boutique_jour_id', 'boutique_id', 'magasin_id', 'boutique_stock_id', 'user_id', 'quantite',
    ];
	public function myBoutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    public function autherMagasin()
    {
        return $this->belongsTo(Magasin::class,'magasin_id');
    }
    public function jour()
    {
        return $this->belongsTo(BoutiqueJour::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function stock()
    {
        return $this->belongsTo(BoutiqueStock::class,'boutique_stock_id');
    }
}
