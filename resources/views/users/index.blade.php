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
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Rights</th>
						<th>Name</th>
						<th>Email</th>						
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
						<tr>
							<td>
								@if($user->admin == 2)
									Admin
								@else
									@if($user->admin == 1)
										User
									@else
										Guest
									@endif
								@endif
							</td>
							<td>{!! $user->name !!}</td>
							<td>{!! $user->email !!}</td>
							<td>{!! link_to_route('admin.edit', 'Edit', [$user->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['admin.destroy', $user->id]]) !!}
									{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Are you sure?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
			{{ $users->appends(Request::except('page'))->links() }}
			</div>
		</div>
		
		<div class="modal fade" id="baseModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
	</div>
@endsection

@section('scripts')
<script>
$(function(){

    $('.btn_edit').click(function(e) {
    	e.preventDefault();
        $('#baseModal').modal();
        $('#baseModal').load("{{ url('device') }}/" + $(this).attr("value") + "/edit");
    });
})

</script>
@endsection