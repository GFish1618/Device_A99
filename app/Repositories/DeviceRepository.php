<?php

namespace App\Repositories;

use App\Devices;

use Excel;

class DeviceRepository
{

    protected $device;

    public function __construct(Devices $device)
	{
		$this->device = $device;
	}

	private function save(Devices $device, Array $inputs)
	{
		$device->user_name = $inputs['user_name'];
		$device->device_name = $inputs['device_name'];
		$device->category = $inputs['category'];
		$device->mac_adress = strtolower($inputs['mac_adress']);
		$device->ownership = $inputs['ownership'];
		$device->unit_sn = $inputs['unit_sn'];
		$device->keyboard_sn = $inputs['keyboard_sn'];
		$device->mouse_sn = $inputs['mouse_sn'];
		$device->external_monitor = isset($inputs['external_monitor']);
		$device->external_mon_cable = isset($inputs['external_mon_cable']);
		$device->installed_memory = $inputs['installed_memory'];
		$device->core_speed = $inputs['core_speed'];

		if ($inputs['purchased_date']!='')
			$device->purchased_date = $inputs['purchased_date'];
		else
			$device->purchased_date = '0000-00-00';
		
		$device->current_location = $inputs['current_location'];
		$device->password = $inputs['password'];
		$device->os_version = $inputs['os_version'];
		$device->department = $inputs['department'];
		$device->remarks = $inputs['remarks'];

		$device->save();
	}

	public function getPaginate($n)
	{
		return $this->device->paginate($n);
	}

	public function store(Array $inputs)
	{
		$device = new $this->device;		
		//$device->password = bcrypt($inputs['password']);

		$this->save($device, $inputs);

		return $device;
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
		$devices = $this->device->toArray();
		//echo $devices;
		//echo '<pre>'; print_r($devices); echo '</pre>';
		foreach ($devices as $row) {
			echo($row);
			//$row->delete();
		}

		//$this->device->reset();
	}

	public function search(Array $inputs, $n)
	{
		$device = new $this->device;
		if (isset($inputs['user_name']) and $inputs['user_name']!=''){
			$device = $device->where('user_name', $inputs['user_name']);
		}
		if (isset($inputs['device_name']) and $inputs['device_name']!=''){
			$device = $device->where('device_name', $inputs['device_name']);
		}
		if (isset($inputs['category']) and $inputs['category']!=''){
			$device = $device->where('category', $inputs['category']);
		}
		if (isset($inputs['mac_adress']) and $inputs['mac_adress']!=''){
			$device = $device->where('mac_adress', $inputs['mac_adress']);
		}
		if (isset($inputs['ownership']) and $inputs['ownership']!=''){
			$device = $device->where('ownership', $inputs['ownership']);
		}
		if (isset($inputs['unit_sn']) and $inputs['unit_sn']!=''){
			$device = $device->where('unit_sn', $inputs['unit_sn']);
		}
		if (isset($inputs['keyboard_sn']) and $inputs['keyboard_sn']!=''){
			$device = $device->where('keyboard_sn', $inputs['keyboard_sn']);
		}
		if (isset($inputs['mouse_sn']) and $inputs['mouse_sn']!=''){
			$device = $device->where('mouse_sn', $inputs['mouse_sn']);
		}
		if (isset($inputs['external_monitor']) and $inputs['external_monitor']!=''){
			$device = $device->where('external_monitor', $inputs['external_monitor']);
		}
		if (isset($inputs['external_mon_cable']) and $inputs['external_mon_cable']!=''){
			$device = $device->where('external_mon_cable', $inputs['external_mon_cable']);
		}
		if (isset($inputs['installed_memory']) and $inputs['installed_memory']!=''){
			$device = $device->where('installed_memory', $inputs['installed_memory']);
		}
		if (isset($inputs['core_speed']) and $inputs['core_speed']!=''){
			$device = $device->where('core_speed', $inputs['core_speed']);
		}
		if (isset($inputs['purchased_date']) and $inputs['purchased_date']!=''){
			$device = $device->where('purchased_date', $inputs['purchased_date']);
		}
		if (isset($inputs['current_location']) and $inputs['current_location']!=''){
			$device = $device->where('current_location', $inputs['current_location']);
		}
		if (isset($inputs['password']) and $inputs['password']!=''){
			$device = $device->where('password', $inputs['password']);
		}
		if (isset($inputs['os_version']) and $inputs['os_version']!=''){
			$device = $device->where('os_version', $inputs['os_version']);
		}
		if (isset($inputs['department']) and $inputs['department']!=''){
			$device = $device->where('department', $inputs['department']);
		}
		return $device->paginate($n);
	}

	public function findSiblings(Devices $compare_device)
	{
		$device = new $this->device;
		$device = $device
			->where('user_name', $compare_device->user_name)
			->where('device_name', $compare_device->device_name);

		if ($compare_device->category!='')
			$device = $device->where('category', $compare_device->category);
			
		return $device;
	}

	public function export()
	{
        Excel::create('Devices', function($excel){
			$excel->sheet('Devices_A99', function($sheet){
				$sheet->fromArray(array() , null, 'A1', false, false);

				$sheet->appendRow(array(
						'id',
						'Username',
						'Device name',
						'Category',
						'Mac adress',
						'Ownership',
						'Unit S/N',
						'Keyboard S/N',
						'Mouse S/N',
       					'External monitor',
       					'External monitor cable',
       					'Installed memory',
       					'Core speed',
       					'Purchased date',
       					'Current location',
       					'Password',
       					'OS version',
       					'Department',
       					'Remarks',
					));

				$devices = $this->device->paginate(0);
  				foreach ($devices as $row)
  				{
  					$sheet->appendRow(array(
  						$row->id,
  						$row->user_name,
  						$row->device_name,
  						$row->category,
                    	$row->mac_adress,
       					$row->ownership,
       					$row->unit_sn,
       					$row->keyboard_sn,
       					$row->mouse_sn,
       					$row->external_monitor,
       					$row->external_mon_cable,
       					$row->installed_memory,
       					$row->core_speed,
       					$row->purchased_date,
       					$row->current_location,
       					$row->password,
       					$row->os_version,
       					$row->department,
       					$row->remarks
       				));
  				}
    		});
		})->export('xls');
	}

	public function verifxls($filePath)
	{
		try{
		$data = Excel::load($filePath, function($reader) {
	    	})->get();
	    	
	    	foreach($data as $inputs){

	    		$device = new $this->device;

	    		/*if (!isset($inputs->username))
	    			return false;
	    		if (!isset($inputs->device_name))
	    			return false;
	    		if (!isset($inputs->category))
		    		return false;
	    		if (!isset($inputs->mac_adress))
	    			return false;
	    		if (!isset($inputs->ownership))
	    			return false;
	    		if (!isset($inputs->unit_sn))
	    			return false;
	    		if (!isset($inputs->keyboard_sn))
	    			return false;
	    		if (!isset($inputs->mouse_sn))
	    			return false;
	    		if (!isset($inputs->external_monitor))
	    			return false;
	    		if (!isset($inputs->external_monitor_cable))
	    			return false;
	    		if (!isset($inputs->installed_memory))
	    			return false;
	    		if (!isset($inputs->core_speed))
	    			return false;
	    		if (!isset($inputs->purchased_date))
	    			return false;
	    		if (!isset($inputs->current_location))
	    			return false;
	    		if (!isset($inputs->password))
	    			return false;
	    		if (!isset($inputs->os_version))
	    			return false;
	    		if (!isset($inputs->department))
	    			return false;
	    		if (!isset($inputs->remarks))
	    			return false;*/
	    	}

	    	return true;
		}
		catch(\Exception $e)
		{
			return false;
		}
	}

	public function import($filePath)
	{
	    Excel::load($filePath, function($reader) {
	    	$data = $reader->get();
	    	
	    	foreach($data as $inputs){

	    		$device = new $this->device;

	    		if ($inputs->username!=null)
	    			$device->user_name = $inputs->username;
	    		if ($inputs->device_name!=null)
	    			$device->device_name = $inputs->device_name;
	    		if ($inputs->category!=null)
	    			$device->category = $inputs->category;
	    		if ($inputs->mac_adress!=null)
	    			$device->mac_adress = $inputs->mac_adress;
	    		if ($inputs->ownership!=null)
	    			$device->ownership = $inputs->ownership;
	    		if ($inputs->unit_sn!=null)
	    			$device->unit_sn = $inputs->unit_sn;
	    		if ($inputs->keyboard_sn!=null)
	    			$device->keyboard_sn = $inputs->keyboard_sn;
	    		if ($inputs->mouse_sn!=null)
	    			$device->mouse_sn = $inputs->mouse_sn;
	    		if ($inputs->external_monitor!=null)
	    			$device->external_monitor = $inputs->external_monitor;
	    		if ($inputs->external_monintor_cable!=null)
	    			$device->external_mon_cable = $inputs->external_monitor_cable;
	    		if ($inputs->installed_memory!=null)
	    			$device->installed_memory = $inputs->installed_memory;
	    		if ($inputs->core_speed!=null)
	    			$device->core_speed = $inputs->core_speed;
	    		if ($inputs->purchased_date!=null)
	    			$device->purchased_date = $inputs->purchased_date;
	    		if ($inputs->current_location!=null)
	    			$device->current_location = $inputs->current_location;
	    		if ($inputs->password!=null)
	    			$device->password = $inputs->password;
	    		if ($inputs->os_version!=null)
	    			$device->os_version = $inputs->os_version;
	    		if ($inputs->department!=null)
	    			$device->department = $inputs->department;
	    		if ($inputs->remarks!=null)
	    			$device->remarks = $inputs->remarks;

	    		$siblings = $this->findSiblings($device);
	    		while ($siblings->first() != null)
	    		{
	    			$siblings->first()->delete();
	    			$siblings = $this->findSiblings($device);
	    		}

	    		//echo ($device."<br>");
	    		$device->save();
	    	}
	    	
		});
	}

}