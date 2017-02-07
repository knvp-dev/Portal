<?php

namespace App\Http\Controllers;

use App\PromoItem;
use Illuminate\Http\Request;

class PromoMateriaalAdminController extends Controller
{
    public function index(){
    	return view('pages.admin.promomateriaal');
    }

    public function update(Request $request){
    	$promoitem = PromoItem::where('id',$request['product']['id'])->first();
    	$product = $request['product'];
    	unset($product['id']);
    	$promoitem->update($product);
    }
}
