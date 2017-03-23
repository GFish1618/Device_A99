@extends('layouts.app')

@section('content')
    <div class="col-sm-offset-2 col-sm-4">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Devices list</h3>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>User</th>
						<th>Device</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($devices as $device)
						<tr>
							<td>{!! $device->user_name !!}</td>
							<td class="text-primary"><strong>{!! $device->device_name !!}</strong></td>
							<td>{!! link_to_route('device.show', 'Show', [$device->id], ['class' => 'btn btn-success btn-block']) !!}</td>
							<td>{!! link_to_route('device.edit', 'Edit', [$device->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['device.destroy', $device->id]]) !!}
									{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Are you sure?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
		</div>
		{!! $links !!}
		<br><br>
	</div>
@endsection