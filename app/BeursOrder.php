<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeursOrder extends Model
{
    public function products(){
    	return $this->belongsToMany('App\BeursItem','beursitem_beursorder', 'beursorder_id', 'beursitem_id');
    }

    public function complete(){
    	$this->completed = 1;
    }
}
