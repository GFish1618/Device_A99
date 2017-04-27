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
    <link href="{{url('/css/app.css')}}" rel="stylesheet">
    <link href="{{url('/css/profile_card.css')}}" rel="stylesheet">
    <link href="{{url('/css/breadcrumbs.css')}}" rel="stylesheet">


    <link rel="shortcut icon" href="{{url('/logo899.ico')}}" type="image/x-icon"/> 
    <link rel="icon" href="{{url('/logo899.ico')}}" type="image/x-icon"/>

    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/smoothness/jquery-ui.css" />


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

                                        <a href="/EquipmentReleaseResponsibilityForm.docx">
                                            Download <br>Responsability Form
                                        </a>

                                        @if (Auth::user()->admin == 2)                                        
                                        <a href="{{ route('device.exportxls') }}">
                                            Export to excel
                                        </a>

                                        <a href="{{ route('device.importxls') }}">
                                            Import from excel
                                        </a>

                                        <a href="{{ route('device.gdrive') }}">
                                            Import from <br>Google Drive
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
                                        <a href="{{ route('categories.index') }}">
                                            Categories
                                        </a>

                                        <a href="#" onclick="confirmation();">
                                            Reset database
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

                                        <a href="{{ url('/google/logout') }}">
                                            Logout
                                        </a>
                                        
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
    
        <!--<div class="panel panel-default">

        <div class="panel-body">
            <div class="card hovercard hidden-xs">
                <div class="cardheader">

                </div>

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
                            @if (Auth::user()->admin >= 1)
                                User
                            @else
                                Guest
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>-->

        <div class="list-group">
            <a href="{{ url('/device') }}" class="list-group-item">All</a>
            <div id="categories_list"></div>
            <div id="companies_list"></div>
        </div>

    </div>
    <!--
        @endif
        <ol class="breadcrumb breadcrumb-arrow">
            @if (preg_match("/\/device/", $_SERVER['REQUEST_URI']))
            <li><a href="{{route('device.index')}}">Devices</a></li>
                @if (preg_match("/\/category\//", $_SERVER['REQUEST_URI']))
                    <?php
                        $line=0;
                        while ($line<FileRepository::length()-1)
                        {
                            $txtline = FileRepository::readLine($line);
                            $txtline = substr($txtline, 0, -1);
                            if (preg_match("/\/".$txtline."/", $_SERVER['REQUEST_URI']))
                            {
                                echo('<li><a href="#">'.$txtline.'</a></li>');
                            }
                            $line++;
                        }
                    ?>
                @endif
                @if (preg_match("/\/search\//", $_SERVER['REQUEST_URI']))
                <li><a href="{{route('device.search')}}">Search</a></li>
                    @if (preg_match("/\/display/", $_SERVER['REQUEST_URI']))
                    <li><a class="active">Display</a></li>
                    @endif
                @endif
                @if (preg_match("/\/import/", $_SERVER['REQUEST_URI']))
                <li><a href="{{route('device.importxls')}}">Import from excel</a></li>
                @endif
            @endif

            @if (preg_match("/\/admin/", $_SERVER['REQUEST_URI']))
            <li><a href="{{route('admin.index')}}">Admin</a></li>
                @if (preg_match("/\/categories/", $_SERVER['REQUEST_URI']))
                <li><a href="{{route('device.addCatF')}}">Categories</a></li>
                @else
                <li><a href="{{route('admin.index')}}">Users</a></li>
                @endif
            @endif

        </ol>-->
        @yield('content')


        <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="{{ url('/js/app.js') }}"></script>

    <script language="JavaScript"> 
    function confirmation() {  
        if (confirm("Are you really sure you want to reset the database?")){
            if (confirm("Like really REALLY sure?")){
                location.replace("{{route('device.reset')}}"); 
            }
        } 
    }

    </script> 

    <script>
        $(function(){
            $('#categories_list').html('<h1 class="text-primary"><img src="{{url('ajax-loader.gif')}}"> . . . . . . .</h1>');
            $('#categories_list').load("{{ route('categories.list') }}");

            $('#companies_list').html('<h1 class="text-primary"><img src="{{url('ajax-loader.gif')}}"> . . . . . . .</h1>');
            $('#companies_list').load("{{ route('companies.list') }}");
        })
    </script>

    @yield('scripts')
        
        

    <!-- Scripts -->
    
</body>
</html>
