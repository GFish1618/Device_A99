@extends('layouts.app')

@section('content')
    <div class="col-sm-offset-2 col-sm-4">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		@if(session()->has('error'))
			<div class="alert alert-danger alert-dismissible">{!! session('error') !!}</div>
		@endif
		<div class="panel panel-primary">	
			<div class="panel-heading">
			<h3 class="panel-title">Device</h3>
			@if (Auth::user()->admin >= 2)
			{!! Form::open(['method' => 'DELETE', 'route' => ['device.destroy', $device->id]]) !!}
				{!! Form::submit('Delete', ['class' => 'btn btn-danger pull-right', 'onclick' => 'return confirm(\'Are you sure?\')']) !!}
			{!! Form::close() !!}
			@endif
			@if (Auth::user()->admin >= 1)
			{!! link_to_route('device.edit', 'Edit', [$device->id], ['class' => 'btn btn-info pull-right']) !!}
			@endif
			</div>
			<div class="panel-body">
			@if ($device->user_name != '' and $device->user_name != 'N/A') 
				<p><strong class="text-primary">Username : </strong> {{ $device->user_name }}</p>
			@endif
			@if ($device->device_name != '' and $device->device_name != 'N/A') 
				<p><strong class="text-primary">Device name : </strong> {{ $device->device_name }}</p>
			@endif
			@if ($device->category != '' and $device->category != 'N/A') 
				<p><strong class="text-primary">Category : </strong> {{ $device->category }}</p>
			@endif
			@if ($device->mac_adress != '' and $device->mac_adress != 'N/A') 
				<p><strong class="text-primary">Mac adress : </strong> {{ $device->mac_adress }}</p>
			@endif
			@if ($device->ownership != '' and $device->ownership != 'N/A') 
				<p><strong class="text-primary">Ownership : </strong> {{ $device->ownership }}</p>
			@endif
			@if ($device->unit_sn != '' and $device->unit_sn != 'N/A') 
				<p><strong class="text-primary">Unit S/N : </strong> {{ $device->unit_sn }}</p>
			@endif
			@if ($device->keyboard_sn != '' and $device->keyboard_sn != 'N/A') 
				<p><strong class="text-primary">Keyboard S/N : </strong> {{ $device->keyboard_sn }}</p>
			@endif
			@if ($device->mouse_sn != '' and $device->mouse_sn != 'N/A') 
				<p><strong class="text-primary">Mouse S/N : </strong> {{ $device->mouse_sn }}</p>
			@endif
			@if ($device->charger_sn != '' and $device->charger_sn != 'N/A') 
				<p><strong class="text-primary">Charger S/N : </strong> {{ $device->charger_sn }}</p>
			@endif
			@if ($device->charger_version != '' and $device->charger_version != 'N/A') 
				<p><strong class="text-primary">Charger version : </strong> {{ $device->charger_version }}</p>
			@endif
			@if ($device->category == 'computer') 
				<p><strong class="text-primary">External Monitor : </strong> 
				@if($device->external_monitor)
					Yes
				@else
					No
				@endif</p>
				<p><strong class="text-primary">External monitor cable : </strong> 
				@if($device->external_mon_cable)
					Yes
				@else
					No
				@endif</p>
				<p><strong class="text-primary">Laptop sleeve : </strong> 
				@if($device->laptop_sleeve)
					Yes
				@else
					No
				@endif</p>
			@endif
			@if ($device->installed_memory != '' and $device->installed_memory != 'N/A') 
				<p><strong class="text-primary">Installed memory : </strong> {{ $device->installed_memory }}</p>
			@endif
			@if ($device->core_speed != '' and $device->core_speed != 'N/A') 
				<p><strong class="text-primary">Core speed : </strong> {{ $device->core_speed }}</p>
			@endif
			@if ($device->purchased_date != '0000-00-00') 
				<p><strong class="text-primary">Purchased date : </strong> {{ $device->purchased_date }}</p>
			@endif
			@if ($device->current_location != '' and $device->current_location != 'N/A') 
				<p><strong class="text-primary">Current location : </strong> {{ $device->current_location }}</p>
			@endif
			@if ($device->os_version != '' and $device->os_version != 'N/A') 
				<p><strong class="text-primary">OS version : </strong> {{ $device->os_version }}</p>
			@endif
			@if ($device->department != '' and $device->department != 'N/A') 
				<p><strong class="text-primary">Department : </strong> {{ $device->department }}</p>
			@endif
			@if ($device->remarks != '' and $device->remarks != 'N/A') 
				<p><strong class="text-primary">Remarks : </strong> {{ $device->remarks }}</p>
			@endif
			</div>
		</div>				
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a><br><br>
	</div>
@endsection