@foreach ($companies as $company)
	<a href="#comp_list{!! $company['id'] !!}" class="list-group-item" data-toggle="collapse">
		@if($company['logo']!='')
			<img src="{!! $company['logo'] !!}" alt="{!! $company['name'] !!}" style="width:20px;height:20px;">
		@endif
		{!! $company['name'] !!}
		<span class="caret"></span>
	</a>

	<div id="comp_list{!! $company['id'] !!}" class="collapse">
            <a href="{{ url('/device/company/'.$company['id']) }}" class="btn">
                All
            </a>
            @foreach ($company['departments'] as $department)
				<a href="{{ url('/device/company/'.$company['id'].'/'.$department) }}" class="btn">
	                {!! $department !!}
	            </a>
            @endforeach
	</div>
@endforeach