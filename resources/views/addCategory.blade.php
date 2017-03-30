<?php use App\Repositories\FileRepository; ?>


@extends('layouts.app')

@section('content')
	<div class="col-sm-offset-2 col-sm-4">
		<div class="panel panel-primary">	
			<div class="panel-heading"><h3 class="panel-title">Category already entered</h3></div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					<?php
	                    $line=0;
	                    while ($line<FileRepository::length()-1)
	                    {
	                        echo(FileRepository::readLine($line).'<br>');
	                        $line++;
	                    }
	                ?>
				</div>
			</div>
		</div>

		<div class="panel panel-primary">	
			<div class="panel-heading"><h3 class="panel-title">Add a new category</h3></div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					{!! Form::open(['route' => 'device.addCatP', 'class' => 'form-horizontal panel']) !!}	

					<div class="form-group {!! $errors->has('new_category') ? 'has-error' : '' !!}">
						{!! Form::text('new_category', null, ['class' => 'form-control', 'placeholder' => 'New Category']) !!}
						{!! $errors->first('new_category', '<small class="help-block">:message</small>') !!}
					</div>

					{!! Form::submit('Add', ['class' => 'btn btn-primary pull-right']) !!}
					{!! Form::close() !!}
				</div>
			</div>
		</div>

		<div class="panel panel-primary">	
			<div class="panel-heading"><h3 class="panel-title">Delete a category</h3></div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					{!! Form::open(['route' => 'device.deleteCat', 'class' => 'form-horizontal panel']) !!}	

					<div class="form-group {!! $errors->has('category') ? 'has-error' : '' !!}">
						{!! Form::select('category', FileRepository::makeArray(), null, ['class' => 'form-control']) !!}
						{!! $errors->first('category', '<small class="help-block">:message</small>') !!}
					</div>

					{!! Form::submit('Delete', ['class' => 'btn btn-primary pull-right']) !!}
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