@extends('layouts.app')

@section('content')
	<div class="col-sm-offset-2 col-sm-4">
		<div class="panel panel-primary">	
			<div class="panel-heading">
			<h3 class="panel-title">Edit User: <br>{{$user->name}}</h3></div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					{!! Form::model($user, ['route' => ['admin.update', $user->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}

					<div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
						{!! Form::label('Nickname') !!}
						{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
						{!! $errors->first('name', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('admin') ? 'has-error' : '' !!}">
						{!! Form::label('Right') !!}
						{!! Form::select('admin', ['0' => 'Guest', '1' => 'User', '2' => 'Admin'], null, ['class' => 'form-control']) !!}
						{!! $errors->first('admin', '<small class="help-block">:message</small>') !!}
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