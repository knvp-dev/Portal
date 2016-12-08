<?php 
namespace App\Repositories;

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
		return KantoorItem::where('stock','>',0)->get();
	}

}