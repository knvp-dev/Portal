<?php 
namespace App\Repositories;

use App\KantoorOrder;
use App\KantoorItem;
use Auth;
use App\Repositories\Contracts\OrderInterface;

class KantoorOrderRepository implements OrderInterface{

	public function getAll(){
		return KantoorOrder::all();
	}

	public function findById($id){
		return KantoorOrder::whereId($id)->first();
	}

	public function getForUser(){
		return KantoorOrder::whereUserId(Auth::user()->id)->get();
	}

	public function create($orderdata){
		return $this->createNewOrder($orderdata);
	}

	public function remove($id){

	}

	private function createNewOrder($orderdata){
		$order = new KantoorOrder();
		$order->user_id = Auth::user()->id;
		$order->save();

		foreach($orderdata->orderitems as $data){
			$order->KantoorItems()->attach($data['product']['id'],['amount' => $data['amount']]);
			$this->updateStock($data['product']['id'],$data['amount']);
		}

		return $order;
	}

	private function updateStock($product_id,$amount){
		$product = KantoorItem::whereId($product_id)->first();
		$product->stock -= $amount;
		$product->save();
	}

}