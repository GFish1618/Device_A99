<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table = 'companies';

    public $timestamps = false;

    public function devices() 
	{
	    return $this->hasMany('App\Devices');
	}
}
