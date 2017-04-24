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
 		<a class="btn btn-success" id="add_category" href="#">Add a category</a>
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
						<th>Category</th>
						<th>Number of fields</th>	
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($categories as $category)
						<tr>
							<td class="text-primary"><strong>{!! $category->category_name !!}</strong></td>
							<td>{!! $category->number_of_fields !!}</td>
							<!--<td>{!! link_to_route('categories.edit', 'Edit', [$category->id], ['class' => 'btn btn-warning btn-block', 'id'=>'edit_category']) !!}
							</td>-->
							<td><a class="btn btn-info btn-block edit_category" href="#" value="{{ $category->id }}">Edit</a>
							</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['categories.destroy', $category->id]]) !!}
									{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Are you sure?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
			{{ $categories->appends(Request::except(['page', '_token']))->links() }}
			</div>
		</div>
		</div>
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Back
		</a>
		
		<br><br>
</div>



	<!-- Modal Add Section-->
	<div class="modal fade" id="add_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	                <h4 class="modal-title" id="myModalLabel">Add a category</h4>
	            </div>
	            <div class="modal-body">

	                {!! Form::open(['route' => 'categories.store', 'class' => 'form-horizontal panel', 'id'=>'add_Form']) !!}	

					<div class="form-group {!! $errors->has('category_name') ? 'has-error' : '' !!}">
						{!! Form::label('Category name') !!}
						{!! Form::text('category_name', null, ['class' => 'form-control', 'placeholder' => 'Category name']) !!}
						<small class="help-block"></small>
					</div>

					<div class="form-group {!! $errors->has('parents') ? 'has-error' : '' !!}">
						{!! Form::label('Parents') !!}
						{!! Form::text('parents', null, ['class' => 'form-control', 'placeholder' => 'Parents']) !!}
						{!! $errors->first('parents', '<small class="help-block">:message</small>') !!}
					</div>

						<div class="form-group" id="fields">
	                        <label class="control-label">Fields</label>
	                        <a href="#" class="btn btn-primary btn-success" id="add_field">+</a>
	                        <a href="#" class="btn btn-primary btn-danger" id="del_field">-</a>
	                    </div>
		
	                 <input type="hidden" class="form-control" name="number_of_fields" value="0" id="nb_fields_add">

					{!! Form::submit('Add', ['class' => 'btn btn-primary pull-right']) !!}
					{!! Form::close() !!}

	            </div>
	        </div>
	    </div>
	</div>

	<!-- Modal Edit Section-->
	@if (isset($category->id))
	<div class="modal fade" id="edit_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	                <h4 class="modal-title" id="myModalLabel">Edit category</h4>
	            </div>
	            <div class="modal-body">

	            {!! Form::open(['route' => ['categories.update', $category->id], 'method' => 'put', 'class' => 'form-horizontal panel', 'id'=>'edit_Form']) !!}

				<div id=wrapToFill1></div>

				    <a href="#" class="btn btn-primary btn-danger pull-right" id="del_field_edit">-</a>
				    <a href="#" class="btn btn-primary btn-success pull-right" id="add_field_edit">+</a>

				<div id=wrapToFill2></div>


				{!! Form::submit('Edit', ['class' => 'btn btn-primary pull-right']) !!}
				{!! Form::close() !!}


	            </div>
	        </div>
	    </div>
	</div>
	@endif
@endsection


@section('scripts')

<script>

$(function(){

	// Script for adding a new category
	var nb_fields = 0;

	$('#add_category').click(function() {
        $('#add_Modal').modal();
        nb_fields = parseInt($('#nb_fields_add').attr("value"));
    });

    $('#add_field').click(function() {
    	if(nb_fields < 30)
    	{
    		nb_fields += 1;
    		$('#nb_fields_add').attr("value", nb_fields);
	        $('#fields').append('<input type="text" class="form-control" name="field'+ nb_fields + '_name" placeholder="field'+ nb_fields + '" id="field'+ nb_fields + '"><small class="help-block" id="small'+ nb_fields + '"></small>');
    	}
    });

    $('#del_field').click(function() {
    	if(nb_fields >= 1)
    	{
    		$('#field'+nb_fields).remove();
    		$('#small'+nb_fields).remove();
 			nb_fields -= 1;
 			$('#nb_fields_add').attr("value", nb_fields);
    	}    	
    });


    // Script for editing a category
    var id_edit = 0;

    $('.edit_category').click(function(e) {
    	e.preventDefault();
        $('#edit_Modal').modal();
        $('#wrapToFill1').load("{{ url('categories') }}/" + $(this).attr("value") + "/edit #wrap1");
        $('#wrapToFill2').load("{{ url('categories') }}/" + $(this).attr("value") + "/edit #wrap2",
        function(){
        	nb_fields = parseInt($('#nb_fields_edit').attr("value"));
        });

        id_edit=$(this).attr("value");
    });

    $('#add_field_edit').click(function() {
    	if(nb_fields < 30)
    	{
    		nb_fields += 1;
    		$('#nb_fields_edit').attr("value", nb_fields);
	        $('#fields_edit').append('<input type="text" class="form-control" name="field'+ nb_fields + '_name" placeholder="field'+ nb_fields + '" id="field'+ nb_fields + '_edit"><small class="help-block" id="small'+ nb_fields + '_edit"></small>');
    	}
    });

    $('#del_field_edit').click(function() {
    	if(nb_fields >= 1)
    	{
    		$('#field'+nb_fields+'_edit').remove();
    		$('#small'+nb_fields+'_edit').remove();
 			nb_fields -= 1;
 			$('#nb_fields_edit').attr("value", nb_fields);
    	}    	
    });

    $(document).on('submit', '#edit_Form', function(e) {  
        e.preventDefault();
         
        $('input+small').text('');
        $('input').parent().removeClass('has-error');
         
        $.ajax({
            method: $(this).attr('method'),
            url: "{{ url('categories') }}/"+ id_edit,
            data: $(this).serialize(),
            dataType: "json"
        })
        .done(function(data) {
        	window.location.replace("{{ url('categories') }}")
        })
        .fail(function(data) {
            $.each(data.responseJSON, function (key, value) {
                var input = '#edit_Form input[name=' + key + ']';
                $(input + '+small').text(value);
                $(input).parent().addClass('has-error');
            });
        });
    });


})

</script>
@endsection