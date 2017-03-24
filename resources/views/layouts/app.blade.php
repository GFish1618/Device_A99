<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'A99') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/profile_card.css" rel="stylesheet">
     <link href="/css/breadcrumbs.css" rel="stylesheet">


    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body style="background-color: #e9ebee;">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/device') }}">
                        A99
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li><a href="{{ url('/admin') }}">Admin</a></li>
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
        <div class="col-sm-offset-0 col-sm-2">
    
        <div class="panel panel-default">
        <div class="panel-body">
        <div class="card hovercard">
                <div class="cardheader">

                </div>
                <div class="avatar">
                    <img alt="" src="http://lorempixel.com/100/100/people/1/">
                </div>
                <div class="info">
                    <div class="title">
                        <a target="_blank" href="http://scripteden.com/">John Doe</a>
                    </div>
                    <div class="desc">Passionate designer</div>
                    <div class="desc">Curious developer</div>
                    <div class="desc">Tech geek</div>
                </div>
                <div class="bottom">
                    <a class="btn btn-primary btn-twitter btn-sm" href="https://twitter.com/webmaniac">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a class="btn btn-danger btn-sm" rel="publisher"
                       href="https://plus.google.com/+ahmshahnuralam">
                        <i class="fa fa-google-plus"></i>
                    </a>
                    <a class="btn btn-primary btn-sm" rel="publisher"
                       href="https://plus.google.com/shahnuralam">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a class="btn btn-warning btn-sm" rel="publisher" href="https://plus.google.com/shahnuralam">
                        <i class="fa fa-behance"></i>
                    </a>
                </div>
            </div>
            </div>
            </div>

        <div class="list-group">
     
        <a href="{{ url('/device') }}" class="list-group-item">All</a>
        <a href="{{ url('/device/category/computers') }}" class="list-group-item">Computers</a>
        <a href="{{ url('/device/category/laptops') }}" class="list-group-item">Laptops</a>
        <a href="{{ url('/device/category/phones') }}" class="list-group-item">Phones</a>
        <a href="{{ url('/device/category/others') }}" class="list-group-item">Others</a>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Functions</h3>
            </div><br>
            <div class="panel-body">
                {!! link_to_route('device.search', 'Search', [], ['class' => 'btn btn-warning']) !!}
                {!! link_to_route('device.create', 'Add a device', [], ['class' => 'btn btn-success ']) !!}
                {!! link_to_route('device.exportxls', 'Export to excel', [], ['class' => 'btn btn-info']) !!}
            </div>
        </div>
    </div>

        @yield('content')
        
    </div>
    <div class="col-sm-2">
		<div class="panel panel-primary">	
			<div class="panel-heading"><h3 class="panel-title">Search for device</h3></div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					{!! Form::open(['route' => 'device.display', 'class' => 'form-horizontal panel']) !!}	

					<div class="form-group {!! $errors->has('user_name') ? 'has-error' : '' !!}">
						{!! Form::text('user_name', null, ['class' => 'form-control', 'placeholder' => 'Username']) !!}
						{!! $errors->first('user_name', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('device_name') ? 'has-error' : '' !!}">
						{!! Form::text('device_name', null, ['class' => 'form-control', 'placeholder' => 'Device Name']) !!}
						{!! $errors->first('device_name', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('category') ? 'has-error' : '' !!}">
						{!! Form::select('category', array(null => 'No category', 'computers' => 'Computer', 'laptops' => 'Laptop', 'phones' => 'Phone', 'others' => 'Others' ), null, ['class' => 'form-control']) !!}
						{!! $errors->first('category', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('mac_adress') ? 'has-error' : '' !!}">
						{!! Form::text('mac_adress', null, ['class' => 'form-control', 'placeholder' => 'Mac adress']) !!}
						{!! $errors->first('mac_adress', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('ownership') ? 'has-error' : '' !!}">
						{!! Form::text('ownership', null, ['class' => 'form-control', 'placeholder' => 'Ownership']) !!}
						{!! $errors->first('ownership', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('unit_sn') ? 'has-error' : '' !!}">
						{!! Form::text('unit_sn', null, ['class' => 'form-control', 'placeholder' => 'Unit S/N']) !!}
						{!! $errors->first('unit_sn', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('keyboard_sn') ? 'has-error' : '' !!}">
						{!! Form::text('keyboard_sn', null, ['class' => 'form-control', 'placeholder' => 'Keyboard S/N']) !!}
						{!! $errors->first('keyboard_sn', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('mouse_sn') ? 'has-error' : '' !!}">
						{!! Form::text('mouse_sn', null, ['class' => 'form-control', 'placeholder' => 'Mouse S/N']) !!}
						{!! $errors->first('mouse_sn', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group">
						<div class="checkbox">
							<label>
								{!! Form::checkbox('external_monitor', 1, null) !!} External monitor
							</label>
						</div>
						<div class="checkbox">
							<label>
								{!! Form::checkbox('external_mon_cable', 1, null) !!} External monitor cable
							</label>
						</div>
					</div>

					<div class="form-group {!! $errors->has('installed_memory') ? 'has-error' : '' !!}">
						{!! Form::text('installed_memory', null, ['class' => 'form-control', 'placeholder' => 'Installed memory']) !!}
						{!! $errors->first('installed_memory', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('core_speed') ? 'has-error' : '' !!}">
						{!! Form::text('core_speed', null, ['class' => 'form-control', 'placeholder' => 'Core speed']) !!}
						{!! $errors->first('core_speed', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('purchased_date') ? 'has-error' : '' !!}">
						{!! Form::date('purchased_date', null, ['class' => 'form-control', 'placeholder' => 'Purchased date']) !!}
						{!! $errors->first('purchased_date', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('current_location') ? 'has-error' : '' !!}">
						{!! Form::text('current_location', null, ['class' => 'form-control', 'placeholder' => 'Current location']) !!}
						{!! $errors->first('current_location', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">
						{!! Form::text('password', null, ['class' => 'form-control', 'placeholder' => 'Device password']) !!}
						{!! $errors->first('password', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('os_version') ? 'has-error' : '' !!}">
						{!! Form::text('os_version', null, ['class' => 'form-control', 'placeholder' => 'OS version']) !!}
						{!! $errors->first('os_version', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('department') ? 'has-error' : '' !!}">
						{!! Form::text('department', null, ['class' => 'form-control', 'placeholder' => 'Department']) !!}
						{!! $errors->first('department', '<small class="help-block">:message</small>') !!}
					</div>

					{!! Form::submit('Search', ['class' => 'btn btn-primary pull-right']) !!}
					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Back
		</a>
		<br><br>
	</div>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
