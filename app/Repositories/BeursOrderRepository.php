<?php 
namespace App\Repositories;

use App\BeursOrder;
use App\BeursItem;
use App\Unavailability;
use Auth;
use App\Repositories\Contracts\OrderInterface;

class BeursOrderRepository implements OrderInterface{

	public function getAll(){
		return BeursOrder::with('products')->with('user')->orderBy('id','DESC')->get();
	}

	public function findById($id){
		return BeursOrder::whereId($id)->with('products')->first();
	}

	public function getForUser(){
		return BeursOrder::whereUserId(Auth::user()->id)->with('products')->orderBy('id','DESC')->get();
	}

	public function create($orderdata){
		return $this->createNewOrder($orderdata);
	}

	public function remove($id){
		$order = BeursOrder::where('id',$id)->first();
		$unavailabilities = Unavailability::where('order_id',$id)->get();
		foreach($unavailabilities as $unavailability)
		{
			$unavailability->delete();
		}
		$order->delete();
		return "deleted";
	}

	private function createNewOrder($orderdata){
		$order = new BeursOrder();
		$order->user_id = Auth::user()->id;
		$order->event = $orderdata->event;
		$order->date_of_use = Date('Y-m-d', strtotime($orderdata->date));
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
		$unavailability->order_id = $order_id;
		$unavailability->beurs_item_id = $beurs_item_id;
		$unavailability->date_of_use = Date('Y-m-d', strtotime($date));
		$unavailability->unavailable_from = Date('Y-m-d', strtotime($date . "-1 week"));
		$unavailability->unavailable_to = Date('Y-m-d', strtotime($date . "+1 week"));
		$unavailability->save();
	}

	public function getByStatus($status){
		return BeursOrder::where('user_id',Auth::id())->whereCompleted($status)->with('products')->get();
	}

	public function getAllByStatus($status){
        return BeursOrder::whereCompleted($status)->with('products')->with('user')->get();
    }

}