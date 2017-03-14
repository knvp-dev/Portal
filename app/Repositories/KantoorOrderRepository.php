<?php 
namespace App\Repositories;

use App\KantoorOrder;
use App\KantoorItem;
use Auth;
use App\Repositories\Contracts\OrderInterface;

class KantoorOrderRepository implements OrderInterface{

	public function getAll(){
		return KantoorOrder::with('products')->with('user')->orderBy('id','DESC')->get();
	}

	public function findById($id){
		return KantoorOrder::whereId($id)->with('products')->first();
	}

	public function getForUser(){
		return KantoorOrder::whereUserId(Auth::user()->id)->with('products')->orderBy('id','DESC')->get();
	}

	public function create($orderdata){
		return $this->createNewOrder($orderdata);
	}

	public function remove($id){
		$order = KantoorOrder::where('id',$id)->with('products')->first();
		foreach($order->products as $product){
			$product->stock += $product->pivot->amount;
			$product->save();
		}
		$order->delete();
		return "deleted";
	}

	private function createNewOrder($orderdata){
		$order = new KantoorOrder();
		$order->user_id = Auth::user()->id;
		$order->save();

		foreach($orderdata->orderitems as $data){
			$order->products()->attach($data['product']['id'],['amount' => $data['amount']]);
			$this->updateStock($data['product']['id'],$data['amount']);
		}

		return $order;
	}

	private function updateStock($product_id,$amount){
		$product = KantoorItem::whereId($product_id)->first();
		$product->stock -= $amount;
		$product->save();
	}

	public function getByStatus($status){
		return KantoorOrder::where('user_id',Auth::id())->whereCompleted($status)->with('products')->get();
	}

	public function getAllByStatus($status){
        return KantoorOrder::whereCompleted($status)->with(['products','user'])->get();
    }

}