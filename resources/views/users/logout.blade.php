@extends('layouts.app')

@section('content')

<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<script type="text/javascript">
    document.getElementById("logout-form").submit();
</script>

@endsection