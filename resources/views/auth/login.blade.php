@extends('layouts.app')

@section('content')
<div class="col-sm-offset-2 col-sm-4">
    @if(session()->has('ok'))
            <div class="alert alert-danger alert-dismissible">{!! session('ok') !!}</div>
    @endif
            <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Login</h3>
            </div>
                <div class="panel-body">
                    <div>You're not connected</div>
                    <button onclick="location.href = '{{ url('/login/google') }}';" id="myButton" class="btn btn-danger pull-left" >Connect with Google</button>
                </div>
            </div>
</div>
@endsection
