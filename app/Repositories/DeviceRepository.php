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

	public function getPaginate($n, $orderby = 'id')
	{
		return $this->device->paginate($n);//->orderBy('username');
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
		if (isset($inputs['user_name']) and $inputs['user_name']!=''){
			$device = $device->where('user_name', 'like', '%'.$inputs['user_name'].'%');
		}
		if (isset($inputs['device_name']) and $inputs['device_name']!=''){
			$device = $device->where('device_name', 'like', '%'.$inputs['device_name'].'%');
		}
		if (isset($inputs['category']) and $inputs['category']!=null){
			$device = $device->where('category', 'like', '%'.$inputs['category'].'%');
		}
		if (isset($inputs['mac_adress']) and $inputs['mac_adress']!=''){
			$device = $device->where('mac_adress', 'like', '%'.$inputs['mac_adress'].'%');
		}
		if (isset($inputs['ownership']) and $inputs['ownership']!=''){
			$device = $device->where('ownership', 'like', '%'.$inputs['ownership'].'%');
		}
		if (isset($inputs['unit_sn']) and $inputs['unit_sn']!=''){
			$device = $device->where('unit_sn', 'like', '%'.$inputs['unit_sn'].'%');
		}
		if (isset($inputs['keyboard_sn']) and $inputs['keyboard_sn']!=''){
			$device = $device->where('keyboard_sn', 'like', '%'.$inputs['keyboard_sn'].'%');
		}
		if (isset($inputs['mouse_sn']) and $inputs['mouse_sn']!=''){
			$device = $device->where('mouse_sn', 'like', '%'.$inputs['mouse_sn'].'%');
		}
		if (isset($inputs['external_monitor']) and $inputs['external_monitor']!=''){
			$device = $device->where('external_monitor', 'like', '%'.$inputs['external_monitor'].'%');
		}
		if (isset($inputs['external_mon_cable']) and $inputs['external_mon_cable']!=''){
			$device = $device->where('external_mon_cable', 'like', '%'.$inputs['external_mon_cable'].'%');
		}
		if (isset($inputs['installed_memory']) and $inputs['installed_memory']!=''){
			$device = $device->where('installed_memory', 'like', '%'.$inputs['installed_memory'].'%');
		}
		if (isset($inputs['core_speed']) and $inputs['core_speed']!=''){
			$device = $device->where('core_speed', 'like', '%'.$inputs['core_speed'].'%');
		}
		if (isset($inputs['purchased_date']) and $inputs['purchased_date']!=''){
			$device = $device->where('purchased_date', 'like', '%'.$inputs['purchased_date'].'%');
		}
		if (isset($inputs['current_location']) and $inputs['current_location']!=''){
			$device = $device->where('current_location', 'like', '%'.$inputs['current_location'].'%');
		}
		if (isset($inputs['os_version']) and $inputs['os_version']!=''){
			$device = $device->where('os_version', 'like', '%'.$inputs['os_version'].'%');
		}
		if (isset($inputs['department']) and $inputs['department']!=''){
			$device = $device->where('department', 'like', '%'.$inputs['department'].'%');
		}
		if (isset($inputs['orderby'])){$orderby=$inputs['orderby'];}
		return $device->orderBy($orderby)->paginate($n);
	}

	public function findSiblings(Devices $compare_device)
	{
		$device = new $this->device;
		$device = $device
			->where('user_name', $compare_device->user_name)
			->where('device_name', $compare_device->device_name);

		if ($compare_device->category!='')
			$device = $device->where('category', $compare_device->category);

		if ($compare_device->unit_sn!='')
			$device = $device->where('unit_sn', $compare_device->unit_sn);
			
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
		if (!preg_match("/.xlsx?$/", $filePath))
        {
            return redirect('/device/import')->withOk("Incorrect file extension");
        }
		try{
		$data = Excel::load($filePath, function($reader) {
	    	})->get();

	    	foreach($data as $sheet){

	    		foreach($sheet as $inputs){

		    		if (!isset($inputs->name))
		    			return false;
		    		if (!isset($inputs->device_name))
		    			return false;
		    		if (!isset($inputs->ownership))
		    			return false;
		    	}
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
	    	
	    	foreach($data as $sheet){
		    	foreach($sheet as $inputs){

		    		$device = new $this->device;

		    		if ( (isset($inputs->name) and $inputs->name!=null) and (isset($inputs->device_name) and $inputs->device_name!=null) )
		    		{
			    		$device->user_name = $inputs->name;
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
			    		$device->save();
		    		}
		    	}
		    }
	    	
		});
	}

}