<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

use App\PromoOrder;
use App\PromoItem;
use App\BeursOrder;
use App\BeursItem;
use App\KantoorOrder;
use App\KantoorItem;
use App\User;
use App\Mail\PromoOrderReady;
use App\Mail\KantoorOrderReady;
use App\Mail\BeursOrderReady;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function getOffices(){
    	$users = User::with('openKantoorOrders')->with('openPromoOrders')->get();
    	foreach($users as $user){
    		$user->open_order_amount = count($user->openKantoorOrders) + count($user->openPromoOrders);
    	}
    	return json_decode(collect($users));
    }

    public function getOpenOrdersForOffice($office_id){
    	$orders = new Collection();

    	$promoOrders = PromoOrder::where('user_id',$office_id)->with("products")->get();
    	$kantoorOrders = KantoorOrder::where('user_id',$office_id)->with("products")->get();

    	foreach($promoOrders as $promoOrder){
    		$orders->push($promoOrder);
    	}
    	
    	foreach($kantoorOrders as $kantoorOrder){
    		$orders->push($kantoorOrder);
    	}
    	return json_encode($orders);
    }

    public function getProductsForPromoOrder($order_id){
    	$order = PromoOrder::where('seq_id',$order_id)->with("products")->first();
    	return json_decode(collect($order->products));
    }

    public function getProductsForKantoorOrder($order_id){
    	$order = KantoorOrder::where('seq_id',$order_id)->with('products')->first();
    	return collect($order->products)->toJson();
    }

    public function getProductsForBeursOrder($order_id){
    	$order = BeursOrder::where('seq_id',$order_id)->with('products')->first();
    	return collect($order->products)->toJson();
    }

    public function completePromoOrder($order_id){
    	$order = PromoOrder::where('seq_id', $order_id)->with('user')->with('products')->first();
    	$order->completed = 1;
    	$order->save();
    	$o = $order;
    	$o->complete = true;
    	foreach($order->products as $product){
    		if($product->pivot->status == 1){
    			$o->complete = false;
    		}
    	}
    	Mail::to($order->user->email)->send(new PromoOrderReady($o));
    	return "Completed";
    }

    public function completeKantoorOrder($order_id){
    	$order = KantoorOrder::where('seq_id', $order_id)->with('user')->with('products')->first();
    	$order->completed = 1;
    	$order->save();
    	$o = $order;
    	$o->complete = true;
    	foreach($order->products as $product){
    		if($product->pivot->status == 1){
    			$o->complete = false;
    		}
    	}
    	Mail::to($order->user->email)->send(new KantoorOrderReady($o));
    	return "Completed";
    }

    public function completeBeursOrder($order_id){
    	$order = BeursOrder::where('seq_id', $order_id)->with('user')->with('products')->first();
    	$order->completed = 1;
    	$order->save();
    	$o = $order;
    	$o->complete = true;
    	foreach($order->products as $product){
    		if($product->pivot->status == 1){
    			$o->complete = false;
    		}
    	}
    	Mail::to($order->user->email)->send(new BeursOrderReady($o));
    	return "Completed";
    }

    public function cannotDeliverPromoProduct($order_id, $product_id){

    	$order = PromoOrder::where('seq_id',$order_id)->with('user')->first();
    	$product = $order->products()->sync([$product_id => [ 'status' => 1] ], false);

    	$prod = PromoItem::where('id',$product_id)->first();
    	$user = User::where('id',$order->user->id)->first();
    	$user->budget += $prod->price;
    	$user->save();

    	$order->total_price -= $prod->price;
    	$order->save();

    	$promoItem = PromoItem::where('id',$product_id)->first();
    	$promoItem->stock = 0;
    	$promoItem->save();
    	return "Depleted";
    }

    public function cannotDeliverKantoorProduct($order_id, $product_id){

    	$order = KantoorOrder::where('seq_id',$order_id)->first();
    	$product = $order->products()->sync([$product_id => [ 'status' => 1] ], false);

    	$kantoorItem = KantoorItem::where('id',$product_id)->first();
    	$kantoorItem->stock = 0;
    	$kantoorItem->save();
    	return "Depleted";
    }

    public function cannotDeliverBeursProduct($order_id, $product_id){
    	$order = BeursOrder::where('seq_id',$order_id)->first();
    	$product = $order->products()->sync([$product_id => [ 'status' => 1] ], false);

    	$beursItem = BeursItem::where('id',$product_id)->first();
    	$beursItem->stock = 0;
    	$beursItem->save();
    	return "Depleted";
    }

    public function getAllReservations(){
    	$orders = BeursOrder::with('unavailability')->with('user')->with('products')->get();

    	return $orders;
    }
}
