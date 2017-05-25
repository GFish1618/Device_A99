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
 		<a class="btn btn-primary" id="btn_add" href="#">Add a company</a>
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
						<th></th>
						<th>Company</th>	
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($companies as $company)
						<tr>
							<td>@if($company['logo']!='')
								<img src="{!! $company['logo'] !!}" alt="{!! $company['name'] !!}" style="width:50px;height:50px;">
							@endif</td>
							<td class="text-primary"><strong>{!! $company['name'] !!}</strong></td>
							<td><a class="btn btn-warning btn-block btn_edit" href="#" value="{{ $company['id'] }}">Edit</a>
							</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['companies.destroy', $company['id']]]) !!}
									{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Are you sure?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
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

	$('#btn_add').click(function(e) {
    	e.preventDefault();
    	$('#baseModal').html('<div class="modal-dialog"><div class="modal-content"><h1 class="modal-title text-primary"><img src="{{url('ajax-loader.gif')}}"> . . . . . . .</h1></div></div>');
        $('#baseModal').modal();
        $('#baseModal').load("{{ route('companies.create') }}");
    });

    $('.btn_edit').click(function(e) {
    	e.preventDefault();
    	$('#baseModal').html('<div class="modal-dialog"><div class="modal-content"><h1 class="modal-title text-primary"><img src="{{url('ajax-loader.gif')}}"> . . . . . . .</h1></div></div>');
        $('#baseModal').modal();
        $('#baseModal').load("{{ url('companies') }}/" + $(this).attr("value") + "/edit");
    });


})

</script>
@endsection