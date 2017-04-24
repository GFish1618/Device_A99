<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    public $timestamps = false;

    public function devices() 
	{
	    return $this->hasMany('App\Devices');
	}
}
