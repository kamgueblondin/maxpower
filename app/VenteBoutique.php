<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenteBoutique extends Model
{
    protected $fillable = [
       'boutique_jour_id', 'boutique_id', 'facture_boutique_id', 'boutique_stock_id', 'user_id', 'prix', 'quantite',
    ];
	public function myBoutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    public function facture()
    {
        return $this->belongsTo(FactureBoutique::class,'facture_boutique_id');
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
