<a href="{{ url('/device') }}" class="list-group-item">All</a>

@foreach ($categories as $category)
	<a href="{{ url('/device/category/'.$category->id) }}" class="list-group-item">{!! $category->category_name !!}</a>
@endforeach