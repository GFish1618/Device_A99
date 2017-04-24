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
			<div class="panel-heading"><h3 class="panel-title">Import from an .xls file</h3></div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					{!! Form::open(['route' => 'device.importxls', 'class' => 'form-horizontal panel', 'files' => 'true']) !!}	

					<div class="form-group {!! $errors->has('file') ? 'has-error' : '' !!}">
						{!! Form::file('file', null, ['class' => 'form-control', 'placeholder' => 'Username']) !!}
						{!! $errors->first('file', '<small class="help-block">:message</small>') !!}
					</div>

					{!! Form::submit('Use this file', ['class' => 'btn btn-primary pull-right']) !!}
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