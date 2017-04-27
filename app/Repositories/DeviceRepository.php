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

		$device->device_name = $inputs['device_name'];
		$device->category_id = $inputs['category_id'];
		$device->company_id = $inputs['company_id'];
		$device->department = $inputs['department'];

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

		if (isset($inputs['device_name']) and $inputs['device_name']!=''){
			$device = $device->where('device_name', 'like', '%'.$inputs['device_name'].'%');
		}
		if (isset($inputs['category_id']) and $inputs['category_id']!=null){
			$device = $device->where('category_id', 'like', $inputs['category_id']);
		}
		if (isset($inputs['company_id']) and $inputs['company_id']!=null){
			$device = $device->where('company_id', 'like', $inputs['company_id']);
		}
		if (isset($inputs['department']) and $inputs['department']!=null){
			$device = $device->where('department', 'like', $inputs['department']);
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

	public function import($filePath, $company_id)
	{
		$_SESSION['comp_id'] = $company_id;
		Excel::load($filePath, function($reader) {
	    	$data = $reader->get();
	    	
	    	foreach($data as $sheet){
    			if(is_string($sheet->first()))
    			{
    				$this->excel_treat($sheet, $data->getTitle());
    			}
    			else
    			{
    				foreach($sheet as $inputs){
    					$this->excel_treat($inputs, $sheet->getTitle());
			    	}
    			}
		    }	    	
		});
	}

	private function excel_treat($inputs, $sheet_title)
	{
		$device = new $this->device;

		$category = $this->category->where('category_name', $sheet_title)->first();

		if($category == null and $inputs != null)
		{
			$category = new $this->category;
			$category->category_name = $sheet_title;
			$nb_fields = 0;

			foreach ($inputs as $field_name => $value) {
			    if($field_name != null and $field_name != 'device_name' and $field_name != 'department')
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
    		$device->device_name = $inputs->device_name;
    		$device->category_id = $category->id;
    		$device->company_id = $_SESSION['comp_id'];

    		if(isset($inputs->department) and $inputs->department!=null)
    		{
    			$device->department = $inputs->department;
				$device->company->findOrAdd($inputs->department); //If needed we add a new department to the company
    		}
    		
    		for($i=1 ; $i<=$category->number_of_fields ; $i++)
    		{
    			$field = 'field'.$i;
    			$field_name = 'field'.$i.'_name';
    			$name = $category->$field_name;

    			if ($inputs->$name!=null)
    				$device->$field = $inputs->$name;
    		}

    		/*$siblings = $this->findSiblings($device);
    		while ($siblings->first() != null)
    		{
    			$siblings->first()->delete();
    			$siblings = $this->findSiblings($device);
    		}*/
    		$device->save();
	    }
	}

}