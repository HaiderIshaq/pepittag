<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report # {{$data['id']}}</title>
</head>
<style>
    .box{
        width: 100%;
        float: left;
        font-size: 13px
    }
    .box1{
        width: 60%;

    }
    .box2{
        width: 40%;        
    }
    .imgs{
 
        width:220px;
        height:180px !important;
        float:left;
        padding: 3px 3px 3px 3px;
        text-align:center
    }
         table, th, td {
            border: 1px solid black;
              border-collapse: collapse;
         }

         /* @page *{
    margin-top: 2.54cm;
    margin-bottom: 2.54cm;
    margin-left: 3.175cm;
    margin-right: 3.175cm;
} */
</style>
<body style="">
    <div style="padding-left:30px;padding-top:50px">

    <div style="text-align:center">
        <h4>Verification Report – Vehicle</h4>
    </div>
    <div class="row">
        <div class="box box1">
           <b> Date:</b> {{$data['report_date']}} 
        </div>
        <div class="box box2" style="text-align: right">
            <b>{{$data['ref_id']}}</b>
        </div>
    </div>

    {{-- General Info --}}
    <div class="row">
        <h5 style="text-decoration: underline">General Information</h5>
    </div>
    <div class="row">
        <table style="font-size:12px;width: 100%;">
            <tr  style="">
                <td style="padding:5px;width:30%;"> <b> Vehicle's Ownership: </b> </td>
                <td style="padding:5px;width:70%;">{{$data['is_vehicle_owned']}}</td>
            </tr>
        </table>
    </div>

    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="">
                <td style="padding:5px;width:30%;border-top:none"> <b> Site Accessible:  </b> </td>
                <td style="padding:5px;width:20%;border-top:none">{{$data['is_site_accessible']}}</td>
                <td style="padding:5px;width:30%;border-top:none"> <b> Same location:  </b> </td>
                <td style="padding:5px;width:20%;border-top:none">{{$data['same_location']}}</td>
            </tr>
 
 

        </table>
    </div>
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="border-top:none">
                <td style="padding:5px;width:30%;border-top:none"> <b> Site's Address: </b> </td>
                <td style="padding:5px;width:70%;border-top:none">{{$data['same_location']=="Yes"?$data['address']:$data['other_address']}}</td>
            </tr>
        </table>
    </div>
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="border-top:none">
                <td style="padding:5px;width:30%;border-top:none"> <b> Site's GPS: </b> </td>
                <td style="padding:5px;width:70%;border-top:none"> <a href="https://www.google.com/maps/search/?api=1&query={{$data['gps']}}" target="_blank"> {{$data['gps']}}</a></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="">

                <td style="padding:5px;width:30%;border-top:none"> <b> Contact No:  </b> </td>
                <td style="padding:5px;width:70%;border-top:none">{{$data['contact_no']}}</td>
            </tr>
 
 

        </table>
    </div>
    {{-- General Info --}}

    {{-- Technical Details --}}
    <div class="row">
        <h5 style="text-decoration: underline">Technical Details</h5>
    </div>
    <div class="row">
        <table style="font-size:12px;width: 100%">
            <tr  style="">
                <td style="padding:5px;width:30%;"> <b> Tag Number </b> </td>
                <td style="padding:5px;width:70%;">{{$data['tag_number']}}</td>
            </tr>
        </table>
    </div>
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="border-top:none">
                <td style="padding:5px;width:30%;border-top:none"> <b> Registration No:  </b> </td>
                <td style="padding:5px;width:20%;border-top:none">{{$data['reg_no']}}</td>
                <td style="padding:5px;width:30%;border-top:none"> <b> Existance:  </b> </td>
                <td style="padding:5px;width:20%;border-top:none">{{$data['existance']}}</td>
            </tr>
            <tr  style="">
                <td style="padding:5px;width:30%"> <b> Engine No: </b> </td>
                <td style="padding:5px;width:20%">{{$data['engine_no']}} / {{$data['chassis_no']}}</td>
                <td style="padding:5px;width:30%"> <b> Type: </b> </td>
                <td style="padding:5px;width:20%">{{$data['type']=='Other'?$data['type_other']:$data['type']}}</td>
            </tr>
 
            <tr  style="">
                <td style="padding:5px;width:30%"> <b> Make / Model: </b> </td>
                <td style="padding:5px;width:20%">{{$data['make']}}</td>
                <td style="padding:5px;width:30%"> <b>Vehicle Working Condition: </b> </td>
                <td style="padding:5px;width:20%">{{$data['functional']}}</td>
            </tr>

 

        </table>
    </div>

    @if($data['functional']=='No')
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="">
                <td style="padding:5px;width:30%;border-top:none"> <b> Reason For Not functional </b> </td>
                <td style="padding:5px;width:70%;border-top:none">{{$data['reason_for_no_operational']}}</td>
            </tr>
        </table>
    </div>
    @endif
    {{-- Technical Details --}}


    <div class="row">
        <h5 style="text-decoration: underline">Verification Images</h5>
    </div>
    @foreach ($data['images'] as $rec)
    <div class="imgs">
       <img src="storage/{{$rec->path}}" height="150" width="200" alt="">

   </div>                      
            
        
        @endforeach

    </div>
        

</body>
</html>