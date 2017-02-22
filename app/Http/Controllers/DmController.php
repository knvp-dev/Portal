<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PromoOrder;
use App\KantoorOrder;
use App\BeursOrder;

use Auth;

class DmController extends Controller
{
	public function __construct(){
		$this->middleware('dm');
	}

    public function index(){
    	return view('pages.dm.overview');
    }

    public function getOffices(){
    	return User::where('dm_id',Auth::id())->whereAdmin(0)->with('promoOrders')->get();
    }

    public function getPromoOrders($user_id){
    	return PromoOrder::where('user_id',$user_id)->with('products')->get();
    }

    public function getKantoorOrders($user_id){
    	return KantoorOrder::where('user_id',$user_id)->with('products')->get();
    }

    public function getBeursOrders($user_id){
    	return BeursOrder::where('user_id',$user_id)->with('products')->get();
    }

    public function update(Request $request){
        $user = User::where('id',$request['office']['id'])->first();
        $office = $request['office'];
        unset($office['id']);
        unset($office['promo_orders']);
        $user->update($office);
    }
}
