<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use DB;
use Auth;
use App\Models\Assets_Details;
use App\Models\AssetsSiteDetails;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Storage;
use Image;
use App\Models\Asset;


class ItemCSVUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $header;
    /**
     * Create a new job instance.
     */
    public function __construct($data,$header)
    {
        $this->data = $data;
        $this->header = $header;
    }

    /**cls
     * Execute the job.
     */
    public function handle(): void
    {
        // foreach($this->data as $sale)
        // {
        //         // $recdata=array_combine($this->header,$sale);
        
        //         DB::table('assignments')->insert([
        //             'address'=>$sale[3]
        //         ]);
        // }

        foreach($this->data as $key=>$sale)
        {
                // $recdata=array_combine($this->header,$sale);
            

            DB::table('logs')->insert([
                'description'=>$key+1 .' Uploaded'
            ]);

                //Nobahar and Shamim
                $ageofasset=$sale[15];
                $region=$sale[1];
                $distr=$sale[2];
                $distributor='';
                $route='';
                $sitecode='';
                $site=$sale[6];
                $siteadd=$sale[7];
                $type=$sale[8];
                $shopkeeper='';
                $shopname=$sale[6];
                $contact_no='';
                $assetcode=$sale[11];
                $barcode='';
                $dateofinjection='';
                $mde='';
                $gps='';

                //Punjab
            
                // $ageofasset=$sale[0];
                // $region=$sale[1];
                // $distr=$sale[2];
                // $distributor=$sale[3];
                // $route=$sale[4];
                // $sitecode=$sale[12];
                // $site=$sale[5];
                // $siteadd=$sale[6];
                // $type=$sale[9];
                // $shopkeeper=$sale[7];
                // $shopname=$sale[5];
                // $contact_no=$sale[8];
                // $assetcode=$sale[10];
                // $barcode=$sale[11];
                // $dateofinjection=$sale[13];
                // $mde=$sale[14];
                // $gps=$sale[15];
 
 
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
                     $siteis->created_by=1;
                     // $site->updated_at=date('Y-m-d');
                     $siteis->save();
 
                     $siteid=$siteis->id;
                }
 
                $asset = new Asset;
                $asset->asset_type=1;
                $asset->bottler=5;
                // $asset->bottler=5;
                // $asset->bottler=1;
                $asset->site_id=$siteid;
                $asset->distributer=$distributor;
                $asset->route=$route;
                $asset->age_of_asset=$ageofasset;
                $asset->asset_code=$assetcode;
                $asset->barcode=$barcode;
                $asset->date_of_injection=$dateofinjection;
                $asset->mde=$mde;
                $asset->assigned_on=date('Y-m-d h:i:s');
                $asset->created_by=1;
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
                // Storage::disk('public')->makeDirectory('assets/'.$asset->id);

        }



    }
}
