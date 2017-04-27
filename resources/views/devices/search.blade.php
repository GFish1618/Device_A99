<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Search devices</h4>
        </div>
        <div class="modal-body">
        	{!! Form::open(['route' => 'device.display', 'class' => 'form-horizontal panel', 'method' => 'post']) !!}

			<div class="form-group {!! $errors->has('device_name') ? 'has-error' : '' !!}">
				{!! Form::text('device_name', null, ['class' => 'form-control', 'placeholder' => 'Device Name*']) !!}
				{!! $errors->first('device_name', '<small class="help-block">:message</small>') !!}
			</div>
			
			<div class="form-group">
				{!! Form::select('company_id', $comp_array, null, ['class' => 'form-control']) !!}
				{!! $errors->first('category_id', '<small class="help-block">:message</small>') !!}
			</div>

			<div class="form-group {!! $errors->has('device_name') ? 'has-error' : '' !!}">
				{!! Form::text('department', null, ['class' => 'form-control', 'placeholder' => 'Department']) !!}
				{!! $errors->first('department', '<small class="help-block">:message</small>') !!}
			</div>

			<div class="form-group">
				{!! Form::select('category_id', $cat_array, null, ['class' => 'form-control' , 'id' => 'category_select']) !!}
				{!! $errors->first('category_id', '<small class="help-block">:message</small>') !!}
			</div>

			<div id='fields_create'>
				<input type="hidden" class="form-control" name="number_of_fields" value="0" id="nb_fields_add">
			</div>

			{!! Form::submit('Search', ['class' => 'btn btn-primary pull-right']) !!}
			{!! Form::close() !!}
        </div>
    </div>
</div>

<script>

$(function(){

	$('#category_select').change(function() {
		category_id = $('#category_select').val();
		$('#fields_create').load("{{url('categories/fields')}}/create/"+category_id);
	});

})

</script>