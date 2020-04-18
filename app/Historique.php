<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    protected $fillable = ['type','action','entite', 'message','vu', 'user_id' ];
    protected $guarded = ['id', 'created_at'];

    public function getId() {
        return $this->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
