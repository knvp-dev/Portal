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
		return PromoOrder::whereId($id)->first();
	}

	public function getForUser(){
		return PromoOrder::whereUserId(Auth::user()->id)->get();
	}

	public function create($orderdata){
		$order = new PromoOrder();
		$order->user_id = Auth::user()->id;
		$order->total_price = $orderdata->totalPrice * 100;
		$order->save();

		foreach($orderdata->orderitems as $data){
			$order->promoItems()->attach($data['product']['id'],['amount' => $data['amount']]);
		}

		$user = Auth::user();
		$user->budget -= $order->total_price;
		$user->save();

		return $order;
	}

	public function remove($id){

	}

}