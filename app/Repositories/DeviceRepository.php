<?php

namespace App\Repositories;

use App\Devices;
use App\Categories;

use Excel;

class DeviceRepository
{

    protected $device;
    protected $category;
    protected $cat_row;

    public function __construct(Devices $device, Categories $category)
	{
		$this->device = $device;
		$this->category = $category;
	}

	private function save(Devices $device, Array $inputs)
	{
		$nb_fields = $inputs['number_of_fields'];

		//$device->user_name = $inputs['user_name'];
		$device->device_name = $inputs['device_name'];
		$device->category_id = $inputs['category_id'];

		for($i = 1; $i <= $nb_fields; $i++)
    	{
    		$field = 'field'.$i;
    		$device->$field = $inputs[$field];
    	}

		$device->save();

		/*$siblings = $this->findSiblings($device);
		if ($siblings->first() != null)
		{
			return ['success' => 'false', 'sibling' => $siblings->first()->id];
		}
		else
		{
			$device->save();
			return ['success' => 'true'];
		}*/
	}

	public function getCategory()
	{
		return $this->device->category;
	}

	public function getPaginate($n, $orderby = 'id')
	{
		return $this->device->orderBy($orderby)->paginate($n);
	}

	public function store(Array $inputs)
	{
		$device = new $this->device;		
		
		$this->save($device, $inputs);
		//$response += ['name' => $device->device_name];

		return $device->device_name;
	}

	public function getById($id)
	{
		return $this->device->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

	public function reset()
	{
		echo("<pre>__
##|_          hmmm, 'press to reset'!
##| |    _  .' ...wonder if that's for real??
##| D- o')            __
##|_| \.\",         -=(o '.
##|     ||_           '.-.\
##|    .\".            /|  \\\\
##|   _|_|            '|  ||
-----------------------_\_):,_------</pre>");

		$devices = $this->device->where('id', '>=', '0');
		
		while ($devices->first() != null)
		{
			$devices->first()->delete();
			$devices = $this->device->where('id', '>=', '0');
		}
	}

	public function search(Array $inputs, $n, $orderby = 'id')
	{
		$device = new $this->device;
		/*if (isset($inputs['user_name']) and $inputs['user_name']!=''){
			$device = $device->where('user_name', 'like', '%'.$inputs['user_name'].'%');
		}*/
		if (isset($inputs['device_name']) and $inputs['device_name']!=''){
			$device = $device->where('device_name', 'like', '%'.$inputs['device_name'].'%');
		}
		if (isset($inputs['category']) and $inputs['category']!=null){
			$device = $device->where('category_id', 'like', '%'.$inputs['category'].'%');
		}

		for($i = 1; $i <= 30; $i++)
    	{
    		$field = 'field'.$i;

    		if (isset($inputs[$field]) and $inputs[$field]!=null){
				$device = $device->where($field, 'like', '%'.$inputs[$field].'%');
			}
    	}
		

		//if (isset($inputs['orderby'])){$orderby=$inputs['orderby'];}
		return $device->orderBy($orderby)->paginate($n);
	}

	public function findSiblings(Devices $compare_device)
	{
		$device = new $this->device;
		$device = $device->where('device_name', $compare_device->device_name);
			//->where('user_name', $compare_device->user_name)
			

		if ($compare_device->unit_sn!='')
			$device = $device->where('unit_sn', $compare_device->unit_sn);
			
		return $device;
	}

	public function export()
	{
        Excel::create('Devices', function($excel){
        	$categories = $this->category->paginate(0);
        	foreach ($categories as $category)
  			{
  				$this->cat_row = $category;
				$excel->sheet($category->category_name, function($sheet){
					$sheet->fromArray(array() , null, 'A1', false, false);

				 	$row_array = array('id', /*'Username',*/ 'Device name');

				 	for($i=1 ; $i<=$this->cat_row->number_of_fields ; $i++)
				 	{
				 		$field = 'field'.$i.'_name';
				 		$row_array += array($i+2 => $this->cat_row->$field);
				 	}
				 	

					$sheet->appendRow($row_array);

					$devices = $this->device->paginate(0);
	  				foreach ($devices as $row)
	  				{
	  					if($row->category->category_name == $sheet->getTitle())
	  					{
	  						$row_array = array($row->id, /*$row->user_name,*/ $row->device_name);

	  						for($i=1 ; $i<=$row->category->number_of_fields ; $i++)
						 	{
						 		$field = 'field'.$i;
						 		$row_array += array($i+2 => $row->$field);
						 	}

	  						$sheet->appendRow($row_array);
	  					}
	  				}
    			});
    		}
		})->export('xls');
	}

	public function verifxls($filePath)
	{
		/*Excel::load($filePath, function($reader)
		{
	    	$data = $reader->get();
	    	
	    	foreach($data as $sheet){
		    	$inputs= $sheet->first();

				if ( isset($inputs->device_name))
				{
					return true;
			    }
			    else
			    {
			    	return false;
			    }

			}
		});*/

		return true;
	}

	public function import($filePath)
	{
	    Excel::load($filePath, function($reader) {
	    	$data = $reader->get();
	    	
	    	foreach($data as $sheet){
		    	foreach($sheet as $inputs){

		    		$device = new $this->device;

		    		$category = $this->category->where('category_name', $sheet->getTitle())->first();
		    		if($category == null)
		    		{
		    			$category = new $this->category;
		    			$category->category_name = $sheet->getTitle();
		    			$nb_fields = 0;

						foreach ($inputs as $field_name => $value) {
						    if($field_name != null /*and $field_name != 'username'*/ and $field_name != 'device_name')
		    				{
		    					$nb_fields++;
		    					$field = 'field'.$nb_fields.'_name';
		    					$category->$field = $field_name;
		    				}
						}
						$category->number_of_fields = $nb_fields;
		    			$category->save();
		    		}

		    		if ( isset($inputs->device_name) and $inputs->device_name!=null)
					{
	    		
			    		//$device->user_name = $inputs->username;
			    		$device->device_name = $inputs->device_name;
			    		$device->category_id = $category->id;
			    		
			    		for($i=1 ; $i<=$category->number_of_fields ; $i++)
			    		{
			    			$field = 'field'.$i;
			    			$field_name = 'field'.$i.'_name';
			    			$name = $category->$field_name;

			    			if ($inputs->$name!=null)
			    				$device->$field = $inputs->$name;
			    		}

			    		$siblings = $this->findSiblings($device);
			    		while ($siblings->first() != null)
			    		{
			    			$siblings->first()->delete();
			    			$siblings = $this->findSiblings($device);
			    		}
			    		$device->save();
				    }

		    	}
		    }	    	
		});
	}

}