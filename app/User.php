<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
    'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'password', 'remember_token',
    ];

    protected $casts = [
        'admin' => 'boolean',
    ];

    public function isAdmin()
    {
        return $this->admin;
    }

    public function isDm(){
        return $this->dm;
    }

    public function openPromoOrders(){
        return $this->hasMany("App\PromoOrder")->where('completed',0);
    }

    public function openKantoorOrders(){
        return $this->hasMany("App\KantoorOrder")->where('completed',0);
    }

    public function unavailability(){
        return $this->hasMany('App\Unavailability', 'user_id');
    }

}
