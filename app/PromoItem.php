<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoItem extends Model
{

	public function Orders(){
		$this->belongsToMany('App\Orders');
	}

    public function getFormattedPrice(){
    	return '€ ' . number_format($this->price / 100 , 2);
    }
    
}
