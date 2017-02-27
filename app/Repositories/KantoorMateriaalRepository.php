<?php 
namespace App\Repositories;

use Auth;
use App\KantoorItem;
use App\Repositories\Contracts\MateriaalInterface;

class KantoorMateriaalRepository implements MateriaalInterface{
	
	public function getAll(){
		return KantoorItem::all();
	}

	public function findById($id){
		return KantoorItem::whereId($id)->first();
	}

	public function getAllItemsInStock(){
		return KantoorItem::whereEntity(Auth::user()->entity)->orWhere('entity','ALL')->where('stock','>',0)->get();
	}

	public function findByCode($code){}
	public function AddToStock($code, $amount){}
	public function subtractFromStock($code, $amount){}
	public function depleteStock($code){}

}