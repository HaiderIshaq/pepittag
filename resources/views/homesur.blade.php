
     @extends('layouts.surveyapp')



@section('content')
<div class="container-fluid" id="app">
    {{-- <trial></trial> --}}

    <section>
        {{-- <assets-stats></assets-stats> --}}
       <surveyor-dashboard 
       usertoken="{{$data['token']}}"
       userid="{{$data['id']}}"
       username="{{$data['user_name']}}"
       usercity="{{$data['city']}}"
       usercityname="{{$data['city_name']}}"
       userregion="{{$data['region']}}"
       usersubcityname="{{$data['sub_city_name']}}"
       usersubcityid="{{$data['sub_city']}}"
       
       ></surveyor-dashboard>

    </section>

</div>


@endsection
