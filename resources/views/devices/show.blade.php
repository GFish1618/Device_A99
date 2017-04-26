<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ $device->device_name }}</h4>
        </div>
        <div class="modal-body">
			@if (Auth::user()->admin >= 2)
			{!! Form::open(['method' => 'DELETE', 'route' => ['device.destroy', $device->id]]) !!}
				{!! Form::submit('Delete', ['class' => 'btn btn-danger pull-right', 'onclick' => 'return confirm(\'Are you sure?\')']) !!}
			{!! Form::close() !!}
			@endif
			@if (Auth::user()->admin >= 1)
			<a class="btn btn-info pull-right btn_edit" href="#" value="{{ $device->id }}">Edit</a>
			@endif

				<!--<p><strong class="text-primary">Username : </strong> {{ $device->user_name }}</p>-->
				<p><strong class="text-primary">Device name : </strong> {{ $device->device_name }}</p>
				<p><strong class="text-primary">Category : </strong> {{ $category->category_name }}</p>

			<?php
				for($i=1 ; $i<=$category->number_of_fields ; $i++)
				{
					$name = 'field'.$i.'_name';
					$field = 'field'.$i;
					echo('
						<p><strong class="text-primary">'.$category->$name.' : </strong>'.$device->$field.'</p>
					');
				}
			?>
        </div>
    </div>
</div>

<script>
$(function(){
	$('.btn_edit').click(function(e) {
    	e.preventDefault();
    	$('#baseModal').html('<div class="modal-dialog"><div class="modal-content"><h1 class="modal-title text-primary"><img src="{{url('ajax-loader.gif')}}"> . . . . . . .</h1></div></div>');
        $('#baseModal').modal();
        $('#baseModal').load("{{ url('device') }}/" + $(this).attr("value") + "/edit");
    });
})
</script>