<?php use App\Repositories\FileRepository; ?>

@extends('layouts.app')

@section('content')
	<div class="col-sm-offset-2 col-sm-4">
		<div class="panel panel-primary">	
			<div class="panel-heading">
			<h3 class="panel-title">Edit device</h3></div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					{!! Form::model($device, ['route' => ['device.update', $device->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}

					<div class="form-group {!! $errors->has('user_name') ? 'has-error' : '' !!}">
						{!! Form::label('User name') !!}
						{!! Form::text('user_name', null, ['class' => 'form-control', 'placeholder' => 'Username*']) !!}
						{!! $errors->first('user_name', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('device_name') ? 'has-error' : '' !!}">
						{!! Form::label('Device name') !!}
						{!! Form::text('device_name', null, ['class' => 'form-control', 'placeholder' => 'Device Name*']) !!}
						{!! $errors->first('device_name', '<small class="help-block">:message</small>') !!}
					</div>
					
					<div class="form-group {!! $errors->has('category') ? 'has-error' : '' !!}">
						{!! Form::label('Category') !!}
						{!! Form::select('category', FileRepository::makeArray(), null, ['class' => 'form-control']) !!}
						{!! $errors->first('category', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('mac_adress') ? 'has-error' : '' !!}">
						{!! Form::label('Mac Adress') !!}
						{!! Form::text('mac_adress', null, ['class' => 'form-control', 'placeholder' => 'Mac adress']) !!}
						{!! $errors->first('mac_adress', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('ownership') ? 'has-error' : '' !!}">
						{!! Form::label('Ownership') !!}
						{!! Form::text('ownership', null, ['class' => 'form-control', 'placeholder' => 'Ownership']) !!}
						{!! $errors->first('ownership', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('unit_sn') ? 'has-error' : '' !!}">
						{!! Form::label('Unit S/N') !!}
						{!! Form::text('unit_sn', null, ['class' => 'form-control', 'placeholder' => 'Unit S/N']) !!}
						{!! $errors->first('unit_sn', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('keyboard_sn') ? 'has-error' : '' !!}">
						{!! Form::label('Keybord S/N') !!}
						{!! Form::text('keyboard_sn', null, ['class' => 'form-control', 'placeholder' => 'Keyboard S/N']) !!}
						{!! $errors->first('keyboard_sn', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('mouse_sn') ? 'has-error' : '' !!}">
						{!! Form::label('Mouse S/N') !!}
						{!! Form::text('mouse_sn', null, ['class' => 'form-control', 'placeholder' => 'Mouse S/N']) !!}
						{!! $errors->first('mouse_sn', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('charger_sn') ? 'has-error' : '' !!}">
						{!! Form::label('Charger S/N') !!}
						{!! Form::text('charger_sn', null, ['class' => 'form-control', 'placeholder' => 'Charger S/N']) !!}
						{!! $errors->first('charger_sn', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('charger_version') ? 'has-error' : '' !!}">
						{!! Form::label('Charger version') !!}
						{!! Form::text('charger_version', null, ['class' => 'form-control', 'placeholder' => 'Charger version']) !!}
						{!! $errors->first('charger_version', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group">
						<div class="checkbox">
							<label>
								{!! Form::checkbox('external_monitor', 1, null) !!} External monitor
							</label>
						</div>
						<div class="checkbox">
							<label>
								{!! Form::checkbox('external_mon_cable', 1, null) !!} External monitor cable
							</label>
						</div>
						<div class="checkbox">
							<label>
								{!! Form::checkbox('laptop_sleeve', 1, null) !!} Laptop sleeve
							</label>
						</div>
					</div>

					<div class="form-group {!! $errors->has('installed_memory') ? 'has-error' : '' !!}">
						{!! Form::label('Installed memory') !!}
						{!! Form::text('installed_memory', null, ['class' => 'form-control', 'placeholder' => 'Installed memory']) !!}
						{!! $errors->first('installed_memory', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('core_speed') ? 'has-error' : '' !!}">
						{!! Form::label('Core speed') !!}
						{!! Form::text('core_speed', null, ['class' => 'form-control', 'placeholder' => 'Core speed']) !!}
						{!! $errors->first('core_speed', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('purchased_date') ? 'has-error' : '' !!}">
						{!! Form::label('Date of purchased') !!}
						{!! Form::date('purchased_date', null, ['class' => 'form-control', 'placeholder' => 'Purchased date']) !!}
						{!! $errors->first('purchased_date', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('current_location') ? 'has-error' : '' !!}">
						{!! Form::label('Current location') !!}
						{!! Form::text('current_location', null, ['class' => 'form-control', 'placeholder' => 'Current location']) !!}
						{!! $errors->first('current_location', '<small class="help-block">:message</small>') !!}
					</div>
					
					@if (Auth::user()->admin >= 2)
					<div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">
						{!! Form::label('New password') !!}
						{!! Form::password('password', null, ['class' => 'form-control']) !!}
						{!! $errors->first('password', '<small class="help-block">:message</small>') !!}
					</div>
					@endif

					<div class="form-group {!! $errors->has('os_version') ? 'has-error' : '' !!}">
						{!! Form::label('OS Version') !!}
						{!! Form::text('os_version', null, ['class' => 'form-control', 'placeholder' => 'OS version']) !!}
						{!! $errors->first('os_version', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('department') ? 'has-error' : '' !!}">
						{!! Form::label('Department') !!}
						{!! Form::text('department', null, ['class' => 'form-control', 'placeholder' => 'Department']) !!}
						{!! $errors->first('department', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('remarks') ? 'has-error' : '' !!}">
						{!! Form::label('Remarks') !!}
						{!! Form::text('remarks', null, ['class' => 'form-control', 'placeholder' => 'Remarks']) !!}
						{!! $errors->first('remarks', '<small class="help-block">:message</small>') !!}
					</div>
					
					{!! Form::submit('Edit', ['class' => 'btn btn-primary pull-right']) !!}
					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Back
		</a>
		<br><br>
	</div>
@endsection