<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon;
use File;
use Illuminate\Support\Collection;


class AssetAppController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // date_default_timezone_set("Asia/Karachi");
    }
    public function login(Request $request)
    {


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...

            $user = Auth::user();
            $token =  $user->createToken('KgtERP')->accessToken;
            
            // $log = new Log;
            // $log->user_id = $request->user()->id;
            // $log->activity = "User Logged In";
            // $log->date = date('Y/m/d');
            // $log->time = date("h:i:sa");
            // $log->service = '';
            // $log->save();
            
            return response()->json([
                "success" => true,
                "token" => $token,
                "username" => $user->name,
                "userid" => $user->id,
                // "user"=>$user
            ]);
        }
        else{
            return response()->json([
                "success" => false,
                "message"=>'Something went wrong credentials maybe wrong'
            ]);
        }


      
    }
    public function addImages($id,Request $request)
    {

        // $sur=DB::table('prism_surveys')->where('job_id',$id)->select('*')->get();

        // Storage::disk('public')->makeDirectory('assets/'.$asset->id);

    
        $files = $request->file('image');
        $path = public_path('storage/assets/'.$id);

        if(!File::isDirectory($path)){
            Storage::disk('public')->makeDirectory('assets/'.$id);


        }
        foreach($files as $file)
        {


            $fname = Str::random(28);
            $filename = Storage::disk('public')->putFileAs('assets/'.$id, $file, $fname . '.jpg');

            $job = DB::table('assets_images')->insert([
                'asset_id' => $id,
                'title' => $fname . '.jpg',
                'path' =>  $filename,
                'created_by' =>  Auth::user()->id,
                'uploaded_on' =>  date('Y-m-d'),

            ]);

        }

        
        

         return response()->json([
            "success" => true
            // "height" => $height,
            // // "heightper" =>$heightper,
            // "width" => $width,
            // // "widthper" => $widthper,
            // "imagepath" => url('/')."/".$path,
        ]);
    }
    public function submitSurvey(Request $request,$id)
    {
        date_default_timezone_set("Asia/Karachi");
        $job= DB::table('assets')
        ->where('id', $id)
        ->update([
            'status' => 1,
            'conducted_on'=>date('Y-m-d H:i:s')
          
        ]);

        return response()->json([
            "success" => true
        ]);
        
    }
    public function submitSiteSurvey(Request $request,$id)
    {
        date_default_timezone_set("Asia/Karachi");
        
        $db=DB::table('assets')
        ->where('id',$id)
        ->select('site_id')
        ->get();

        $job= DB::table('asset_site_details')
        ->where('id', $db[0]->site_id)
        ->update([
            'status' => 1,
            'conducted_on'=>date('Y-m-d H:i:s')
          
        ]);

        return response()->json([
            "success" => true
        ]);
        
    }
    public function updategps(Request $request,$id)
    {
        // date_default_timezone_set("Asia/Karachi");

        $db=DB::table('assets')->where('id',$id)->select('site_id')->get();

        $job= DB::table('asset_site_details')
        ->where('id', $db[0]->site_id)
        ->update([
            'gps' => $request->gps
        ]);

        return response()->json([
            "success" => true
        ]);
        
    }
    public function getappImages($id)
    {


        $job = DB::table('assets_images')
        ->where('asset_id',$id)
        // ->where('title','!=','video')
        ->select('path')
        ->get();

        $images=collect([]);

        foreach($job as $item)
        {
            $images->push($item->path);

        }
        $images->all();

        

        if(!$job->isEmpty())
        {
            $data=[
                "status"=>true,
                "error"=>'',
                "data"=>$images
            ];
           
        }
        else{
            $data=[
                "status"=>false,
                "error"=>'',
                "data"=>$job
            ];
        }
       

        return response()->json($data);


    }
    public function getSurveys(Request $request,$id)
    {
       
        if($request->type==1)
        {
            $job = DB::table('assets');
            $job =$job->where('asset_site_details.city',Auth::user()->city);
            $job =$job->where('asset_site_details.sub_city',$request->sub_city);
            $job =$job->where('assets.bottler',$request->bottler);
            $job =$job->where('assets.status',$request->status);
            $job =$job->where('assets.asset_type',$request->type);
            $job =$job->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
            $job =$job->leftJoin('city','asset_site_details.city','=','city.id');
            $job =$job->leftJoin('region','city.region_id','=','region.id');
            $job =$job->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
            $job =$job->leftJoin('asset_type','assets.asset_type','=','asset_type.id');
            $job =$job->leftJoin('asset_details','assets.id','=','asset_details.asset_id');

            if($request->search_by=='ID')
            {
                // $job=$job->where('assets.id', 'like', '%' . $request->search_value . '%');
                $job=$job->where('assets.id',$request->search_value);
            }
            else if($request->search_by=='Shop Name')
            {
                $job=$job->where('asset_site_details.shop_name', 'like', '%' . $request->search_value . '%');
            }
            else if($request->search_by=='Address')
            {
                $job=$job->where('asset_site_details.address', 'like', '%' . $request->search_value . '%');
            }
            else if($request->search_by=='Contact')
            {
                $job=$job->where('asset_site_details.contact_no', 'like', '%' . $request->search_value . '%');
            }
            else if($request->search_by=='Shopkeeper')
            {
                $job=$job->where('asset_site_details.shopkeeper_name', 'like', '%' . $request->search_value . '%');
            }
            $job =$job->select(
                'assets.id as job_id',
                'assets.id',
                'assets.title',
                'assets.status',
                'assets.created_at',
                // DB::raw('region.name, city.name, sub_city_name as region'),
                'region.name as region_name',
                'city.name as city_name',
                'city.prefix as city_prefix',
                'sub_city.name as sub_city_name',
                'asset_type.name as asset_type',
                'asset_type.id as asset_id',
                'asset_details.make',
                'asset_details.engine_no',
                'asset_details.chassis_no',
                'asset_details.reg_no',
                'asset_site_details.shop_name',
                'asset_site_details.shopkeeper_name',
                'asset_details.tag_number',
                'asset_site_details.address',
                'asset_site_details.contact_no',
                'assets.assigned_on',
                'assets.age_of_asset as age_of_asset'
               
            )
            ->orderBy('assets.id','ASC')
            ->get();
    
        }

        else{
            $job = DB::table('assets');
            $job=$job->where('assets.bottler',$request->bottler);
            $job=$job->where('assets.status',$request->status);
            $job=$job->where('assets.asset_type',$request->type);
            $job=$job->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
            $job=$job->leftJoin('city','asset_site_details.city','=','city.id');
            $job=$job->leftJoin('region','city.region_id','=','region.id');
            $job=$job->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
            $job=$job->leftJoin('asset_type','assets.asset_type','=','asset_type.id');
            $job=$job->leftJoin('asset_details','assets.id','=','asset_details.asset_id');
            if($request->search_by=='ID')
            {
                // $job=$job->where('assets.id', 'like', '%' . $request->search_value . '%');
                $job=$job->where('assets.id',$request->search_value);
            }
            else if($request->search_by=='Make')
            {
                $job=$job->where('asset_details.make', 'like', '%' . $request->search_value . '%');
            }
            else if($request->search_by=='Engine')
            {
                $job=$job->where('asset_details.engine_no', 'like', '%' . $request->search_value . '%');
            }
            else if($request->search_by=='Chassis')
            {
                $job=$job->where('asset_details.chassis_no', 'like', '%' . $request->search_value . '%');
            }
            else if($request->search_by=='RegNo')
            {
                $job=$job->where('asset_details.reg_no', 'like', '%' . $request->search_value . '%');
            }
            $job=$job->select(
                'assets.id as job_id',
                'assets.id',
                'assets.title',
                'assets.status',
                'assets.created_at',
                // DB::raw('region.name, city.name, sub_city_name as region'),
                'region.name as region_name',
                'city.name as city_name',
                'city.prefix as city_prefix',
                'sub_city.name as sub_city_name',
                'asset_type.name as asset_type',
                'asset_type.id as asset_id',
                'asset_details.make',
                'asset_details.engine_no',
                'asset_details.chassis_no',
                'asset_details.reg_no',
                'asset_site_details.shop_name',
                'asset_site_details.shopkeeper_name',
                'asset_details.tag_number',
                'asset_site_details.address',
                'asset_site_details.contact_no',
                'assets.assigned_on',
                'assets.age_of_asset as age_of_asset'
               
            );
            $job=$job->orderBy('assets.id','ASC');
            $job=$job->get();
    
        }
    



        $recs=collect([]);

        foreach($job as $item)
        {
            $recs->push([
                'job_id'=>$item->job_id,
                'id'=>$item->id,
                'title'=>$item->title,
                'status'=>$item->status,
                'statusis'=>$item->status==1?'Completed':'Active',
                'region_name'=>$item->region_name,
                'city_name'=>$item->city_name,
                'city_prefix'=>$item->city_prefix,
                'sub_city_name'=>$item->sub_city_name,
                'asset_type'=>$item->asset_type,
                'asset_id'=>$item->asset_id,
                'make'=>$item->make,
                'engine_no'=>$item->engine_no,
                'chassis_no'=>$item->chassis_no,
                'reg_no'=>$item->reg_no,
                'shop_name'=>$item->shop_name,
                'shopkeeper_name'=>$item->shopkeeper_name,
                'tag_number'=>$item->tag_number,
                'address'=>$item->address,
                'contact_no'=>$item->contact_no,
                'assigned_on'=> Carbon\Carbon::parse($item->created_at)->diffForHumans(),
                'assigned_on_year'=> date_format(date_create($item->created_at),'Y'),
                'age_of_asset'=>$item->age_of_asset 

            ]);
        }
        $recs->all();
      
        // if(!$job->isEmpty())
        // {
        //     $data=[
        //         "status"=>true,
        //         "error"=>'',
        //         "data"=>$job
        //     ];
           
        // }
        // else{
        //     $data=[
        //         "status"=>false,
        //         "error"=>'',
        //         "data"=>$job
        //     ];
        // }
       

        // return response()->json($data);
        
        return $recs;


    }
    public function getSurveysByStatus($id,Request $request)
    {
       
    
        $job = DB::table('assets')
        // ->where('assets.surveyor',$id)
        ->where('asset_site_details.city',Auth::user()->city)
        ->where('asset_site_details.sub_city',$request->sub_city)
        ->where('assets.status',$request->status)
        ->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id')
        ->leftJoin('city','asset_site_details.city','=','city.id')
        ->leftJoin('region','city.region_id','=','region.id')
        ->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id')
        ->leftJoin('asset_type','assets.asset_type','=','asset_type.id')
        ->leftJoin('asset_details','assets.id','=','asset_details.asset_id')
        ->select(
            'assets.id as job_id',
            'assets.id',
            'assets.status',
            'region.name as region_name',
            'city.name as city_name',
            'city.prefix as city_prefix',
            DB::raw('DATE_FORMAT(assets.created_at,"%Y") as assigned_on'),
            'sub_city.name as sub_city_name',
            'asset_type.name as asset_type',
            'asset_type.id as asset_id',
            'asset_details.make',
            'asset_site_details.shop_name',
            'asset_site_details.shopkeeper_name',
            'asset_details.tag_number',
            'asset_site_details.address',
            'asset_site_details.contact_no',
            'assets.created_at',
             // year work 
             'assets.age_of_asset as age_of_asset'

           
        )
        ->orderBy('created_at','DESC')
        ->get();



        $recs=collect([]);

        foreach($job as $item)
        {
            $recs->push([
                'job_id'=>$item->job_id,
                'id'=>$item->id,
                'status'=>$item->status,
                'statusis'=>$item->status==1?'Completed':'Active',
                'region_name'=>$item->region_name,
                'city_name'=>$item->city_name,
                'city_prefix'=>$item->city_prefix,
                'sub_city_name'=>$item->sub_city_name,
                'asset_type'=>$item->asset_type,
                'asset_id'=>$item->asset_id,
                'make'=>$item->make,
                'shop_name'=>$item->shop_name,
                'shopkeeper_name'=>$item->shopkeeper_name,
                'tag_number'=>$item->tag_number,
                'address'=>$item->address,
                'contact_no'=>$item->contact_no,
                'assigned_on'=> Carbon\Carbon::parse($item->created_at)->diffForHumans(), 
                'assigned_on_year'=> date_format(date_create($item->created_at),'Y') 
            ]);
        }
        $recs->all();
      
        // if(!$job->isEmpty())
        // {
        //     $data=[
        //         "status"=>true,
        //         "error"=>'',
        //         "data"=>$job
        //     ];
           
        // }
        // else{
        //     $data=[
        //         "status"=>false,
        //         "error"=>'',
        //         "data"=>$job
        //     ];
        // }
       

        // return response()->json($data);
        
        return $recs;


    }
    public function updateGeneralInfo(Request $request,$id)
    {
        // date_default_timezone_set("Asia/Karachi");
        $db=DB::table('assets')
        ->where('id',$id)
        ->select('site_id')
        ->get();

        $job= DB::table('asset_site_details')
        ->where('id', $db[0]->site_id)
        ->update([
            'is_site_accessible' => $request->is_site_accessible,
            'is_verified' => $request->is_verified,
            'same_location' => $request->same_location,
            'shop_name' => $request->shop_name,
            'shopkeeper_name' => $request->shopkeeper_name,
            'address' => $request->address,
            'other_address' => $request->another_address,
            'contact_no' => $request->contact_no,
            'city' => $request->city,
            'sub_city' => $request->district
          
        ]);

        return response()->json([
            "success" => true
        ]);
    }
    public function getGeneralInfo($id)
    {
       
    
        $job = DB::table('assets')
        ->where('assets.id',$id)
        // ->whereIn('assets.status',[0,1])
        ->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id')
        ->leftJoin('city','asset_site_details.city','=','city.id')
        ->leftJoin('region','city.region_id','=','region.id')
        ->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id')
        ->leftJoin('asset_type','assets.asset_type','=','asset_type.id')
        ->leftJoin('asset_details','assets.id','=','asset_details.asset_id')
        ->select(
            'asset_site_details.is_site_accessible',
            'asset_site_details.same_location',
            'asset_site_details.is_verified',
            'asset_site_details.other_address as another_address',
            'asset_site_details.shop_name',
            'asset_site_details.shopkeeper_name',
            'asset_site_details.address',
            'region.name as region_name',
            'region.id as region_id',
            'city.name as city_name',
            'city.id as city_id',
            'city.prefix as city_prefix',
            'sub_city.name as district_name',
            'sub_city.id as district_id',
            'asset_site_details.contact_no'
           
        )
        ->get();

      
        if(!$job->isEmpty())
        {
            $data=[
                "status"=>true,
                "error"=>'',
                "data"=>$job
            ];
           
        }
        else{
            $data=[
                "status"=>false,
                "error"=>'',
                "data"=>$job
            ];
        }
       

        return response()->json($data);          


    }
    public function updateVehicleSurveyInfo(Request $request,$id)
    {
        // date_default_timezone_set("Asia/Karachi");
        $job= DB::table('asset_details')
        ->where('asset_id', $id)
        ->update([
            'reason_for_no_operational'=>$request->reason_for_no_operational,
            'make'=>$request->make,
            'tag_number'=>$request->tag_number,
            'tag_number_visible'=>$request->tag_number_visible,
            'existance'=>$request->existance,
            'functional'=>$request->functional,
            'type'=>$request->type==1?$request->freezer_type:$request->vehicle_type,
            'type_other'=>$request->type==1?$request->freezer_type_other:$request->vehicle_type_other,
            'is_cooler_accessible'=>$request->is_cooler_accessible,
            'general_condition'=>$request->general_condition,
            'model_number'=>$request->model_number,
            'volume'=>$request->volume,
            'utilization'=>$request->utilization,
            'utilization_pepsi'=>$request->shared_pepsi,
            'utilization_shared'=>$request->shared_others,
            'shared_products_name'=>$request->shared_products_name,
            'is_vehicle_destributed'=>$request->is_vehicle_destributed,
            'reg_no'=>$request->reg_no,
            'surveyor_name'=>$request->surveyor_names,
            'engine_no'=>$request->engine_no,
            'chassis_no'=>$request->chassis_no
          
        ]);

        return response()->json([
            "success" => true
        ]);
    }
    public function getVehicleSurveyInfo($id)
    {
       
    
        $job = DB::table('assets')
        ->where('assets.id',$id)
        // ->whereIn('assets.status',[0,1])
        ->leftJoin('users as surveyor','assets.surveyor','=','surveyor.id')
        ->leftJoin('users as qc_officer','assets.qc_officer','=','qc_officer.id')
        ->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id')
        ->leftJoin('city','asset_site_details.city','=','city.id')
        ->leftJoin('region','city.region_id','=','region.id')
        // ->leftJoin('city','assets.city','=','city.id')
        ->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id')
        ->leftJoin('asset_type','assets.asset_type','=','asset_type.id')
        ->leftJoin('asset_details','assets.id','=','asset_details.asset_id')
        ->select(
            'assets.id',
            'assets.title',
            DB::raw('DATE_FORMAT(assets.assigned_on,"%d-%b-%Y %h:%i %p") as assigned_on'),
            DB::raw('DATE_FORMAT(assets.conducted_on,"%d-%b-%Y %h:%i %p") as conducted_on'),
            'asset_details.tag_number',
            'asset_site_details.gps',
            'assets.status',
            'asset_site_details.address',
            // DB::Raw('KGT/city'),
            'asset_site_details.is_site_accessible',
            'asset_details.shared_products_name',
            'asset_details.utilization_pepsi',
            'asset_details.utilization_shared',
            'asset_details.general_condition',
            'asset_details.tag_number_visible',
            'asset_details.utilization',
            'asset_details.is_vehicle_destributed',
            'asset_details.volume',
            'asset_details.functional',
            'asset_details.reg_no',
            'asset_details.engine_no',
            'asset_details.chassis_no',
            'asset_details.model_number',
            'asset_details.existance',
            'asset_details.make',
            'asset_site_details.shop_name',
            'asset_site_details.shopkeeper_name',
            'asset_details.reason_for_no_operational',
            'asset_details.is_cooler_accessible',
            'asset_site_details.same_location',
            'asset_details.type',
            'asset_details.type_other',
            'asset_site_details.shop_name as location_title',
            'asset_site_details.contact_no',
            'asset_type.name as asset_type',
            'asset_type.id as asset_id',
            'assets.status',
            'region.name as region_name',
            'region.id as region_id',
            'city.name as city_name',
            'city.id as city_id',
            'city.prefix as city_prefix',
            'sub_city.name as district_name',
            'sub_city.id as district_id',
            'surveyor.name as surveyor_name',
            'surveyor.id as surveyor_id',
            'qc_officer.id as qc_officer_id',
            'qc_officer.name as qc_officer_name'
           
        )
        ->get();

      
        if(!$job->isEmpty())
        {
            $data=[
                "status"=>true,
                "error"=>'',
                "data"=>$job
            ];
           
        }
        else{
            $data=[
                "status"=>false,
                "error"=>'',
                "data"=>$job
            ];
        }
       

        return response()->json($data);          


    }

    public function updateCoolerSurveyInfo(Request $request,$id)
    {
        // date_default_timezone_set("Asia/Karachi");
        $job= DB::table('asset_details')
        ->where('asset_id', $id)
        ->update([
            'tag_number' => $request->tag_number,
            'existance' => $request->existance,
            'functional' => $request->functional,
            'reason_for_no_operational' => $request->reason_for_no_operational,
            'type' => $request->type,
            'type_other' => $request->type_other,
            'model_number' => $request->model_number,
            'volume' => $request->volume,
            'utilization' => $request->utilization,
            'utilization_pepsi' => $request->utilization_pepsi,
            'utilization_shared' => $request->utilization_shared,
            'shared_products_name' => $request->shared_products_name,
            'general_condition' => $request->general_condition,
            'is_cooler_accessible' => $request->is_cooler_accessible
          
        ]);

        return response()->json([
            "success" => true
        ]);
    }
    public function getCoolerSurveyInfo($id)
    {
       
    
        $job = DB::table('assets')
        ->where('assets.id',$id)
        // ->whereIn('assets.status',[0,1])
        ->leftJoin('region','assets.region','=','region.id')
        ->leftJoin('city','assets.city','=','city.id')
        ->leftJoin('sub_city','assets.sub_city','=','sub_city.id')
        ->leftJoin('asset_type','assets.asset_type','=','asset_type.id')
        ->leftJoin('asset_details','assets.id','=','asset_details.asset_id')
        ->select(
            'asset_details.tag_number',
            'asset_details.existance',
            'asset_details.reason_for_no_operational',
            'asset_details.functional',
            'asset_details.type',
            'asset_details.type_other',
            'asset_details.model_number',
            'asset_details.volume',
            'asset_details.utilization',
            'asset_details.utilization_pepsi',
            'asset_details.utilization_shared',
            'asset_details.shared_products_name',
            'asset_details.general_condition',
            'asset_details.is_cooler_accessible'
           
        )
        ->get();

      
        if(!$job->isEmpty())
        {
            $data=[
                "status"=>true,
                "error"=>'',
                "data"=>$job
            ];
           
        }
        else{
            $data=[
                "status"=>false,
                "error"=>'',
                "data"=>$job
            ];
        }
       

        return response()->json($data);          


    }
}
