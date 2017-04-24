@extends('layouts.app')

@section('content')
	<div class="col-sm-offset-2 col-sm-4">
		<div class="panel panel-primary">	
			<div class="panel-heading"><h3 class="panel-title">Search for user</h3></div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					{!! Form::open(['route' => 'admin.display', 'class' => 'form-horizontal panel']) !!}	

					<div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
						{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'User']) !!}
						{!! $errors->first('name', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
						{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
						{!! $errors->first('email', '<small class="help-block">:message</small>') !!}
					</div>
					{!! Form::submit('Search', ['class' => 'btn btn-primary pull-right']) !!}
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