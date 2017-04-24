
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Add a device</h4>
        </div>
        <div class="modal-body">
			{!! Form::open(['route' => 'device.store', 'class' => 'form-horizontal panel', 'id' => 'create_form']) !!}	

			<!--<div class="form-group">
				{!! Form::text('user_name', null, ['class' => 'form-control', 'placeholder' => 'Username*']) !!}
				<small class="help-block hide"></small>
			</div>-->

			<div class="form-group">
				{!! Form::text('device_name', null, ['class' => 'form-control', 'placeholder' => 'Device Name*']) !!}
				<small class="help-block hide"></small>
			</div>

			<div class="form-group">
				{!! Form::select('category_id', $cat_array, null, ['class' => 'form-control' , 'id' => 'category_select']) !!}
				<small class="help-block hide"></small>
			</div>

			<div id='fields_create'>
				<input type="hidden" class="form-control" name="number_of_fields" value="0" id="nb_fields_add">
			</div>

			{!! Form::submit('Add', ['class' => 'btn btn-primary pull-right']) !!}
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

	$(document).on('submit', '#create_form', function(e) { 
        e.preventDefault();
         
        $('input+small').text('');
        $('input').parent().removeClass('has-error');
         
        $.ajax({
            method: $(this).attr('method'),
            url: "{{ route('device.store') }}",
            data: $(this).serialize(),
            dataType: "json"
        })
        .done(function(data) {
        	window.location.replace("{{ url('device') }}")
        })
        .fail(function(data) {
            $.each(data.responseJSON, function (key, value) {
                var input = '#create_form [name=' + key + ']';
                $(input + '+small').removeClass('hide');
                $(input + '+small').text(value);
                $(input).parent().addClass('has-error');
            });
        });
    });

})

</script>