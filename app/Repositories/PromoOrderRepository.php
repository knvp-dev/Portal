<?php 
namespace App\Repositories;

use App\PromoOrder;
use App\PromoItem;
use Auth;
use App\Repositories\Contracts\OrderInterface;

class PromoOrderRepository implements OrderInterface{

	public function getAll(){
		return PromoOrder::all();
	}

	public function findById($id){
		return PromoOrder::whereId($id)->with('products')->first();
	}

	public function getForUser(){
		return PromoOrder::where('user_id',Auth::id())->with('products')->get();
	}

	public function create($orderdata){
		return $this->createNewOrder($orderdata);
	}

	public function remove($id){

	}

	private function createNewOrder($orderdata){
		$order = new PromoOrder();
		$order->user_id = Auth::user()->id;
		$order->total_price = $orderdata->totalPrice * 100;
		$order->save();

		foreach($orderdata->orderitems as $data){
			$order->products()->attach($data['product']['id'],['amount' => $data['amount']]);
			$this->updateStock($data['product']['id'],$data['amount']);
		}

		$this->updateBudget($order->total_price);

		return $order;
	}

	private function updateBudget($amount){
		$user = Auth::user();
		$user->budget -= $amount;
		$user->save();
	}

	private function updateStock($product_id,$amount){
		$product = PromoItem::whereId($product_id)->first();
		$product->stock -= $amount;
		$product->save();
	}

	public function getByStatus($status){
		return PromoOrder::where('user_id',Auth::id())->whereCompleted($status)->with('products')->get();
	}

}