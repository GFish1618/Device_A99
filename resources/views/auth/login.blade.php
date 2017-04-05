@extends('layouts.layout_login')

@section('content')
<!--<div class="col-sm-offset-2 col-sm-4">-->
    @if(session()->has('ok'))
            <div class="alert alert-danger alert-dismissible">{!! session('ok') !!}</div>
    @endif
          
        
         
               
                    <div>You're not connected</div>
                    <button onclick="location.href = '{{ url('/login/google') }}';" id="myButton" class="btn btn-danger" >Connect with Google</button>
               
<!--       
</div>-->
@endsection
