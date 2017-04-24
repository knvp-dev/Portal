<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KantoorOrder extends Model
{

	public function user(){
		return $this->hasOne('App\User','id','user_id');
	}

    public function products(){
    	return $this->belongsToMany('App\KantoorItem','kantooritem_kantoororder', 'kantoororder_id', 'kantooritem_id')->withPivot('amount','status');
    }

}
