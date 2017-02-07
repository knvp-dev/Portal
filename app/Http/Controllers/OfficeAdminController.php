<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class OfficeAdminController extends Controller
{
   	public function index(){
   		return view('pages.admin.kantoren');
   	}

   	public function getAll(){
   		return User::where('admin','!=',1)->get();
   	}

   	public function update(Request $request){
   		$user = User::where('id',$request['office']['id'])->first();
   		$office = $request['office'];
    	unset($office['id']);
    	$user->update($office);
   	}
}
