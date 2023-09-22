@extends('layouts.surveyapp')

@section('content')
<div class="container-fluid" id="app">
    {{-- <p>{{$data['token']}}sadas</p> --}}
    <edit-survey 
    usertoken="{{$data['token']}}"
    id="{{$data['id']}}"
    userid="{{$data['user_id']}}"
    assetstatus="{{$data['asset_survey_status']}}"
    sitestatus="{{$data['site_survey_status']}}"
    
    ></edit-survey>
</div>

@endsection
