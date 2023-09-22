@extends('layouts.surveyapp')

@section('content')
<div class="container-fluid" id="app">
    {{-- <p>{{$data['token']}}sadas</p> --}}
    <survey-general 
    usertoken="{{$data['token']}}"
    id="{{$data['id']}}"
    userid="{{$data['user_id']}}"
    surveytypeis="{{$data['survey_type']}}"
    
    ></survey-general>
</div>

@endsection
