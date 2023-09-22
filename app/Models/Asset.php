<?php

namespace App\Models;
use Auth;
use DB;
use App\Models\Assets_Details;
use App\Models\AssetsSiteDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Storage;
use File;
use Image;
use Illuminate\Http\Request; 

class Asset extends Model
{
    use HasFactory;
    protected $table ='assets';

    public static function getData($request)
    {

        $db=DB::table('assets');
        $db=$db->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
        
        // $db=$db->leftJoin('asset_details','assets.id','=','asset_details.asset_id');
        $db=$db->leftJoin('city','asset_site_details.city','=','city.id');
        $db=$db->leftJoin('region','city.region_id','=','region.id');
        $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');

        if($request->type==2)
        {

            $db=$db->where('assets.asset_type',$request->type);
    
            if($request->bottler!=0)
            {
            $db=$db->where('assets.bottler',$request->bottler);
    
            }
            if($request->status_is!='')
            {
                $db=$db->where('assets.status',$request->status_is);
    
            }
            if($request->surveyor!=0)
            {
                $db=$db->where('assets.surveyor',$request->surveyor);
    
            }
            if($request->qcofficer!=0)
            {
                $db=$db->where('assets.qc_officer',$request->qcofficer);
    
            }
    
        }
        else{

            $db=$db->where('assets.asset_type',$request->type);
    
            // }
            if($request->bottler!=0)
            {
            $db=$db->where('assets.bottler',$request->bottler);
    
            }
            if($request->region!=0)
            {
                $db=$db->where('region.id',$request->region);
    
            }
            if($request->status_is!='')
            {
                $db=$db->where('assets.status',$request->status_is);
    
            }
            if($request->surveyor!=0)
            {
                $db=$db->where('assets.surveyor',$request->surveyor);
    
            }
            if($request->qcofficer!=0)
            {
                $db=$db->where('assets.qc_officer',$request->qcofficer);
    
            }
            if($request->city!=0)
            {
                $db=$db->where('asset_site_details.city',$request->city);
    
            }
            if($request->district!=0)
            {
                $db=$db->where('asset_site_details.sub_city',$request->district);
    
            }
    
        }
        $db=$db->leftJoin('users as surveyor','assets.surveyor','=','surveyor.id');
        $db=$db->leftJoin('users as qc_officer','assets.qc_officer','=','qc_officer.id');
        // $db=$db->leftJoin('city','asset_site_details.city','=','city.id');
        // $db=$db->leftJoin('region','city.region_id','=','region.id');
        // $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
        $db=$db->leftJoin('asset_type','assets.asset_type','=','asset_type.id');
        $db=$db->leftJoin('asset_details','assets.id','=','asset_details.asset_id');
        $db=$db->select(
            'assets.id',
            'assets.title',
            'assets.status',
            'asset_details.tag_number',
            DB::raw('DATE_FORMAT(assets.created_at,"%Y") as assigned_on'),
            'asset_site_details.address',
            'asset_details.make',
            'asset_details.reg_no',
            'asset_details.engine_no',
            'asset_site_details.shop_name',
            'asset_site_details.shopkeeper_name',
            'asset_site_details.contact_no',
            'asset_type.name as asset_type',
            'assets.status',
            'region.name as region',
            'city.name as city',
            'city.prefix as city_prefix',
            'sub_city.name as district',
            'surveyor.name as surveyor',
            'qc_officer.name as qc_officer',
             // year work 
             'assets.age_of_asset as age_of_asset',
             // end 
        );
        $db=$db->orderBy('assets.id','DESC');
        // $db=$db->skip(0);
        // $db=$db->limit(6000);
        $db=$db->get();

        return $db;

    }
    
    public static function getReportData($id,$request)
    {

        $db=DB::table('assets');
        $db=$db->where('assets.id',$id);
        $db=$db->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
        $db=$db->leftJoin('users as surveyor','assets.surveyor','=','surveyor.id');
        $db=$db->leftJoin('users as qc_officer','assets.qc_officer','=','qc_officer.id');
        $db=$db->leftJoin('city','asset_site_details.city','=','city.id');
        $db=$db->leftJoin('region','city.region_id','=','region.id');
        $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
        $db=$db->leftJoin('asset_type','assets.asset_type','=','asset_type.id');
        $db=$db->leftJoin('asset_details','assets.id','=','asset_details.asset_id');
        $db=$db->select(
            'assets.id',
            'assets.title',
            DB::raw('DATE_FORMAT(assets.created_at,"%Y") as created_at'),
            DB::raw('DATE_FORMAT(assets.assigned_on,"%d-%b-%Y %h:%i %p") as assigned_on'),
            DB::raw('DATE_FORMAT(assets.conducted_on,"%d-%b-%Y %h:%i %p") as conducted_on'),
            'asset_details.tag_number',
            'asset_site_details.gps',
            'assets.status',
            'asset_site_details.address',
            'asset_site_details.other_address',
            // DB::Raw('KGT/city'),
            'asset_site_details.is_site_accessible',
            'asset_details.shared_products_name',
            'asset_details.utilization_pepsi',
            'asset_details.utilization_shared',
            'asset_details.general_condition',
            'asset_details.utilization',
            'asset_details.is_vehicle_destributed',
            'asset_details.volume',
            'asset_details.functional',
            'asset_details.reg_no',
            'asset_details.engine_no',
            'asset_details.model_number',
            'asset_details.existance',
            'asset_details.make',
            'asset_site_details.shop_name',
            'asset_site_details.shopkeeper_name',
            'asset_details.reason_for_no_operational',
            'asset_details.is_cooler_accessible',
            'asset_site_details.same_location',
            'asset_details.type',
            'asset_details.chassis_no',
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
        );
        $db=$db->get();

        $images=DB::table('assets_images');
        $images=$images->where('assets_images.asset_id',$id);
        $images=$images->leftJoin('users','assets_images.created_by','=','users.id');
        $images=$images->select(
            'assets_images.id',
            'assets_images.title',
            'users.name as uploaded_by',
            'assets_images.uploaded_on',
            'assets_images.path'
        );
        // image oder 
        $images=$images->orderBy('order_path','ASC'); 
        // end 
        $images=$images->take(6)->get();

           $items=collect([]);
        foreach($images as $rec)
        {
            $items->push([
                'id'=>$rec->id,
                'title'=>$rec->title,
                'uploaded_by'=>$rec->uploaded_by,
                'uploaded_on'=>date_format(date_create($rec->uploaded_on),'d-m-Y'),
                'path'=>$rec->path
            ]);
        }
        $items->all();

        $data=[
            'id'=>$db[0]->id,
            'asset_id'=>$db[0]->asset_id,
            'report_date'=>date('M d, Y'),
            'ref_id'=>'KGT/'.$db[0]->city_prefix.'/VER/AFF/'.$db[0]->id.'/'.$db[0]->created_at,
            'is_site_accessible'=>$db[0]->is_site_accessible,
            'is_cooler_accessible'=>$db[0]->is_cooler_accessible,
            'same_location'=>$db[0]->same_location,
            'chassis_no'=>$db[0]->chassis_no,
            'shop_name'=>$db[0]->shop_name,
            'shopkeeper_name'=>$db[0]->shopkeeper_name,
            'address'=>$db[0]->address,
            'other_address'=>$db[0]->other_address,
            'gps'=>$db[0]->gps,
            'contact_no'=>$db[0]->contact_no,
            'tag_number'=>$db[0]->tag_number,
            'is_site_accessible'=>$db[0]->is_site_accessible,
            'existance'=>$db[0]->existance,
            'is_vehicle_owned'=>$db[0]->is_vehicle_destributed,
            'model_number'=>$db[0]->model_number,
            'type'=>$db[0]->type=='Other'?$db[0]->type_other:$db[0]->type,
            'functional'=>$db[0]->functional,
            'reason_for_no_operational'=>$db[0]->reason_for_no_operational,
            'general_condition'=>$db[0]->general_condition,
            'utilization'=>$db[0]->utilization,
            'utilization_shared'=>$db[0]->utilization_shared,
            'reg_no'=>$db[0]->reg_no,
            'make'=>$db[0]->make,
            'utilization_pepsi'=>$db[0]->utilization_pepsi,
            'engine_no'=>$db[0]->engine_no,
            'shared_products_name'=>$db[0]->shared_products_name,
            'volume'=>$db[0]->volume,
            'city_name'=>$db[0]->city_name,
            'district_name'=>$db[0]->district_name,
            'images'=>$images

        ];

        return $data;

    }

    public static function getImages($id)
    {

        $db=DB::table('assets_images');
        $db=$db->where('assets_images.asset_id',$id);
        $db=$db->leftJoin('users','assets_images.created_by','=','users.id');
        $db=$db->select(
            'assets_images.id',
            'assets_images.title',
            'users.name as uploaded_by',
            'assets_images.uploaded_on',
            'assets_images.path',
            'assets_images.order_path'
            
        );
        $db=$db->orderBy('id','DESC');
        $db=$db->get();

        $items=collect([]);
        foreach($db as $rec)
        {
            $items->push([
                'id'=>$rec->id,
                'title'=>$rec->title,
                'uploaded_by'=>$rec->uploaded_by,
                'uploaded_on'=>date_format(date_create($rec->uploaded_on),'d-m-Y'),
                'path'=>url('storage').'/'.$rec->path,
                // image order 
                'order_path'=>$rec->order_path
                //  end 
            ]);
        }
        $items->all();
        return $items;

    }
    
    public static function getSurveyStatsForSurveyor($request)
    {
        $surveys=DB::table('assets');
            // $surveys=$surveys->where('assets.surveyor',$request->user()->id);
            $surveys=$surveys->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
            if($request->type==1)
            {
                $surveys=$surveys->where('asset_site_details.city',Auth::user()->city);
                $surveys=$surveys->where('asset_site_details.sub_city',$request->sub_city);
            }
            else{

                $surveys=$surveys->where('assets.bottler',$request->bottler);
            }

            $surveys=$surveys->where('assets.asset_type',$request->type);

            $surveys=$surveys->select(
                DB::raw('count(Case when assets.status=0 then assets.id  end) as active'),
                DB::raw('count(Case when assets.status=1 then assets.id end) as completed')
            
            );
            $surveys=$surveys->groupBy('asset_site_details.city');
            $surveys=$surveys->get();

            return $surveys;
    }
    public static function uploadimages($request)
    {


        $files = $request->file('files');
        $id = $request->jid;

        $imageCount= DB::table('assets_images');

        // if(){
        $path = public_path('storage/assets/'.$id);

        if(!File::isDirectory($path)){
            Storage::disk('public')->makeDirectory('assets/'.$id);


        }
        foreach ($files as $file) {

            $assetCount = DB::table('assets_images')
    ->where('asset_id', $id)
    ->count();

    // image limit retriction  

if($assetCount !=8){
 

    $image_name = uniqid() . '.' . $file->getClientOriginalExtension();
    $image_path = 'storage/assets/'.$id.'/' . $image_name;
    Image::make($file)->resize(320, 240)->save(public_path($image_path));

    $job = DB::table('assets_images')->insert([
        'asset_id' => $id,
        'title' => $image_name,
        'path' =>  'assets/'.$id.'/' . $image_name,
        'created_by' =>  Auth::user()->id,
        'uploaded_on' =>  date('Y-m-d'),

    ]);
}
else{
 alert('you can upload only 6 images');
}

// end 
        }

    // }
    }

    public static function getDataForUpdate($id,$request)
    {

        $db=DB::table('assets');
        $db=$db->where('assets.id',$id);
        $db=$db->leftJoin('users as surveyor','assets.surveyor','=','surveyor.id');
        $db=$db->leftJoin('users as qc_officer','assets.qc_officer','=','qc_officer.id');
        $db=$db->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
        $db=$db->leftJoin('city','asset_site_details.city','=','city.id');
        $db=$db->leftJoin('region','city.region_id','=','region.id');
        $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
        $db=$db->leftJoin('asset_type','assets.asset_type','=','asset_type.id');
        $db=$db->leftJoin('asset_details','assets.id','=','asset_details.asset_id');
        $db=$db->select(
            'assets.id',
            'assets.title',
            DB::raw('DATE_FORMAT(assets.assigned_on,"%d-%b-%Y %h:%i %p") as assigned_on'),
            DB::raw('DATE_FORMAT(assets.created_at,"%Y") as created_at'),
            DB::raw('DATE_FORMAT(assets.conducted_on,"%d-%b-%Y %h:%i %p") as conducted_on'),
            DB::raw('DATE_FORMAT(asset_site_details.assigned_on,"%d-%b-%Y %h:%i %p") as site_assigned_on'),
            DB::raw('DATE_FORMAT(asset_site_details.conducted_on,"%d-%b-%Y %h:%i %p") as site_conducted_on'),
            'asset_details.tag_number',
            'asset_site_details.gps',
            'asset_site_details.status as site_status',
            'assets.status',
            'assets.site_id',
            'asset_site_details.address',
            'asset_site_details.is_verified',
            'asset_site_details.other_address',
            'asset_site_details.is_site_accessible',
            'asset_details.tag_number_by_client',
            'asset_details.model_no_by_client',
            'asset_details.shared_products_name',
            'asset_details.utilization_pepsi',
            'asset_details.utilization_shared',
            'asset_details.general_condition',
            'asset_details.utilization',
            'asset_details.is_vehicle_destributed',
            'asset_details.volume',
            'asset_details.tag_number_visible',
            'asset_details.engine_no_by_client',
            'asset_details.make_by_client',
            'asset_details.chassis_no_by_client',
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
            'asset_details.type_by_client',
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
            'qc_officer.name as qc_officer_name',
        );

        $db=$db->get();

        return $db;

    }
    public static function storeAsset($request)
    {
        if($request->site=='')
        {
            $site=new AssetsSiteDetails;
            $site->address=$request->address;
            $site->contact_no=$request->contact_no;
            $site->is_site_accessible=$request->is_site_accessible;
            $site->same_location=$request->same_location;
            $site->other_address=$request->other_address;
            $site->shop_name=$request->shop_name;
            $site->shopkeeper_name=$request->shopkeeper_name;
            $site->city=$request->city;
            $site->sub_city=$request->district;
            $site->created_at=date('Y-m-d');
            $site->assigned_on=date('Y-m-d h:i:s');
            $site->created_by=Auth::user()->id;
            $site->updated_at=date('Y-m-d');
            $site->save();

            $asset = new Asset;
            $asset->asset_type=$request->type;
            $asset->site_id=$site->id;
            $asset->surveyor=$request->surveyor;
            $asset->assigned_on=date('Y-m-d h:i:s');
            $asset->qc_officer=$request->qc_officer;
            $asset->created_by=Auth::user()->id;
            $asset->status=0;
            $asset->save();
        }
        else{

            // $site=DB::table('asset_site_details')->where('id',$request->site)->update([
            //     'address'=>$request->address,
            //     'contact_no'=>$request->contact_no,
            //     'is_site_accessible'=>$request->is_site_accessible,
            //     'same_location'=>$request->same_location,
            //     'other_address'=>$request->other_address,
            //     'shop_name'=>$request->shop_name,
            //     'shopkeeper_name'=>$request->shopkeeper_name
            // ]);

            $asset = new Asset;
            $asset->asset_type=$request->type;
            $asset->site_id=$request->site;
            $asset->surveyor=$request->surveyor;
            $asset->assigned_on=$request->surveyor==''?'':date('Y-m-d h:i:s');
            $asset->qc_officer=$request->qc_officer;
            $asset->created_by=Auth::user()->id;
            // $asset->region=$request->region;
            // $asset->city=$request->city;
            // $asset->sub_city=$request->district;
            $asset->status=0;
            $asset->save();
        }

        
        // echo $asset->id;

        $assetup = Asset::find($asset->id);
        $assetup->title=$request->type_slug.'-'.$asset->id;
        $assetup->save();

        $asset->storeAssetDetails($asset->id,$request);
        Storage::disk('public')->makeDirectory('assets/'.$asset->id);
        
        return $asset->id;

    }
    public static function updateAsset($id,$request)
    {
        $asset = Asset::find($id);
        $asset->asset_type=$request->type;
        $asset->surveyor=$request->surveyor;
        // $asset->assigned_on=$request->surveyor==''?'':date('Y-m-d h:i:s');
        $asset->qc_officer=$request->qc_officer;
        $asset->updated_by=Auth::user()->id;
        // $asset->region=$request->region;
        // $asset->city=$request->city;
        // $asset->sub_city=$request->district;
        // $asset->status=0;
        $asset->save();
        

        $asset->updateAssetDetails($id,$request);

        // return $asset->id;

    }
    public static function updateAssetDetails($id,$request)
    {   


        AssetsSiteDetails::where('id',$request->site_id)->update(
            [

                'address'=>$request->address,
                'is_verified'=>$request->is_verified,
                'other_address'=>$request->other_address,
                'contact_no'=>$request->contact_no,
                'is_site_accessible'=>$request->is_site_accessible,
                'same_location'=>$request->same_location,
                'shop_name'=>$request->shop_name,
                'shopkeeper_name'=>$request->shopkeeper_name,
                'city'=>$request->city,
                'sub_city'=>$request->district

            ]);
        Assets_Details::where('asset_id',$id)->update(
            [
                'surveyor_name'=>$request->surveyor_name,
                'address'=>$request->address,
                'other_address'=>$request->other_address,
                'contact_no'=>$request->contact_no,
                'is_site_accessible'=>$request->is_site_accessible,
                'same_location'=>$request->same_location,
                'shop_name'=>$request->shop_name,
                'tag_number_visible'=>$request->tag_number_visible,
                'shopkeeper_name'=>$request->shopkeeper_name,
                'reason_for_no_operational'=>$request->reason_for_no_operational,
                'make'=>$request->make,
                'tag_number'=>$request->tag_number,
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
                'engine_no'=>$request->engine_no,
                'chassis_no'=>$request->chassis_no
            ]

            
    );
    }
    public static function storeAssetDetails($id,$request)
    {
        Assets_Details::firstOrCreate(
            ['asset_id' => $id],
            [
                'address'=>$request->address,
                'contact_no'=>$request->contact_no,
                'is_site_accessible'=>$request->is_site_accessible,
                'same_location'=>$request->same_location,
                'shop_name'=>$request->shop_name,
                'shopkeeper_name'=>$request->shopkeeper_name,
                'reason_for_no_operational'=>$request->reason_for_no_operational,
                'make'=>$request->make,
                'chassis_no'=>$request->chassis_no,
                'chassis_no_by_client'=>$request->chassis_no,
                'make_by_client'=>$request->make,
                'tag_number'=>$request->tag_number,
                'tag_number_by_client'=>$request->tag_number,
                'existance'=>$request->existance,
                'functional'=>$request->functional,
                'type'=>$request->type==1?$request->freezer_type:$request->vehicle_type,
                'type_by_client'=>$request->type==1?$request->freezer_type:$request->vehicle_type,
                'type_other'=>$request->type==1?$request->freezer_type_other:$request->vehicle_type_other,
                'is_cooler_accessible'=>$request->is_cooler_accessible,
                'general_condition'=>$request->general_condition,
                'model_number'=>$request->model_number,
                'model_no_by_client'=>$request->model_number,
                'volume'=>$request->volume,
                'utilization'=>$request->utilization,
                'utilization_pepsi'=>$request->shared_pepsi,
                'utilization_shared'=>$request->shared_others,
                'shared_products_name'=>$request->shared_products_name,
                'is_vehicle_destributed'=>$request->is_vehicle_destributed,
                'reg_no'=>$request->reg_no,
                'engine_no'=>$request->engine_no,
                'engine_no_by_client'=>$request->engine_no,
            ]

            
    );
    }

    public static function coolerBulk($request,$myarray)
    {


        $count = count($myarray[0]);

        foreach($myarray as $item)
        {
            for ($i=1; $i < $count ; $i++) { 

               $ageofasset=$item[$i][0];
               $region=$item[$i][1];
               $distr=$item[$i][2];
               $distributor=$item[$i][3];
               $route=$item[$i][4];
               $sitecode='';
               $site=$item[$i][5];
               $siteadd=$item[$i][6];
               $type=$item[$i][9];
               $shopkeeper=$item[$i][7];
               $shopname=$item[$i][5];
               $contact_no=$item[$i][9];
               $assetcode=$item[$i][10];
               $barcode='';
               $dateofinjection='';
               $mde='';
               $gps='';


            //    $site='Auto Care Experts';
               $rec=DB::table('asset_site_details')
               ->where('title',$site)
               ->where('address',$siteadd)
               ->where('city',$region)
               ->where('sub_city',$distr)
               ->select('*')->get();
                $siteid='';
               if(count($rec) > 0)
               {    
                    $siteid=$rec[0]->id;
 


                }else{
                    
                    // echo 'empty so new site'.'<br>';

                    $siteis=new AssetsSiteDetails;
                    $siteis->title=$site;
                    $siteis->address=$siteadd;
                    $siteis->shop_name=$shopname;
                    $siteis->shopkeeper_name=$shopkeeper;
                    $siteis->city=$region;
                    $siteis->site_code=$sitecode;
                    $siteis->sub_city=$distr;
                    $siteis->created_at=date('Y-m-d');
                    $siteis->assigned_on=date('Y-m-d h:i:s');
                    $siteis->created_by=Auth::user()->id;
                    // $site->updated_at=date('Y-m-d');
                    $siteis->save();

                    $siteid=$siteis->id;
               }

               $asset = new Asset;
               $asset->asset_type=$request->type;
               $asset->bottler=$request->bottler;
               $asset->site_id=$siteid;
               $asset->age_of_asset=$ageofasset;
               $asset->distributer=$distributor;
               $asset->route=$route;
               $asset->asset_code=$assetcode;
               $asset->barcode=$barcode;
               $asset->date_of_injection=$dateofinjection;
               $asset->mde=$mde;
               $asset->assigned_on=$request->surveyor==''?'':date('Y-m-d h:i:s');
               $asset->created_by=Auth::user()->id;
               $asset->status=0;
               $asset->save();
                

               $assetup = Asset::find($asset->id);
               $assetup->title='ColFrez-'.$asset->id;
               $assetup->save();
       
                Assets_Details::firstOrCreate(
                ['asset_id' => $asset->id],
                [
                    // 'address'=>$request->address,
                     // 'contact_no'=>$request->contact_no,
                     // 'is_site_accessible'=>$request->is_site_accessible,
                     // 'same_location'=>$request->same_location,
                     // 'shop_name'=>$request->shop_name,
                     // 'shopkeeper_name'=>$request->shopkeeper_name,
                     // 'reason_for_no_operational'=>$request->reason_for_no_operational,
                     // 'make'=>$request->make,
                     // 'chassis_no'=>$request->chassis_no,
                     // 'chassis_no_by_client'=>$request->chassis_no,
                     // 'make_by_client'=>$request->make,
                     'tag_number'=>$assetcode,
                     'tag_number_by_client'=>$assetcode,
                     // 'existance'=>$request->existance,
                     // 'functional'=>$request->functional,
                     'type'=>$type,
                     'type_by_client'=>$type,
                     // 'type_other'=>$request->type==1?$request->freezer_type_other:$request->vehicle_type_other,
                     // 'is_cooler_accessible'=>$request->is_cooler_accessible,
                     // 'general_condition'=>$request->general_condition,
                     // 'model_number'=>$request->model_number,
                     // 'model_no_by_client'=>$request->model_number,
                     // 'volume'=>$request->volume,
                     // 'utilization'=>$request->utilization,
                     // 'utilization_pepsi'=>$request->shared_pepsi,
                     // 'utilization_shared'=>$request->shared_others,
                     // 'shared_products_name'=>$request->shared_products_name,
                     // 'is_vehicle_destributed'=>$request->is_vehicle_destributed,
                     // 'reg_no'=>$request->reg_no,
                     // 'engine_no'=>$request->engine_no,
                     // 'engine_no_by_client'=>$request->engine_no,
                     ]    
                
                );
            //    Storage::disk('public')->makeDirectory('assets/'.$asset->id);
       
            }
        }   
    }

    public static function vehicleBulk($request,$myarray)
    {
        $count = count($myarray[0]);

        foreach($myarray as $item)
        {
            for ($i=1; $i < $count ; $i++) { 

               $region=$item[$i][8];
            //    $distr=$item[$i][1];
            //    $distributor=$item[$i][2];
            //    $route=$item[$i][3];
               $site=$item[$i][7];
               $make=$item[$i][1];
               $model=$item[$i][2];
               $engine=$item[$i][4];
               $chassis=$item[$i][5];
               $regno=$item[$i][6];
               $remarks=$item[$i][9];
               $assetcode=$item[$i][12];
               $subnumber=$item[$i][13];
               $capatilized=$item[$i][11];
               $type=$item[$i][3];
               $ownership=$item[$i][11];

               $rec=DB::table('asset_site_details')
               ->where('title',$site)
               ->where('city',$region)
               ->select('*')->get();
                $siteid='';
               if(count($rec) > 0)
               {    
                    $siteid=$rec[0]->id;
 


                }else{
                    
                    // echo 'empty so new site'.'<br>';

                    $siteis=new AssetsSiteDetails;
                    $siteis->title=$site;
                    $siteis->address=$site;

                    $siteis->city=$region;
                    $siteis->created_at=date('Y-m-d');
                    $siteis->assigned_on=date('Y-m-d h:i:s');
                    $siteis->created_by=Auth::user()->id;
                    // $site->updated_at=date('Y-m-d');
                    $siteis->save();

                    $siteid=$siteis->id;
               }

               $asset = new Asset;
               $asset->asset_type=$request->type;
               $asset->bottler=$request->bottler;
               $asset->site_id=$siteid;
               $asset->sub_num=$subnumber;
               $asset->asset_code=$assetcode;
               $asset->remarks=$remarks;
               $asset->capatalized_on=$capatilized;
               $asset->assigned_on=$request->surveyor==''?'':date('Y-m-d h:i:s');
               $asset->created_by=Auth::user()->id;
               $asset->status=0;
               $asset->save();
                

               $assetup = Asset::find($asset->id);
               $assetup->title='Vehicle-'.$asset->id;
               $assetup->save();
       
                Assets_Details::firstOrCreate(
                ['asset_id' => $asset->id],
                [
                    // 'address'=>$request->address,
                    // 'contact_no'=>$request->contact_no,
                    // 'is_site_accessible'=>$request->is_site_accessible,
                    // 'same_location'=>$request->same_location,
                    // 'shop_name'=>$request->shop_name,
                    // 'shopkeeper_name'=>$request->shopkeeper_name,
                    // 'reason_for_no_operational'=>$request->reason_for_no_operational,
                    'make'=>$make,
                    'model_number'=>$model,
                    // 'model_number'=>$model,
                    // 'chassis_no'=>$request->chassis_no,
                    // 'chassis_no_by_client'=>$request->chassis_no,
                    // 'make_by_client'=>$request->make,
                    // 'tag_number'=>$request->tag_number,
                    // 'tag_number_by_client'=>$request->tag_number,
                    // 'existance'=>$request->existance,
                    // 'functional'=>$request->functional,
                    'type'=>$type,
                    'type_by_client'=>$type,
                    // 'type_other'=>$request->type==1?$request->freezer_type_other:$request->vehicle_type_other,
                    // 'is_cooler_accessible'=>$request->is_cooler_accessible,
                    // 'general_condition'=>$request->general_condition,
                    // 'model_number'=>$request->model_number,
                    // 'model_no_by_client'=>$request->model_number,
                    // 'volume'=>$request->volume,
                    // 'utilization'=>$request->utilization,
                    // 'utilization_pepsi'=>$request->shared_pepsi,
                    // 'utilization_shared'=>$request->shared_others,
                    // 'shared_products_name'=>$request->shared_products_name,
                    // 'is_vehicle_destributed'=>$request->is_vehicle_destributed,
                    // 'reg_no'=>$request->reg_no,
                    // 'engine_no'=>$request->engine_no,
                    // 'engine_no_by_client'=>$request->engine_no,
                ]
    
                
                );
               Storage::disk('public')->makeDirectory('assets/'.$asset->id);
       
            }
            // echo $item;
        }   
    }
}
