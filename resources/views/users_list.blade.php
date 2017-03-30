@extends('layouts.app')

@section('content')
    <div class="col-sm-offset-2 col-sm-4">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Users list</h3>
				{!! link_to_route('admin.search', 'Search', [], ['class' => 'btn btn-info pull-right']) !!}
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>Right</th>
						<th>User</th>
						<th>Email</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
						<tr>
							<td>
								@if($user->admin == 2)
									Admin
								@else
									@if($user->admin == 1)
										User
									@else
										Guest
									@endif
								@endif
							</td>
							<td>{!! $user->name !!}</td>
							<td>{!! $user->email !!}</td>
							<td>{!! link_to_route('admin.edit', 'Edit', [$user->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['admin.destroy', $user->id]]) !!}
									{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Are you sure?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
		</div>
		{{ $users->appends(Request::except('page'))->links() }}
		<br><br>
	</div>
@endsection