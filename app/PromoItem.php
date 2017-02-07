<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoItem extends Model
{

	protected $guarded = ["id"];

	public function Orders(){
		$this->belongsToMany('App\PromoOrder','promoitem_promoorder', 'promoorder_id', 'promoitem_id')->withPivot('amount','status');
	}

    public function getFormattedPrice(){
    	return '€ ' . number_format($this->price / 100 , 2);
    }
    
}
