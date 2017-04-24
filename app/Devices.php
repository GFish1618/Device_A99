<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    protected $table = 'devices';

    public $timestamps = false;


    public function category() 
	{
		return $this->belongsTo('App\Categories');
	}
}