<?php

namespace App\Http\Controllers;

use App\Functie;
use Auth;
use App\Emailhandtekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmailhandtekeningenController extends Controller
{
    public function index(){
    	return view('pages.emailhandtekeningen.index');
    }

    public function getFuncties(){
    	return Functie::all();
    }

    public function store(Request $request){
    	$formdata = $request->formdata;
    	$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
    	$filename = $formdata['name'] . "_" . $formdata['firstname'] . "_" . $formdata['function'] . ".png";
    	Storage::disk('emailhandtekeningen')->put($filename, $image);
        $path = public_path() . '/images/emailhandtekeningen/' . $filename;
        
        file_put_contents($path, $image);
    	
    	$emailhandtekening = new Emailhandtekening();
    	$emailhandtekening->name = $formdata['name'];
    	$emailhandtekening->firstname = $formdata['firstname'];
    	$emailhandtekening->user_id = Auth::id();
    	$emailhandtekening->function = $formdata['function'];
    	$emailhandtekening->gsm = $formdata['gsm'];
        $emailhandtekening->image = $filename;
    	$emailhandtekening->save();

    	return "created";
    }

    public function getEmailHandtekeningen(){
    	return Emailhandtekening::where('user_id',Auth::id())->orderBy('id','DESC')->get();
    }

    public function destroy($id){
        Emailhandtekening::where('id',$id)->delete();
    }

    public function downloadEmailhandtekening($id){
        $emailhandtekening = Emailhandtekening::where('id',$id)->first();
        $path = storage_path('emailhandtekeningen/' . $emailhandtekening->image);
        return response()->download($path);
    }
}
