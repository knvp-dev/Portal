<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unavailability extends Model
{
    public function beursItem(){
    	return $this->hasOne('App\BeursItem');
    }
}
