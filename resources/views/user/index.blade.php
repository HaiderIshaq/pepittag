@extends('layouts.app')
    


@section('content')
<div class="container-fluid" id="app">
    <section>
        
       <users usertoken="{{$data['token']}}" url="{{url('/')}}"></users>

    </section>


</div>


@endsection
