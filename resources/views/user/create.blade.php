@extends('layouts.app')
    


@section('content')
<div class="container-fluid" id="app">
    <section>
        
       <user-create usertoken="{{$data['token']}}" url="{{url('/')}}"></user-create>

    </section>


</div>


@endsection
