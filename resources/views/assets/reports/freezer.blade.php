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
        {{-- <div class="row">
            <div class="box box1">
               <img src="img/logo.png" style="width: 40%"> 
            </div>
            <div class="box box2" style="text-align: right">
               <img src="img/pespi.png" style="width: 40%"> 

            </div>
        </div> --}}
    <div style="text-align:center ">
        <h4>Verification Report – Freezer / Cooler</h4>
    </div>
    <div class="row">
        <div class="box box1">
           <b> Date:</b> {{$data['report_date']}} 
        </div>
        <div class="box box2" style="text-align: right">
            <b>{{$data['ref_id']}}</b> <br>
            <b>{{$data['city_name']}},{{$data['district_name']}}</b>
        </div>
    </div>

    {{-- General Info --}}
    <div class="row">
        <h5 style="text-decoration: underline">General Information</h5>
    </div>

    <div class="row">
        <table style="font-size:12px;width: 100%;">
            <tr  style="">
                <td style="padding:5px;width:30%;"> <b> Site Accessible:  </b> </td>
                <td style="padding:5px;width:20%;">{{$data['is_site_accessible']}}</td>
                <td style="padding:5px;width:30%;"> <b> Same location:  </b> </td>
                <td style="padding:5px;width:20%;">{{$data['same_location']}}</td>
            </tr>
 
            <tr  style="">
                <td style="padding:5px;width:30%"> <b> Shop's Name: </b> </td>
                <td style="padding:5px;width:20%">{{$data['shop_name']}}</td>
                <td style="padding:5px;width:30%"> <b> Shopkeeper's Name: </b> </td>
                <td style="padding:5px;width:20%">{{$data['shopkeeper_name']}}</td>
            </tr>
 

        </table>
    </div>
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="border-top:none">
                <td style="padding:5px;width:30%;border-top:none"> <b> Shop's Address: </b> </td>
                <td style="padding:5px;width:70%;border-top:none">{{$data['same_location']=="Yes"?$data['address']:$data['other_address']}}</td>
            </tr>
        </table>
    </div>
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="border-top:none">
                <td style="padding:5px;width:30%;border-top:none"> <b> Shop's GPS: </b> </td>
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
                <td style="padding:5px;width:30%;border-top:none"> <b> Operation / Functinal:  </b> </td>
                <td style="padding:5px;width:70%;border-top:none">{{$data['functional']}}</td>

            </tr>
            <tr  style="border-top:none">
                <td style="padding:5px;width:30%;border-top:none"> <b> Reason For Not Operational:  </b> </td>
                <td style="padding:5px;width:70%;border-top:none">{{$data['functional']=='Yes'?'None':$data['reason_for_no_operational']}}</td>

            </tr>
        </table>
    </div>
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">

            <tr  style="border-top:none">
                <td style="padding:5px;width:30%;border-top:none"> <b> Cooler / Freezer Accessible:  </b> </td>
                <td style="padding:5px;width:20%;border-top:none">{{$data['is_cooler_accessible']}}</td>
                <td style="padding:5px;width:30%;border-top:none"> <b> Existance:  </b> </td>
                <td style="padding:5px;width:20%;border-top:none">{{$data['existance']}}</td>
            </tr>

            <tr  style="">
                <td style="padding:5px;width:30%"> <b> Model No: </b> </td>
                <td style="padding:5px;width:20%">{{$data['model_number']}}</td>
                <td style="padding:5px;width:30%"> <b> Type: </b> </td>
                <td style="padding:5px;width:20%">{{$data['type']=='Other'?$data['type_other']:$data['type']}}</td>
            </tr>
 
            <tr  style="">
                <td style="padding:5px;width:30%"> <b> General Condition: </b> </td>
                <td style="padding:5px;width:20%">{{$data['general_condition']}}</td>
                <td style="padding:5px;width:30%"> <b>Volume Utilization: </b> </td>
                <td style="padding:5px;width:20%">{{$data['volume']}}</td>
            </tr>

 

        </table>
    </div>
    
    
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="">
                <td style="padding:5px;width:30%;border-top:none"> <b> Inventory Utilization </b> </td>
                <td style="padding:5px;width:70%;border-top:none">{{$data['utilization']}}</td>
            </tr>
        </table>
    </div>
    @if($data['utilization']=='Shared')
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="">
                <td style="padding:5px;width:30%;border-top:none"> <b> Pepsi Product:  </b> </td>
                <td style="padding:5px;width:20%;border-top:none">{{$data['utilization_pepsi']}}%</td>
                <td style="padding:5px;width:30%;border-top:none"> <b> Shared Products:  </b> </td>
                <td style="padding:5px;width:20%;border-top:none">{{$data['utilization_shared']}}%</td>
            </tr>
 
 

        </table>
    </div>
    <div class="row">
        <table style="font-size:12px;width: 100%;border-top:none">
            <tr  style="">
                <td style="padding:5px;width:30%;border-top:none"> <b> Shared Products name(s): </b> </td>
                <td style="padding:5px;width:70%;border-top:none">{{$data['shared_products_name']}}</td>
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