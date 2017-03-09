<?php
namespace App\Repositories;

use App\PromoItem;
use App\Repositories\Contracts\MateriaalInterface;

class PromoMateriaalRepository implements MateriaalInterface{
	
	public function getAll(){
		return PromoItem::all();
	}

	public function findById($id){
		return PromoItem::whereId($id)->first();
	}

	public function findByCode($code){
		return PromoItem::whereCode($code)->first();
	}

	public function getAllItemsInStock(){
		return PromoItem::where('stock','>',0)->get();
	}

	public function AddToStock($code, $amount){
		$promoitem = $this->findByCode($code);
		$promoitem->stock += $amount;
		$promoitem->save();
		return $promoitem;
	}

	public function subtractFromStock($code, $amount){
		$promoitem = $this->findByCode($code);
		$promoitem->stock -= $amount;
		$promoitem->save();
		return $promoitem;
	}

	public function depleteStock($code){
		$promoitem = $this->findByCode($code);
		$promoitem->stock = 0;
		$promoitem->save();
		return $promoitem;
	}

}