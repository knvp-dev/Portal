<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeursOrder extends Model
{
    public function products(){
    	return $this->belongsToMany('App\BeursItem','beursitem_beursorder', 'beursorder_id', 'beursitem_id')->withPivot('amount','status');
    }

    public function unavailability(){
    	return $this->hasMany('App\Unavailability','order_id');
    }

    public function user(){
		return $this->hasOne('App\user','id','user_id');
	}
}
