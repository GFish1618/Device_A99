@extends('layouts.app')

@section('content')
    <div class="col-sm-8">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		@if(session()->has('error'))
			<div class="alert alert-danger alert-dismissible">{!! session('error') !!}</div>
		@endif
		<div class="panel panel-default">
 		<div class="panel-body">
		 <div class="col-md-12">
			{!! Form::open(['method' => 'POST', 'route' => ['device.indexPage'], 'id' => 'nb_per_page']) !!}
				<select name="nbp" class="btn pull-right" onchange="document.getElementById('nb_per_page').submit();">
					<option <?php if($_SESSION['nbp']==5){echo 'selected';} ?> >5</option>
					<option <?php if($_SESSION['nbp']==10){echo 'selected';} ?> >10</option>
					<option <?php if($_SESSION['nbp']==20){echo 'selected';} ?> >20</option>
					<option <?php if($_SESSION['nbp']==50){echo 'selected';} ?> >50</option>
					<option <?php if($_SESSION['nbp']==100){echo 'selected';} ?> >100</option>
				</select>
				<label class="pull-right"> Items per page : </label>
			{!! Form::close() !!}

			{!! Form::open(['method' => 'POST', 'route' => ['device.indexOrder'], 'id' => 'order_by']) !!}
				<select name="orderby" class="btn pull-right" onchange="document.getElementById('order_by').submit();">
					<option value="id" <?php if($_SESSION['orderby']=='id'){echo 'selected';} ?> >Id</option>
					<option value="user_name" <?php if($_SESSION['orderby']=='user_name'){echo 'selected';} ?> >User</option>
					<option value="device_name" <?php if($_SESSION['orderby']=='device_name'){echo 'selected';} ?> >Device</option>
					<option value="category" <?php if($_SESSION['orderby']=='category'){echo 'selected';} ?> >Category</option>
				</select>
				<label class="pull-right"> Order by : </label>
			{!! Form::close() !!}
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>User</th>
						<th>Device</th>
						<th></th>
						@if (Auth::user()->admin >= 1)						
						<th></th>
						@if (Auth::user()->admin >= 2)
						<th></th>
						@endif
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach ($devices as $device)
						<tr>
							<td>{!! $device->user_name !!}</td>
							<td class="text-primary"><strong>{!! $device->device_name !!}</strong></td>
							<td>{!! link_to_route('device.show', 'Show', [$device->id], ['class' => 'btn btn-success btn-block']) !!}</td>
							@if (Auth::user()->admin >= 1)
							<td>{!! link_to_route('device.edit', 'Edit', [$device->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							@if (Auth::user()->admin >= 2)
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['device.destroy', $device->id]]) !!}
									{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Are you sure?\')']) !!}
								{!! Form::close() !!}
							</td>
							@endif
							@endif
						</tr>
					@endforeach
	  			</tbody>
			</table>
			{{ $devices->appends(Request::except(['page', '_token']))->links() }}
			</div>
		</div>
		
		<br><br>
	</div>
@endsection