@extends('layouts.app')

@section('content')
    <div class="col-sm-8">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		<ol class="breadcrumb breadcrumb-arrow">
		<li><a href="#">Home</a></li>
		<li><a href="#">Library</a></li>
		<li class="active"><span>Data</span></li>
		</ol>
		<div class="panel panel-default">
 		<div class="panel-body">
		 <div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>User</th>
						<th>Device</th>
						<th></th>
						<th></th>
						@if (Auth::user()->admin >= 2)
						<th></th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach ($devices as $device)
						<tr>
							<td>{!! $device->user_name !!}</td>
							<td class="text-primary"><strong>{!! $device->device_name !!}</strong></td>
							<td>{!! link_to_route('device.show', 'Show', [$device->id], ['class' => 'btn btn-success btn-block']) !!}</td>
							<td>{!! link_to_route('device.edit', 'Edit', [$device->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							@if (Auth::user()->admin >= 2)
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['device.destroy', $device->id]]) !!}
									{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Are you sure?\')']) !!}
								{!! Form::close() !!}
							</td>
							@endif
						</tr>
					@endforeach
	  			</tbody>
			</table>
			{!! $links !!}
			</div>
		</div>
		
		<br><br>
	</div>
@endsection