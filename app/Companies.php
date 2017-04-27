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

	public function findOrAdd($department)
	{
		$departments_string = $this->departments;
		if(!preg_match('/'.$department.'/', $departments_string))
		{
			$departments_string .= $department.'|';
			$this->departments = $departments_string;
			$this->save();
		}
	}
}
