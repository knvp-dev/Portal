<?php

namespace App\Http\Controllers;

use App\PromoItem;
use Illuminate\Http\Request;
use App\Repositories\PromoMateriaalRepository;

class PromoMateriaalController extends Controller{

	protected $materiaal;

	public function __construct(PromoMateriaalRepository $materiaal){
		$this->materiaal = $materiaal;
        //$this->middleware('auth');
    }

    public function index(){
    	return view('pages.promomateriaal.index');
    }

    public function getPromoItemsInStock(){
    	return $this->materiaal->getAllItemsInStock();
    }

}
