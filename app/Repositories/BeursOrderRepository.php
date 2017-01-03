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
		return BeursOrder::whereId($id)->with('products')->first();
	}

	public function getForUser(){
		return BeursOrder::whereUserId(Auth::user()->id)->with('products')->get();
	}

	public function create($orderdata){
		return $this->createNewOrder($orderdata);
	}

	public function remove($id){

	}

	private function createNewOrder($orderdata){
		$order = new BeursOrder();
		$order->user_id = Auth::user()->id;
		$order->event = $orderdata->event;
		$order->date_of_use = $orderdata->date;
		$order->return_date = Date('Y-m-d', strtotime($orderdata->date . "+1 week"));
		$order->save();

		foreach($orderdata->orderitems as $data){
			$order->products()->attach($data['id']);
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

	public function getByStatus($status){
		return BeursOrder::whereCompleted($status)->with('products')->get();
	}

}