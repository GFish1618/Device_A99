<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit company "{{ $company->name }}"</h4>
        </div>
        <div class="modal-body">
        	{!! Form::model($company, ['route' => ['companies.update', $company->id], 'method' => 'put', 'class' => 'form-horizontal panel', 'id' => 'edit_form']) !!}

			<!--<div class="form-group">
				{!! Form::label('User name') !!}
				{!! Form::text('user_name', null, ['class' => 'form-control', 'placeholder' => 'Username*']) !!}
				<small class="help-block hide"></small>
			</div>-->

			<div class="form-group">
				{!! Form::label('Company name') !!}
				{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Company Name*']) !!}
				<small class="help-block hide"></small>
			</div>

			<div class="form-group">
				{!! Form::label('Logo') !!}
				{!! Form::text('logo', null, ['class' => 'form-control', 'placeholder' => 'Logo']) !!}
                <small class="help-block hide"></small>
            </div>

			<div class="form-group">
				{!! Form::label('Departments') !!}
				{!! Form::text('departments', null, ['class' => 'form-control', 'placeholder' => 'Departments']) !!}
				<small class="help-block hide"></small>
			</div>
			
			{!! Form::submit('Edit', ['class' => 'btn btn-primary pull-right']) !!}
			{!! Form::close() !!}
        </div>
    </div>
</div>

					

<script>

$(function(){

	id_edit=<?php echo($company->id); ?>;

	$(document).on('submit', '#edit_form', function(e) {
        e.preventDefault();
         
        $('input+small').text('');
        $('input').parent().removeClass('has-error');
         
        $.ajax({
            method: $(this).attr('method'),
            url: "{{ url('companies') }}/"+id_edit,
            data: $(this).serialize(),
            dataType: "json"
        })
        .done(function(data) {
        	window.location.replace("{{ url('companies') }}")
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