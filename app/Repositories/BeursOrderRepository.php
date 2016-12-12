<?php 
namespace App\Repositories;

use App\BeursOrder;
use App\BeursItem;
use App\Unavailability;
use Auth;
use App\Repositories\Contracts\OrderInterface;

class BeursOrderRepository implements OrderInterface{

	public function getAll(){
		return BeursOrder::all();
	}

	public function findById($id){
		return BeursOrder::whereId($id)->first();
	}

	public function getForUser(){
		return BeursOrder::whereUserId(Auth::user()->id)->get();
	}

	public function create($orderdata){
		return $this->createNewOrder($orderdata);
	}

	public function remove($id){

	}

	private function createNewOrder($orderdata){
		$order = new BeursOrder();
		$order->user_id = Auth::user()->id;
		$order->save();

		foreach($orderdata->orderitems as $data){
			$order->beursItems()->attach($data['id']);
			$this->setUnavailability($order->id, $orderdata->date, $data['id']);
		}

		return $order;
	}

	private function setUnavailability($order_id, $date, $beurs_item_id){
		$unavailability = new Unavailability();
		$unavailability->user_id = Auth::id();
		$unavailability->beurs_item_id = $beurs_item_id;
		$unavailability->date_of_use = $date;
		$unavailability->unavailable_from = Date('Y-m-d', strtotime($date . "-1 week"));
		$unavailability->unavailable_to = Date('Y-m-d', strtotime($date . "+1 week"));
		$unavailability->save();
	}

}