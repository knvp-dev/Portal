<?php

namespace App\Http\Controllers;

use App\KantoorItem;
use App\Repositories\KantoorMateriaalRepository;
use Illuminate\Http\Request;

class KantoorMateriaalController extends Controller{

	protected $materiaal;

	public function __construct(KantoorMateriaalInterface $materiaal){
		$this->materiaal = $materiaal;
        //$this->middleware('auth');
    }

    public function index(){
    	$kantooritems = $this->materiaal->getAllItemsInStock();
    	return view('pages.kantoormateriaal.index', compact('kantooritems'));
    }

}
