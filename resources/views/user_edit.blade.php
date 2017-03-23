@extends('layouts.app')

@section('content')
	<div class="col-sm-offset-2 col-sm-4">
		<div class="panel panel-primary">	
			<div class="panel-heading">
			<h3 class="panel-title">Edit User</h3></div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					{!! Form::model($user, ['route' => ['admin.update', $user->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}

					<div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
						{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
						{!! $errors->first('name', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group">
						<div class="checkbox">
							<label>
								{!! Form::checkbox('admin', 1, null) !!} Admin
							</label>
						</div>
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