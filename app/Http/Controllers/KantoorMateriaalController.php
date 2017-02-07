<?php

namespace App\Http\Controllers;

use App\KantoorItem;
use App\Repositories\KantoorMateriaalRepository;
use Illuminate\Http\Request;

class KantoorMateriaalController extends Controller{

	protected $materiaal;

	public function __construct(KantoorMateriaalRepository $materiaal){
		$this->materiaal = $materiaal;
        $this->middleware('auth');
    }

    public function index(){
    	return view('pages.kantoormateriaal.index');
    }

    public function getKantoorItemsInStock(){
    	return $this->materiaal->getAllItemsInStock();
    }

    public function getAll(){
        return $this->materiaal->getAll();
    }

}
