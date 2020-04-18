<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['expediteur','contenu', 'type','vu' ,'user_id', 'recepteur'];
    protected $guarded = ['id', 'created_at'];


    public function getId() {
        return $this->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->hasOne(User::class, 'id', 'expediteur');
    }
}
