@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    {{-- <p>{{$data['token']}}sadas</p> --}}
    <create-asset usertoken="{{$data['token']}}"></create-asset>
</div>

@endsection
