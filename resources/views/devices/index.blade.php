@extends('layouts.app')

@section('content')
    <div class="col-sm-8">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{!! session('ok') !!}</div>
		@endif
		@if(session()->has('error'))
			<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{!! session('error') !!}</div>
		@endif
		<div class="panel panel-default">
 		<div class="panel-body">
 		@if (Auth::user()->admin >= 1)
 		<a class="btn btn-primary btn_add" href="#">Add a device</a>
 		@endif
 		<a class="btn btn-primary btn_search" href="#">Search</a>
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
					<option value="department" <?php if($_SESSION['orderby']=='department'){echo 'selected';} ?> >Departments</option>
					<option value="device_name" <?php if($_SESSION['orderby']=='device_name'){echo 'selected';} ?> >Device</option>
					<option value="category_id" <?php if($_SESSION['orderby']=='category_id'){echo 'selected';} ?> >Category</option>
				</select>
				<label class="pull-right"> Order by : </label>
			{!! Form::close() !!}
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Device</th>
						<th >Company</th>
						<th class="hidden-xs">Department</th>
						<th class="hidden-xs">Category</th>
						<th class="hidden-md hidden-xs hidden-sm">First field</th>
						<th></th>
						@if (Auth::user()->admin >= 1)
						<th class="hidden-xs hidden-sm"></th>
						@if (Auth::user()->admin >= 2)
						<th class="hidden-xs hidden-sm"></th>
						@endif
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach ($devices as $device)
						<tr>
							<td class="text-primary"><a class="btn_show" href="#" value="{{ $device->id }}"><strong>{!! $device->device_name !!}</strong></a></td>
							<td >
							@if ($device->company->logo!='')
								<img src="{!! $device->company->logo !!}" alt="{!! $device->company->name !!}" style="width:40px;height:40px;">
							@else
								{!! $device->company->name !!}
							@endif
							</td>
							<td class="hidden-xs">{!! $device->department !!}</td>
							<td class="hidden-xs">{!! $device->category->category_name !!}</td>
							<td class="hidden-md hidden-xs hidden-sm">{!! $device->field1 !!}</td>
							<td><a class="btn btn-success btn-block btn_show" href="#" value="{{ $device->id }}">Show</a></td>
							@if (Auth::user()->admin >= 1)
							<td class="hidden-xs hidden-sm"><a class="btn btn-warning btn-block btn_edit" href="#" value="{{ $device->id }}">Edit</a></td>
							@if (Auth::user()->admin >= 2)
							<td class="hidden-xs hidden-sm">
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
	</div>
</div>

	<div class="modal fade" id="baseModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	</div>

@endsection

@section('scripts')
<script>
$(function(){

    $('.btn_edit').click(function(e) {
    	e.preventDefault();
    	$('#baseModal').html('<div class="modal-dialog"><div class="modal-content"><h1 class="modal-title text-primary"><img src="{{url('ajax-loader.gif')}}"> . . . . . . .</h1></div></div>');
        $('#baseModal').modal();
        $('#baseModal').load("{{ url('device') }}/" + $(this).attr("value") + "/edit");
    });

    $('.btn_show').click(function(e) {
    	e.preventDefault();
    	$('#baseModal').html('<div class="modal-dialog"><div class="modal-content"><h1 class="modal-title text-primary"><img src="{{url('ajax-loader.gif')}}"> . . . . . . .</h1></div></div>');
        $('#baseModal').modal();
        $('#baseModal').load("{{ url('device') }}/" + $(this).attr("value"));
    });

    $('.btn_add').click(function(e) {
    	e.preventDefault();
    	$('#baseModal').html('<div class="modal-dialog"><div class="modal-content"><h1 class="modal-title text-primary"><img src="{{url('ajax-loader.gif')}}"> . . . . . . .</h1></div></div>');
        $('#baseModal').modal();
        $('#baseModal').load("{{ route('device.create') }}");
    });

    $('.btn_search').click(function(e) {
    	e.preventDefault();
    	$('#baseModal').html('<div class="modal-dialog"><div class="modal-content"><h1 class="modal-title text-primary"><img src="{{url('ajax-loader.gif')}}"> . . . . . . .</h1></div></div>');
        $('#baseModal').modal();
        $('#baseModal').load("{{ route('device.search') }}");
    });

})

</script>
@endsection