<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unavailability extends Model
{
    public function beursItem(){
    	return $this->hasOne('App\BeursItem','id','beurs_item_id');
    }

    public function order(){
    	return $this->hasOne('App\BeursOrder','id','order_id');
    }

    public function user(){
    	return $this->hasOne('App\User','id','user_id');
    }
}
