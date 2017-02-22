<?php

namespace App\Http\Controllers;

use App\KantoorItem;
use Illuminate\Http\Request;

class KantoorMateriaalAdminController extends Controller
{
    public function index(){
    	return view('pages.admin.kantoormateriaal');
    }

    public function update(Request $request){
    	$promoitem = KantoorItem::whereId($request['product']['id'])->first();
    	$product = $request['product'];
    	unset($product['id']);
    	$promoitem->update($product);
    }
}
