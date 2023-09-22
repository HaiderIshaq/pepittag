@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    {{-- <p>{{$data['token']}}sadas</p> --}}
    <edit-asset 
    usertoken="{{$data['token']}}"
    id="{{$data['id']}}"
    
    ></edit-asset>
</div>

@endsection
