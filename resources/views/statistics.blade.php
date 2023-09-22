    @extends('layouts.app')
    


@section('content')

<div class="container-fluid" id="app">
    <section>

       <statistics 
       usertoken="{{$data['token']}}"
       userregion="{{$data['region']}}"
       usercity="{{$data['city']}}"
       url="{{url('/')}}"
       userrole="{!! json_encode(auth()->user()->role) !!}">
       
    </statistics>

       {{-- <h4>Hello</h4> --}}

    </section>

<br><br><br><br>
</div>


@endsection
