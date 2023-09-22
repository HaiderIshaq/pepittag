@extends('layouts.app')
    


@section('content')
<div class="container-fluid" id="app">
    <section>
        
       <user-edit  usertoken="{{$data['token']}}" jobid="{{$data['id']}}" url="{{url('/')}}"></user-edit>

    </section>


</div>


@endsection
