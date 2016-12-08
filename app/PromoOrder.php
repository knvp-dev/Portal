<?php

namespace App;

use App\PromoItem;
use Illuminate\Database\Eloquent\Model;

class PromoOrder extends Model
{
    public function promoItems(){
    	return $this->belongsToMany('App\PromoItem','promoitem_promoorder', 'promoorder_id', 'promoitem_id')->withPivot('amount');
    }

    public function complete(){
    	$this->completed = 1;
    }
}
