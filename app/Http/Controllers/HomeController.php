<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Support\Facades\Hash;
use App\Jobs\ItemCSVUploadJob;
use App\Jobs\ItemCSVUploadJobVehicle;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use App\Models\Assets_Details;
use App\Models\AssetsSiteDetails;
use Auth;
use Storage;
use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getRoles(Request $request)
    {
        return DB::table('user_role')->select('*')->get();
    }
    public function jobs()
    {
        return view('jobs');
    }

    public function updatetag()
    {
        $recs=DB::table('assets')
        ->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id')
        ->select('assets.id','assets.asset_code')
        ->where('asset_site_details.city',7)
        ->where('asset_site_details.sub_city',10)
        ->get();


        foreach($recs as $item)
        {
            DB::table('asset_details')->where('asset_id',$item->id)->update([
                'tag_number'=>$item->asset_code,
                'tag_number_by_client'=>$item->asset_code
            ]);

            echo 'completed'.$item->id.'<br>';
        }

        // return $rec;
    }
    public function upload(Request $request)
    {
        
       

        $data = file($request->file('csv'));
        $header=$data[0];
        unset($data[0]);

        $chunks=array_chunk($data,1000);

        $path=resource_path('temp');
        foreach($chunks as $key=>$chunk)
        {
            $name= "/tmp{$key}.csv";
            file_put_contents($path.$name,$chunk);
        }

        $files=glob("$path/*.csv");
        $header=[];
        foreach($files as $key => $file)
        {
            $data=array_map('str_getcsv',file($file));

            // if($key===0)
            // {
            //     $header=$data[0];
            //     unset($data[0]);
            // }

        if($request->type==1)
        {
            ItemCSVUploadJob::dispatch($data,$header);

        }
        else{

            ItemCSVUploadJobVehicle::dispatch($data,$header);
        }

            unlink($file);
        }

        return 'Done';
    }
    public function storejobs(Request $request)
    {

        // $path=resource_path('temp');
        // $files=glob("$path/*.csv");
        // $header=[];
        // foreach($files as $key => $file)
        // {
        //     $data=array_map('str_getcsv',file($file));

        //     if($key===0)
        //     {
        //         $header=$data[0];
        //         unset($data[0]);
        //     }

        // ItemCSVUploadJob::dispatch($data,$header);

        //     unlink($file);
        // }
        // return 'store';
    }
    public function users(Request $request)
    {
        
        // return $surveys;

        if($request->user()->role==1){
            $data=[
                'token'=>$request->session()->get('token'),
                'role'=>$request->user()->role,
                'id'=>$request->user()->id
            ];
    
                
                return view('user.index',compact('data'));
        }
        else{
            abort(403);
        }

    }
    protected function addUser(Request $request)
    {
        $user=User::create([
            'name' => $request->profile_name,
            'email' => $request->username,
            'role' => $request->role,
            'city' => $request->city,
            'sub_city' => $request->sub_city,
            'password' => Hash::make($request->password)
        ]);
         $user->createToken('KgtERP')-> accessToken; 
        //  $user->
        return $user;
    }
    public function userCreate(Request $request)
    {
        
        // return $surveys;
        $data=[
            'token'=>$request->session()->get('token'),
            'role'=>$request->user()->role,
            'id'=>$request->user()->id
        ];

            
            return view('user.create',compact('data'));
    }
    public function statistics(Request $request)
    {

        if($request->user()->role==1 || $request->user()->role==5 || $request->user()->role==2)
        {
            $db=DB::table('users');
            $db=$db->where('users.id',$request->user()->id);
            $db=$db->leftJoin('city','users.city','=','city.id');
            $db=$db->leftJoin('region','city.region_id','=','region.id');
            $db=$db->select('region.id as region_id','city.id as city_id');
            $db=$db->get();
    
            $data=[
                'token'=>$request->session()->get('token'),
                'role'=>$request->user()->role,
                'id'=>$request->user()->id,
                'city'=>$db[0]->city_id,
                'region'=>$db[0]->region_id
    
            ];        
            return view('statistics',compact('data'));
        }
        else{
            abort(403);
        }


    }
    public function index(Request $request)
    {
        
        
        if($request->user()->role==1 || $request->user()->role==2 || $request->user()->role==3)
        {

            $db=DB::table('users');
            $db=$db->where('users.id',$request->user()->id);
            $db=$db->leftJoin('city','users.city','=','city.id');
            $db=$db->leftJoin('sub_city','users.sub_city','=','sub_city.id');
            $db=$db->leftJoin('region','city.region_id','=','region.id');
            $db=$db->select('region.id as region_id','users.sub_city','sub_city.name as sub_city_name','city.id as city_id','city.name as city_name');
            $db=$db->get();
    
        $data=[
            'token'=>$request->session()->get('token'),
            'role'=>$request->user()->role,
            'id'=>$request->user()->id,
            'city'=>$db[0]->city_id,
            'city_name'=>$db[0]->city_name,
            'sub_city'=>$db[0]->sub_city,
            'sub_city_name'=>$db[0]->sub_city_name,
            'region'=>$db[0]->region_id,

        ];

        // return $data;

            
            return view('home',compact('data'));
        }
        else if($request->user()->role==5)
        {

            $db=DB::table('users');
            $db=$db->where('users.id',$request->user()->id);
            $db=$db->leftJoin('city','users.city','=','city.id');
            $db=$db->leftJoin('sub_city','users.sub_city','=','sub_city.id');
            $db=$db->leftJoin('region','city.region_id','=','region.id');
            $db=$db->select('region.id as region_id','users.sub_city','sub_city.name as sub_city_name','city.id as city_id','city.name as city_name');
            $db=$db->get();
    
        $data=[
            'token'=>$request->session()->get('token'),
            'role'=>$request->user()->role,
            'id'=>$request->user()->id,
            'city'=>$db[0]->city_id,
            'city_name'=>$db[0]->city_name,
            'sub_city'=>$db[0]->sub_city,
            'sub_city_name'=>$db[0]->sub_city_name,
            'region'=>$db[0]->region_id,

        ];

        // return $data;

            
            return view('statistics',compact('data'));
       
        }
        else{
            $db=DB::table('users');
            $db=$db->where('users.id',$request->user()->id);
            $db=$db->leftJoin('city','users.city','=','city.id');
            $db=$db->leftJoin('sub_city','users.sub_city','=','sub_city.id');
            $db=$db->leftJoin('region','city.region_id','=','region.id');
            $db=$db->select('region.name as region_name','city.name as city_name','users.city as city_id','users.sub_city','sub_city.name as sub_city_name');
            $db=$db->get();
    
           
            $data=[
                'token'=>$request->session()->get('token'),
                'role'=>$request->user()->role,
                'id'=>$request->user()->id,
                'city'=>$db[0]->city_id,
                'city_name'=>$db[0]->city_name,
                'sub_city'=>$db[0]->sub_city,
                'sub_city_name'=>$db[0]->sub_city_name,
                'user_name'=>$request->user()->name,
                'region'=>$db[0]->region_name.', '.$db[0]->city_name
            ];
    
            return view('homesur',compact('data'));


        }

    }

    
    public function edit($id,Request $request)
    {
        if($request->user()->role==1 || $request->user()->role==2 || $request->user()->role==3)
        {
            $data=[
                // 'token'=>$request->session()->get('token')
                'token'=>$request->session()->get('token'),
                'id'=>$id
            ];
            return view('assets.edit',compact('data'));
        }
        else{
            abort(403);
        }

    }
    public function edituser($id,Request $request)
    {
        $data=[
            // 'token'=>$request->session()->get('token')
            'token'=>$request->session()->get('token'),
            'id'=>$id
        ];
        return view('user.edit',compact('data'));
    }
}
