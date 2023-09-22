@extends('layouts.surveyapp')

@section('content')

<div class="container-fluid" id="app">
    {{-- <p>{{$data['token']}}sadas</p> --}}
    <survey-images 
    url="{{url('/')}}"
    usertoken="{{$data['token']}}"
    id="{{$data['id']}}"
    userid="{{$data['user_id']}}"
    
    ></survey-images>
</div>

@endsection
