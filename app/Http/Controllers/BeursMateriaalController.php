<?php

namespace App\Http\Controllers;

use App\BeursItem;
use Illuminate\Http\Request;

class BeursMateriaalController extends Controller{

	public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
    	return view('pages.beursmateriaal.index');
    }

    public function getBeursItems(){
    	return BeursItem::with('unavailability')->get();
    }

}
