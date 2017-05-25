<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit device "{{ $device->device_name }}"</h4>
        </div>
        <div class="modal-body">
        	{!! Form::model($device, ['route' => ['device.update', $device->id], 'method' => 'put', 'class' => 'form-horizontal panel', 'id' => 'edit_form']) !!}

			<!--<div class="form-group">
				{!! Form::label('User name') !!}
				{!! Form::text('user_name', null, ['class' => 'form-control', 'placeholder' => 'Username*']) !!}
				<small class="help-block hide"></small>
			</div>-->

			<div class="form-group">
				{!! Form::label('Device name') !!}
				{!! Form::text('device_name', null, ['class' => 'form-control', 'placeholder' => 'Device Name*']) !!}
				<small class="help-block hide"></small>
			</div>

			<div class="form-group">
				{!! Form::label('Company') !!}
                {!! Form::select('company_id', $comp_array, null, ['class' => 'form-control' , 'id' => 'company_select']) !!}
                <small class="help-block hide"></small>
            </div>

			<div class="form-group">
				{!! Form::label('Department') !!}
				{!! Form::text('department', null, ['class' => 'form-control', 'placeholder' => 'Department']) !!}
				<small class="help-block hide"></small>
			</div>

			<div class="form-group">
				{!! Form::label('Category') !!}
				{!! Form::select('category_id', $cat_array, null, ['class' => 'form-control' , 'id' => 'category_select']) !!}
				<small class="help-block hide"></small>
			</div>

			<hr>

			<div id='fields_edit'>

				<?php
					for($i = 1; $i <= $category->number_of_fields; $i++)
			    	{
			    		$name = 'field'.$i.'_name';
			    		$field = 'field'.$i;
			    		echo('
			    			<div class="form-group">
			    				<label>'.$category->$name.'</label>
				    			<input type="text" class="form-control" name="field'.$i.'" placeholder="'.$category->$name.'" value="'.$device->$field.'">
			    			</div>
			    		');
			    	}
				?>

				<input type="hidden" class="form-control" name="number_of_fields" value="0" id="nb_fields_add">
			</div>
			
			{!! Form::submit('Edit', ['class' => 'btn btn-primary pull-right']) !!}
			{!! Form::close() !!}
        </div>
    </div>
</div>

					

<script>

$(function(){

	id_edit=<?php echo($device->id); ?>;

	$('#category_select').change(function() {
		category_id = $('#category_select').val();
		$('#fields_edit').load("{{url('categories/fields')}}/edit/"+category_id);
	});

	$(document).on('submit', '#edit_form', function(e) {
        e.preventDefault();
         
        $('input+small').text('');
        $('input').parent().removeClass('has-error');
         
        $.ajax({
            method: $(this).attr('method'),
            url: "{{ url('device') }}/"+id_edit,
            data: $(this).serialize(),
            dataType: "json"
        })
        .done(function(data) {
        	window.location.reload(true);
        })
        .fail(function(data) {
            $.each(data.responseJSON, function (key, value) {
                var input = '#edit_form [name=' + key + ']';
                $(input + '+small').removeClass('hide');
                $(input + '+small').text(value);
                $(input).parent().addClass('has-error');
            });
        });
    });

})

</script>