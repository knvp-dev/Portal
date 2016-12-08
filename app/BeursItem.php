<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeursItem extends Model
{
    public function unavailability(){
    	return $this->hasMany('App\unavailability','beurs_item_id');
    }
}
