<?php

namespace App\Http\Controllers;

use App\Unavailability;
use Illuminate\Http\Request;

class BeursMateriaalAdminController extends Controller
{
	public function index(){
		return view('pages.admin.beursmateriaal');
	}
	
    public function getAllUnavailabilities(){
    	return Unavailability::with('beursItem')->with('user')->with('order')->get();
    }
}
