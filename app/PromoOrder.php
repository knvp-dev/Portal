<?php

namespace App;

use App\PromoItem;
use Illuminate\Database\Eloquent\Model;

class PromoOrder extends Model
{
    public function products(){
    	return $this->belongsToMany('App\PromoItem','promoitem_promoorder', 'promoorder_id', 'promoitem_id')->withPivot('amount');
    }

    public function complete(){
    	$this->completed = 1;
    }

    public function getFormattedPrice(){
    	return '€ ' . number_format($this->total_price / 100 , 2);
    }

    public function user(){
    	return $this->hasOne('App\User');
    }
}
