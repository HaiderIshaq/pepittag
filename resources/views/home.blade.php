    @extends('layouts.app')
    


@section('content')
<div class="container-fluid" id="app">
    {{-- <trial></trial> --}}
    <section>
        {{-- <assets-stats 
        usertoken="{{$data['token']}}"
        userid="{{$data['id']}}"
        ></assets-stats> --}}
       <dashboard 
       usertoken="{{$data['token']}}"
       userregion="{{$data['region']}}"
       usercity="{{$data['city']}}"
       usercity="{{$data['city']}}"
       usercityname="{{$data['city_name']}}"
       userregion="{{$data['region']}}"
       usersubcityname="{{$data['sub_city_name']}}"
       usersubcityid="{{$data['sub_city']}}"

       url="{{url('/')}}"></dashboard>

    </section>


</div>


@endsection
