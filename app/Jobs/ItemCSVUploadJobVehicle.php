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
use Storage;
use Image;
use App\Models\Asset;
use Illuminate\Support\Str;


class ItemCSVUploadJobVehicle implements ShouldQueue
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

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        foreach($this->data as $rec)
        {

            $region=$rec[8];
           $site=$rec[7];
           $make=$rec[1];
           $model=$rec[2];
           $engine=$rec[4];
           $chassis=$rec[5];
           $regno=$rec[6];
           $remarks=$rec[9];
           $assetcode=$rec[12];
           $subnumber=$rec[13];
           $capatilized=$rec[11];
           $type=$rec[3];
           $ownership=ucwords($rec[11]);

           $rec=DB::table('asset_site_details')
           ->where('title',$site)
           ->where('city',$region)
           ->select('*')->get();
            $siteid='';
        //    if(count($rec) > 0)
        //    {    
        //         $siteid=$rec[0]->id;



        //     }else{
                
                // echo 'empty so new site'.'<br>';

                $siteis=new AssetsSiteDetails;
                $siteis->title=$site;
                $siteis->address=$site;

                $siteis->city='';
                $siteis->created_at=date('Y-m-d');
                $siteis->assigned_on=date('Y-m-d h:i:s');
                $siteis->created_by=1;
                // $site->updated_at=date('Y-m-d');
                $siteis->save();

                $siteid=$siteis->id;
        //    }

           $asset = new Asset;
           $asset->asset_type=2;
           $asset->bottler=2;
           $asset->site_id=$siteid;
           $asset->sub_num=$subnumber;
           $asset->asset_code=$assetcode;
           $asset->remarks=$remarks;
           $asset->capatalized_on=$capatilized;
           $asset->assigned_on=date('Y-m-d h:i:s');
           $asset->created_by=1;
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
                'make_by_client'=>$make,
                'model_number'=>$model,
                // 'model_number'=>$model,
                'chassis_no'=>$chassis,
                'chassis_no_by_client'=>$chassis,
                // 'make_by_client'=>$request->make,
                'tag_number'=>$assetcode,
                'tag_number_by_client'=>$assetcode,
                // 'existance'=>$request->existance,
                // 'functional'=>$request->functional,
                'type'=>$type,
                'type_by_client'=>$type,
                'is_vehicle_destributed'=>$ownership,
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
                'reg_no'=>$regno,
                'engine_no'=>$engine,
                'engine_no_by_client'=>$engine,
            ]

            
            );
           Storage::disk('public')->makeDirectory('assets/'.$asset->id);
        }


        }
}
