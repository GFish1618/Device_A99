<a href="#cat_list" class="list-group-item" data-toggle="collapse">
	Categories
	<span class="caret"></span>
</a>

<div id="cat_list" class="collapse">
    <a href="{{ url('/device') }}" class="btn">All</a>

	@foreach ($categories as $category)
		<a href="{{ url('/device/category/'.$category->id) }}" class="btn">{!! $category->category_name !!}</a>
	@endforeach
</div>

