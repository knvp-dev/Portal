<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KantoorOrder extends Model
{
    public function products(){
    	return $this->belongsToMany('App\KantoorItem','kantooritem_kantoororder', 'kantoororder_id', 'kantooritem_id')->withPivot('amount');
    }

    public function complete(){
    	$this->completed = 1;
    }
}
