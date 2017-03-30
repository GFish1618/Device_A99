@extends('layouts.app')

@section('content')
    <div class="col-sm-offset-2 col-sm-4">
		<div class="panel panel-primary">	
			<div class="panel-heading">
			<h3 class="panel-title">Device</h3>
			{!! Form::open(['method' => 'DELETE', 'route' => ['device.destroy', $device->id]]) !!}
				{!! Form::submit('Delete', ['class' => 'btn btn-danger pull-right', 'onclick' => 'return confirm(\'Are you sure?\')']) !!}
			{!! Form::close() !!}
			{!! link_to_route('device.edit', 'Edit', [$device->id], ['class' => 'btn btn-info pull-right']) !!}
			</div>
			<div class="panel-body"> 
				<p><strong class="text-primary">Username : </strong> {{ $device->user_name }}</p>
				<p><strong class="text-primary">Device name : </strong> {{ $device->device_name }}</p>
				<p><strong class="text-primary">Category : </strong> {{ $device->category }}</p>
				<p><strong class="text-primary">Mac adress : </strong> {{ $device->mac_adress }}</p>
				<p><strong class="text-primary">Ownership : </strong> {{ $device->ownership }}</p>
				<p><strong class="text-primary">Unit S/N : </strong> {{ $device->unit_sn }}</p>
				<p><strong class="text-primary">Keyboard S/N : </strong> {{ $device->keyboard_sn }}</p>
				<p><strong class="text-primary">Mouse S/N : </strong> {{ $device->mouse_sn }}</p>
				<p><strong class="text-primary">External Monitor : </strong> 
				@if($device->external_monitor == 1)
					Yes
				@else
					No
				@endif</p>
				<p><strong class="text-primary">External monitor cable : </strong> 
				@if($device->external_mon_cable == 1)
					Yes
				@else
					No
				@endif</p>
				<p><strong class="text-primary">Installed memory : </strong> {{ $device->installed_memory }} GB</p>
				<p><strong class="text-primary">Core speed : </strong> {{ $device->core_speed }}</p>
				<p><strong class="text-primary">Purchased date : </strong> {{ $device->purchased_date }}</p>
				<p><strong class="text-primary">Current location : </strong> {{ $device->current_location }}</p>

				@if (Auth::user()->admin >= 2)
				<p><strong class="text-primary">password : </strong> 
				<span>{{ $device->password }}</span>
				</p>
				@endif
				<p><strong class="text-primary">OS version : </strong> {{ $device->os_version }}</p>
				<p><strong class="text-primary">Department : </strong> {{ $device->department }}</p>
				<p><strong class="text-primary">Remarks : </strong> {{ $device->remarks }}</p>
			</div>
		</div>				
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a><br><br>
	</div>
@endsection