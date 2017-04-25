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

    public function export($entity){
      $csvExporter = new \Laracsv\Export();
      $offices = User::whereEntity($entity)->where('dm',0)->get();
     
      $csvExporter->beforeEach(function ($office) {
          $office->uitgaven = number_format($office->start_budget/100 - $office->budget/100, 2);
          $office->budget = number_format($office->budget/100, 2);
          $office->start_budget = number_format($office->start_budget/100, 2);
          $office->datum = \Carbon\Carbon::now()->format('d-m-Y');

          $office->facebook_uitgaven = number_format($office->advertisement_start_budget/100 - $office->advertisement_budget/100, 2);
          $office->advertisement_budget = number_format($office->advertisement_budget/100, 2);
          $office->advertisement_start_budget = number_format($office->advertisement_start_budget/100, 2);
      });

      $csvExporter->build($offices, 
          ['datum' => 'status op',
            'name',
            'start_budget' => 'startbudget', 
            'budget',
            'uitgaven', 
            'advertisement_start_budget' => 'startbudget facebook',
            'advertisement_budget' => 'facebook budget',
            'facebook_uitgaven' => 'uitgaven facebook'
          ])->download($entity . '.csv');
    }
}
