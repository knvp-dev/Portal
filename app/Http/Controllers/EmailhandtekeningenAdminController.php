<?php

namespace App\Http\Controllers;

use App\Functie;
use App\Emailhandtekening;
use Illuminate\Http\Request;

class EmailhandtekeningenAdminController extends Controller
{
    public function index(){
    	return view('pages.admin.emailhandtekeningen.index');
    }

    public function addFunction(Request $request)
    {
    	$functie = new Functie();
    	$functie->name_nl = $request->name_nl;
    	$functie->name_fr = $request->name_fr;
    	$functie->save();
    }

    public function getUnapproved(){
    	return Emailhandtekening::whereApproved(0)->get();
    }

    public function setApproved($id){
    	$emailhandtekening = Emailhandtekening::whereId($id)->first();
    	$emailhandtekening->approved = 1;
    	$emailhandtekening->save();
    }

    public function removeEmailhandtekening($id){
    	$emailhandtekening = Emailhandtekening::whereId($id)->first();
    	$emailhandtekening->delete();
    }

    public function saveNewFunction(Request $request)
    {
        $functie = new Functie();
        $functie->name_nl = $request['functie_nl'];
        $functie->name_fr = $request['functie_fr'];
        $functie->save();
    }
}
