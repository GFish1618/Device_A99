<?php use App\Repositories\FileRepository; ?>


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
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                        @else

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Devices <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('device') }}">
                                            Home
                                        </a>
                                        <a href="{{ route('device.search') }}">
                                            Search
                                        </a>
                                        <a href="{{ route('device.create') }}">
                                            Add a device
                                        </a>
                                        <a href="EquipmentReleaseResponsibilityForm.docx">
                                            Download <br>Responsability Form
                                        </a>
                                        
                                        <a href="{{ route('device.exportxls') }}">
                                            Export to excel
                                        </a>

                                        @if (Auth::user()->admin == 2)
                                        <a href="{{ url('device/import') }}">
                                            Import from excel
                                        </a>

                                            <SCRIPT LANGUAGE="JavaScript"> 
                                                function confirmation() { 
                                                var msg = "Are you really sure you want to reset the database?"; 
                                                if (confirm(msg)) 
                                                    location.replace("{{route('device.reset')}}"); 
                                                } 
                                            </SCRIPT> 

                                        <a href="#" onclick="confirmation();">
                                            Reset database
                                        </a>
                                        @endif

                                    </li>
                                </ul>
                            </li>
                            
                            @if (Auth::user()->admin >= 2)
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Admin <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/admin') }}">
                                            Users
                                        </a>
                                        <a href="{{ url('/admin/categories') }}">
                                            Categories
                                        </a>

                                    </li>
                                </ul>
                            </li>
                            @endif

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->nickname }} <span class="caret"></span>
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

        @if (!Auth::guest())
        <div class="container-fluid">
        <div class="col-sm-offset-0 col-sm-2">
    
        <div class="panel panel-default">
        <div class="panel-body">
        <div class="card hovercard">
                <div class="cardheader">

                </div>
                <?php
                    //$user = Socialite::driver('google')->userFromToken(Auth::user()->remember_token);
                ?>
                <div class="avatar">
                    <img alt="" src="{{ Auth::user()->avatar }}">
                </div>
                <div class="info">
                    <div class="title">
                        {{ Auth::user()->nickname }}
                    </div>
                     <div class="desc">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="desc">
                        {{ Auth::user()->email }}
                    </div>
                    <div class="desc">
                        @if (Auth::user()->admin >= 2)
                            Admin
                        @else
                            User
                        @endif
                    </div>
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

            <div class="list-group">
                <a href="{{ url('/device') }}" class="list-group-item">All</a>
                <?php
                    $line=0;
                    while ($line<FileRepository::length()-1)
                    {
                        echo('<a href="'.url('/device/category/'.FileRepository::readLine($line)).'" class="list-group-item">'.FileRepository::readLine($line).'</a>');
                        $line++;
                    }
                ?>
            </div>

        
        
        </div>
    </div>
        @endif
        @yield('content')
        

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
