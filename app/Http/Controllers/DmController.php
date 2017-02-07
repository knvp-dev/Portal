<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class DmController extends Controller
{
	public function __construct(){
		$this->middleware('dm');
	}

    public function index(){
    	return false;
    }

    public function getOffices(){
    	return User::where('dm_id',Auth::id())->get();
    }
}
