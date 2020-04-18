<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
	use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The boutique that belong to the user.
     */
    public function getId() {
        return $this->id;
    }
    public function boutiques()
    {
        return $this->belongsToMany(Boutique::class, 'user_boutiques');
    }
    public function messages()
    {
        return $this->hasMany(Message::class,'recepteur');
    }
    public function magasins()
    {
        return $this->belongsToMany(Magasin::class, 'user_magasins');
    }
}
