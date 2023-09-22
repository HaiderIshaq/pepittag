<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Asset;
use PDF;
use Image;
use Illuminate\Support\Facades\File;
use Storage;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AssetsController extends Controller
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

    public function deleteImage($id)
    {   
        $db=DB::table('assets_images')->where('id',$id)->select('*')->get();
        
        if(Storage::disk('public')->exists($db[0]->path)){
            Storage::disk('public')->delete($db[0]->path);
            DB::table('assets_images')->where('id',$id)->delete();
        }else{
            dd('File not found.');
          }

        return $id;
    }
    public function compressImage($id)
    {
        $db=DB::table('assets_images')->where('id',$id)->select('*')->get();
        // $path=url('storage').'/'.$db[0]->path;

        
    }




// public function downloadImages($id){

//     $db=DB::table('assets_images');
//     $db=$db->where('assets_images.asset_id',$id);
//     $db=$db->leftJoin('users','assets_images.created_by','=','users.id');
//     $db=$db->select(
//         'assets_images.id',
//         'assets_images.path'
//     );
//     $db=$db->orderBy('id','DESC');
//     $db=$db->get();

//     $imagePath=collect([]);
//     foreach($db as $rec)
//     {
//         $imagePath->push([
//             'path'=>'/storage/'.$rec->path
//         ]);
//     }
//     $imagePath->all();


//     $imagePaths = $db->pluck('path')->toArray();    
//     $zipFileName = 'images.zip';
//     $zipFilePath = storage_path($zipFileName); // Save the zip file in the storage directory
//     $zip = new \ZipArchive();
//     if ($zip->open($zipFilePath, \ZipArchive::CREATE) === true) {
//         foreach ($imagePaths as $imagePath) {
//             $imageContent = Storage::get($imagePath); // Read the image content from storage
//             $fileName = basename($imagePath);
//             $zip->addFromString($fileName, $imageContent); // Add the image content to the zip
//         }
//         $zip->close();
//     }

//     // Set the response headers for downloading the zip file
//     $headers = [
//         'Content-Type' => 'application/zip',
//     ];

//     return response()->download($zipFilePath, $zipFileName, $headers);
// }


// download Images function start 

public function downloadImages($id)
{
  // Define the folder you want to ZIP and its name.
  $folderPath = public_path("storage/assets/{$id}");
  $zipFileName = "images.zip";

  // Create a new ZIP archive.
  $zip = new \ZipArchive;
  if ($zip->open($zipFileName, \ZipArchive::CREATE) === TRUE) {
      // Add all files and subdirectories from the folder to the ZIP archive.
      $this->addFolderToZip($folderPath, $zip);
      $zip->close();

      // Set the headers to force download the ZIP file.
      return response()->download($zipFileName)->deleteFileAfterSend(true);
  } else {
      return "Could not create ZIP archive.";
  }
}

private function addFolderToZip($folderPath, $zip)
{
  $files = File::files($folderPath);
  foreach ($files as $file) {
      $relativePath = str_replace($folderPath, '', $file);
      $zip->addFile($file, $relativePath);
  }

  $subfolders = File::directories($folderPath);
  foreach ($subfolders as $subfolder) {
      $this->addFolderToZip($subfolder, $zip);
  }
}


// end 

// surveyor name function 

public function getSurveyorName($id){


    $data = DB::table('asset_details')->where('id', $id)->value('surveyor_name');
    return $data;

}

// end 

    public function printReport($id,Request $request)
    {
        // $jobs=[144,145];
        $data=Asset::getReportData($id,$request);
        
        if($data['asset_id']==1){
            $pdfPages = [
                'assets/reports/freezer',
            ];
        }
        else{
            $pdfPages = [
                'assets/reports/vehicle',
            ];
        }

       

        $pdf = null;


        $letter=true;

        foreach ($pdfPages as  $key=> $view) {


            // If not yet defined, set the first page
            
            if (is_null($pdf)) {
                $pdf = PDF::loadView($view, compact('data'));

                if($letter==true)
                {
                    // if($stamp==true)
                    // {
                    //     $pdf->getMpdf()->Image('images/prismstamp.png', 130, 200, 80, 80, 'png', '', true, false);

                    // }
                    // $pdf->getMpdf()->Image('images/prismstamp.png',50,150, 170, 100, 'png', '', false);

                    $pagecount = $pdf->getMpdf()->SetSourceFile('src/letterhead.pdf');
                    $tplIdx = $pdf->getMpdf()->ImportPage(1);
                    $pdf->getMpdf()->UseTemplate($tplIdx);

                }
                



                
                continue;
            
            }
        
            // Add another page and add HTML from view to this

            // if($stamp==true)
            // {
             
            // }
            $pdf->getMpdf()->AddPage();
            

            if($letter==true)
            {

                // if($stamp==true)
                // {
                //     $pdf->getMpdf()->Image('images/prismstamp.png', 130, 200, 80, 80, 'png', '', true, false);

                // }

                $pagecount = $pdf->getMpdf()->SetSourceFile('src/letterhead.pdf');
                $tplIdx = $pdf->getMpdf()->ImportPage(1);
                $pdf->getMpdf()->UseTemplate($tplIdx);
                
              
            }

            $pdf->getMpdf()->WriteHTML((string)view($view, $data));
     
        

    }   

        return $pdf->stream('document.pdf');
    }
    public function getData(Request $request)
    {

       return Asset::getData($request);

    //    echo $request->bottler;
    }
    public function updateUser($id,Request $request)
    {
        DB::table('users')->where('id',$id)->update([
            'name'=>$request->profilename,
            'email'=>$request->username
            // 'password'=>Hash::make($request->password)
        ]);
    }
    public function updatePassword($id,Request $request)
    {
        DB::table('users')->where('id',$id)->update([
            'password'=>Hash::make($request->password)
        ]);
    }
    public function getDataforuser($id,Request $request)
    {

       $db=DB::table('users')
       ->leftJoin('user_role','users.role','=','user_role.id')
       ->leftJoin('city','users.city','=','city.id')
       ->leftJoin('region','city.region_id','=','region.id')
       ->leftJoin('sub_city','users.sub_city','=','sub_city.id')
       ->where('users.id',$id)
       ->select(
        'users.name',
        'users.role',
        'users.email',
        'users.password',
        'user_role.name as role_name',
        'city.region_id as region',
        'region.name as region_name',
        'users.city',
        'city.name as city_name',
        'users.sub_city',
        'sub_city.name as sub_city_name'
        )
       ->get();

       return $db;

       

    //    echo $request->bottler;
    }
    public function getSurveyStatsForSurveyor(Request $request)
    {
        $surveys=Asset::getSurveyStatsForSurveyor($request);
        return $surveys;

    }
    public function getSurveyStats(Request $request)
    {
        $type=$request->type;
       $db=DB::table('assets');
    //    $db=$db->leftJoin('asset_site_details','assets.id','=','asset_details.asset_id');
       $db=$db->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
       $db=$db->leftJoin('asset_details','assets.id','=','asset_details.asset_id');
       $db=$db->leftJoin('city','asset_site_details.city','=','city.id');
       $db=$db->leftJoin('region','city.region_id','=','region.id');
       $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
       $db=$db->where('assets.status','!=',3);

       if($request->type==2)
       {

         $db=$db->where('assets.asset_type','=',$type);
 
        if($request->bottler!=0)
        {
         $db=$db->where('assets.bottler','=',$request->bottler);
 
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
        // if($type!=0)
        // {
         $db=$db->where('assets.asset_type','=',$type);
 
        // }
        if($request->bottler!=0)
        {
         $db=$db->where('assets.bottler','=',$request->bottler);
 
        }
        if($request->region!=0)
        {
            $db=$db->where('region.id',$request->region);
 
        }
        if($request->city!=0)
        {
            $db=$db->where('asset_site_details.city',$request->city);
 
        }
        if($request->district!=0)
        {
            $db=$db->where('asset_site_details.sub_city',$request->district);
 
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
        $db=$db->select(
        DB::raw('COUNT(assets.id) as total_assets'),
        DB::raw('COUNT(CASE when assets.status=0 then assets.id end) as total_active'),
        DB::raw('COUNT(CASE when assets.status=1 then assets.id end) as total_conducted'),
        DB::raw('COUNT(CASE when assets.status=2 then assets.id end) as total_completed')
        );
    //    $db=$db->groupBy();
       $db=$db->get();

       return $db;

    }
    public function getRegionsForListing(Request $request)
    {
        
        $db=DB::table('asset_site_details');
        // ->leftJoin('city','asset_site_details.city','=','city.id')
        $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
        $db=$db->where('asset_site_details.city',$request->city);
        // if($request->status!=4)
        // {
        // $db=$db->where('asset_site_details.status',$request->status);
 
        // }
        $db=$db->select('sub_city.name','asset_site_details.sub_city as id');
        $db=$db->groupBy('asset_site_details.sub_city');
        $db=$db->get();

        return $db;
    }
    public function getRegionsForListingForApp(Request $request)
    {
        
        $db=DB::table('asset_site_details');
        // ->leftJoin('city','asset_site_details.city','=','city.id')
        $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
        $db=$db->where('asset_site_details.city',$request->city);
        $db=$db->whereIn('asset_site_details.status',[0,1]);
        $db=$db->select('sub_city.name','asset_site_details.sub_city as id');
        $db=$db->groupBy('asset_site_details.sub_city');
        $db=$db->get();

        return $db;
    }
    public function getListingForSites(Request $request)
    {
        $type=$request->type;
       $db=DB::table('asset_site_details');
        //    $db=$db->leftJoin('asset_site_details','assets.id','=','asset_details.asset_id');
        //    $db=$db->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
        //    $db=$db->leftJoin('asset_details','assets.id','=','asset_details.asset_id');
       $db=$db->leftJoin('city','asset_site_details.city','=','city.id');
       $db=$db->leftJoin('region','city.region_id','=','region.id');
       $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
       $db=$db->where('asset_site_details.sub_city',$request->sub_city);
       if($request->status!=4)
       {
       $db=$db->where('asset_site_details.status',$request->status);

       }
    //    if($type!=0)
    //    {
    //     $db=$db->where('assets.asset_type','=',$type);

    //    }
    //    if($request->bottler!=0)
    //    {
    //     $db=$db->where('assets.bottler','=',$request->bottler);

    //    }
    //    if($request->region!=0)
    //    {
    //        $db=$db->where('region.id',$request->region);

    //    }
    //    if($request->city!=0)
    //    {
    //        $db=$db->where('asset_site_details.city',$request->city);

    //    }
    //    if($request->district!=0)
    //    {
    //        $db=$db->where('asset_site_details.sub_city',$request->district);

    //    }
    //    if($request->surveyor!=0)
    //    {
    //        $db=$db->where('assets.surveyor',$request->surveyor);

    //    }
    //    if($request->qcofficer!=0)
    //    {
    //        $db=$db->where('assets.qc_officer',$request->qcofficer);

    //    }
       $db=$db->select(
        // DB::raw('COUNT(assets.id) as total_assets'),
        // DB::raw('COUNT(CASE when assets.status=0 then assets.id end) as total_active'),
        // DB::raw('COUNT(CASE when assets.status=1 then assets.id end) as total_conducted'),
        // DB::raw('COUNT(CASE when assets.status=2 then assets.id end) as total_completed')
        'city.name as city',
        'region.name as region',
        'sub_city.name as district',
        DB::raw('DATE_FORMAT(asset_site_details.conducted_on,"%d-%b-%Y %h:%i %p") as conducted_on'),
        DB::raw('DATE_FORMAT(asset_site_details.completed_on,"%d-%b-%Y %h:%i %p") as completed_on'),
        'asset_site_details.address',
        'asset_site_details.contact_no',
        'asset_site_details.shop_name',
        'asset_site_details.shopkeeper_name'
        );
    //    $db=$db->groupBy();
       $db=$db->get();

       return $db;

    }
    public function getListingForAssets(Request $request)
    {

        if($request->type==1)
        {
            $type=$request->type;
            $db=DB::table('assets');
            $db=$db->leftJoin('asset_details','assets.id','=','asset_details.asset_id');
            $db=$db->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
                //    $db=$db->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
            $db=$db->leftJoin('city','asset_site_details.city','=','city.id');
            $db=$db->leftJoin('region','city.region_id','=','region.id');
            // $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
            // $db=$db->leftJoin('users as surveyor','assets.surveyor','=','surveyor.id');
            // $db=$db->leftJoin('users as qc_officer','assets.qc_officer','=','qc_officer.id');
            // $db=$db->leftJoin('city','asset_site_details.city','=','city.id');
            // $db=$db->leftJoin('region','city.region_id','=','region.id');
            $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
            $db=$db->leftJoin('asset_type','assets.asset_type','=','asset_type.id');
            $db=$db->where('asset_site_details.sub_city',$request->city);
    
            if($request->type!=0)
            {
            $db=$db->where('assets.asset_type',$request->type);
    
            }
           
           if($request->status!=4)
           {
        
                $db=$db->where('assets.status',$request->status);
    
           }
        //    if($type!=0)
        //    {
        //     $db=$db->where('assets.asset_type','=',$type);
    
        //    }
        //    if($request->bottler!=0)
        //    {
        //     $db=$db->where('assets.bottler','=',$request->bottler);
    
        //    }
        //    if($request->region!=0)
        //    {
        //        $db=$db->where('region.id',$request->region);
    
        //    }
        //    if($request->city!=0)
        //    {
        //        $db=$db->where('asset_site_details.city',$request->city);
    
        //    }
        //    if($request->district!=0)
        //    {
        //        $db=$db->where('asset_site_details.sub_city',$request->district);
    
        //    }
        //    if($request->surveyor!=0)
        //    {
        //        $db=$db->where('assets.surveyor',$request->surveyor);
    
        //    }
        //    if($request->qcofficer!=0)
        //    {
        //        $db=$db->where('assets.qc_officer',$request->qcofficer);
    
        //    }
           $db=$db->select(
            'assets.id',
            'assets.title',
            'assets.status',
            'asset_details.tag_number',
            DB::raw('DATE_FORMAT(assets.created_at,"%Y") as assigned_on'),
            DB::raw('DATE_FORMAT(assets.conducted_on,"%d-%b-%Y %h:%i %p") as conducted_on'),
            DB::raw('DATE_FORMAT(assets.completed_on,"%d-%b-%Y %h:%i %p") as completed_on'),
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
            
            // year work

            'assets.age_of_asset as age_of_asset'
            // end 
            // 'surveyor.name as surveyor',
            // 'qc_officer.name as qc_officer'
            );
        //    $db=$db->groupBy();
           $db=$db->get();
    
           return $db;
        }
        else{
            $type=$request->type;
            $db=DB::table('assets');
            $db=$db->leftJoin('asset_details','assets.id','=','asset_details.asset_id');
            $db=$db->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
                //    $db=$db->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id');
            $db=$db->leftJoin('city','asset_site_details.city','=','city.id');
            // $db=$db->leftJoin('region','city.region_id','=','region.id');
            $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
            // $db=$db->leftJoin('users as surveyor','assets.surveyor','=','surveyor.id');
            // $db=$db->leftJoin('users as qc_officer','assets.qc_officer','=','qc_officer.id');
            // $db=$db->leftJoin('city','asset_site_details.city','=','city.id');
            // $db=$db->leftJoin('region','city.region_id','=','region.id');
            // $db=$db->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id');
            $db=$db->leftJoin('asset_type','assets.asset_type','=','asset_type.id');
            $db=$db->where('assets.bottler',$request->city);
    
            if($request->type!=0)
            {
            $db=$db->where('assets.asset_type',$request->type);
    
            }
           
           if($request->status!=4)
           {
        
                $db=$db->where('assets.status',$request->status);
    
           }
        //    if($type!=0)
        //    {
        //     $db=$db->where('assets.asset_type','=',$type);
    
        //    }
        //    if($request->bottler!=0)
        //    {
        //     $db=$db->where('assets.bottler','=',$request->bottler);
    
        //    }
        //    if($request->region!=0)
        //    {
        //        $db=$db->where('region.id',$request->region);
    
        //    }
        //    if($request->city!=0)
        //    {
        //        $db=$db->where('asset_site_details.city',$request->city);
    
        //    }
        //    if($request->district!=0)
        //    {
        //        $db=$db->where('asset_site_details.sub_city',$request->district);
    
        //    }
        //    if($request->surveyor!=0)
        //    {
        //        $db=$db->where('assets.surveyor',$request->surveyor);
    
        //    }
        //    if($request->qcofficer!=0)
        //    {
        //        $db=$db->where('assets.qc_officer',$request->qcofficer);
    
        //    }
           $db=$db->select(
            'assets.id',
            'assets.title',
            'assets.status',
            'asset_details.tag_number',
            DB::raw('DATE_FORMAT(assets.created_at,"%Y") as assigned_on'),
            DB::raw('DATE_FORMAT(assets.created_at,"%d-%b-%Y %h:%i %p") as assigned_on_date'),
            DB::raw('DATE_FORMAT(assets.conducted_on,"%d-%b-%Y %h:%i %p") as conducted_on'),
            DB::raw('DATE_FORMAT(assets.completed_on,"%d-%b-%Y %h:%i %p") as completed_on'),
            'asset_site_details.address',
            'asset_details.make',
            'asset_details.reg_no',
            'asset_details.chassis_no',
            'asset_details.engine_no',
            'asset_type.name as asset_type',
            'assets.status',
            // 'region.name as region',
            'city.name as city',
            'city.prefix as city_prefix',
            'sub_city.name as district',
            // 'surveyor.name as surveyor',
            // 'qc_officer.name as qc_officer'
            );
        //    $db=$db->groupBy();
           $db=$db->get();
    
           return $db;
        }


    }
    
    public function completedJob($id)
    {
        // echo 'worling';

        $db=DB::table('assets')
        ->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id')
        ->where('assets.id',$id)
        ->select('asset_site_details.status','assets.status as asset_status','asset_site_details.id as site_id')
        ->get();
        if($db[0]->status==0 )
        {
            echo 'Please complete the site verification first case cannot be closed without it';
        }
        else{

            if($db[0]->asset_status==1)
            {
                DB::table('assets')->where('id',$id)->update([
                    'status'=>2,
                    'completed_on'=>date('Y-m-d')
                   ]);
    
                   echo "Asset Survey completed Successfully \n";
    
            }
            else if($db[0]->asset_status==2){
                echo "Asset Survey Already Completed \n";

            }

            else if($db[0]->asset_status==0){
                echo "Asset Survey not conducted conduct it first \n";

            }



            if($db[0]->status==1)
            {
                DB::table('asset_site_details')->where('id',$db[0]->site_id)->update([
                'status'=>2,
                'completed_on'=>date('Y-m-d')
                ]);

               echo "Site Survey completed Successfully";

            }
            else if($db[0]->status==2){
                echo "Site Survey Already Completed";

            }

            else if($db[0]->status==0){
                echo "Site Survey not conducted conduct it first";

            }

        }


    }
    public function cancelledJob($id)
    {
        // echo 'worling';
       DB::table('assets')->where('id',$id)->update([
        'status'=>3,
        'completed_on'=>'',
        'conducted_on'=>''
       ]);

    }

    public function editsurvey($id,Request $request)
    {
        $db=DB::table('assets')
        ->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id')
        ->where('assets.id',$id)
        ->select('assets.status as asset_survey_status','asset_site_details.status as site_survey_status')
        ->get();

        $data=[
            'token'=>$request->session()->get('token'),
            'id'=>$id,
            'asset_survey_status'=>$db[0]->asset_survey_status,
            'site_survey_status'=>$db[0]->site_survey_status,
            'user_id'=>$request->user()->id,


        ];
        return view('assets.editsurvey',compact('data'));
    }

    public function getLocationFromDatabase($id,Request $request)
    {
        $db=DB::table('assets')
        ->leftJoin('asset_site_details','assets.site_id','=','asset_site_details.id')
        ->where('assets.id',$id)
        ->select('asset_site_details.gps')
        ->get();

        return $db[0]->gps;

    }
    public function getStatsAll()
{
    $shops = DB::table('asset_site_details')
        ->leftJoin('city', 'asset_site_details.city', '=', 'city.id')
        ->leftJoin('region', 'city.region_id', '=', 'region.id')
        ->select(
            'region.name as region_name',
            'city.name as city_name',
            DB::raw('count(asset_site_details.id) AS total_shops_in_city'),
            DB::raw('count(CASE WHEN asset_site_details.given_by = 0 THEN asset_site_details.id END) AS given_by_sample'),
            DB::raw('count(CASE WHEN asset_site_details.given_by = 1 THEN asset_site_details.id END) AS manually_added'),
            DB::raw('count(CASE WHEN asset_site_details.is_site_accessible = "No" THEN asset_site_details.id END) AS shop_not_accessible'),
            DB::raw('count(CASE WHEN asset_site_details.is_site_accessible = "Yes" THEN asset_site_details.id END) AS shop_accessible'),
            DB::raw('count(CASE WHEN asset_site_details.is_verified = "Yes" THEN asset_site_details.id END) AS verified_shops'),
            DB::raw('count(CASE WHEN asset_site_details.is_verified = "No" THEN asset_site_details.id END) AS non_verified_shops')
        )
        ->groupBy('city.id')
        ->get();

    $cityIds = $shops->pluck('city_id')->all();

    $assets = DB::table('assets')
        ->leftJoin('asset_site_details', 'assets.site_id', '=', 'asset_site_details.id')
        ->leftJoin('asset_details', 'assets.id', '=', 'asset_details.asset_id')
        ->leftJoin('city', 'asset_site_details.city', '=', 'city.id')
        ->leftJoin('region', 'city.region_id', '=', 'region.id')
        ->whereIn('asset_site_details.city', $cityIds)
        ->select(
            'region.name as region_name',
            'city.name as city_name',
            DB::raw('count(assets.id) AS total_assets'),
            DB::raw('count(CASE WHEN assets.given_by = 0 THEN assets.id END) AS given_by_sample'),
            DB::raw('count(CASE WHEN assets.status = 2 THEN assets.id END) AS verified_assets'),
            DB::raw('count(CASE WHEN assets.status = 1 AND asset_details.existance = "No" THEN assets.id END) AS cooler_does_not_exist'),
            DB::raw('count(CASE WHEN assets.status = 1 AND asset_details.tag_number_by_client != asset_details.tag_number THEN assets.id END) AS tag_number_not_matched'),
            DB::raw('count(CASE WHEN assets.status = 1 AND asset_details.tag_number_by_client = asset_details.tag_number THEN assets.id END) AS tag_number_matched')
        )
        ->groupBy('city.id')
        ->get();

    $recs = [];

    foreach ($shops as $shop) {
        $asset = $assets->firstWhere('city_name', $shop->city_name);

        $recs[] = [
            'region' => $shop->region_name,
            'city' => $shop->city_name,
            'total_shop_in_city' => $shop->total_shops_in_city,
            'total_assets_in_city' => $asset->total_assets,
            'total_assets_given_by_sample' => $asset->given_by_sample,
            'assets_verified' => $asset->verified_assets,
            'cooler_does_not_exist' => $asset->cooler_does_not_exist,
            'tag_number_not_matched' => $asset->tag_number_not_matched,
            'tag_number_matched' => $asset->tag_number_matched,
        ];
    }

    return $recs;
}
    public function getsitesforadmin(Request $request)
    {

        $sites=DB::select("CALL geSites()");
        // $assets=DB::select("CALL getAssets()");
        $recs=collect([]);
     
        foreach($sites as $site)
        {
            $recs->push([
                'region'=>$site->region_name,
                'city'=>$site->city_name,
                'city_id'=>$site->city,
                'total_shop_in_city'=>$site->total_sites,
                'active_sites'=>$site->active_sites,
                'sites_conducted'=>$site->conducted_sites,
                'sites_finished'=>$site->finished_sites
                // 'total_assets_in_city'=>$assets->total_assets,
                // 'assets_active'=>$assets->assets_active,
                // 'assets_conducted'=>$assets->conducted_assets,
                // 'assets_finished'=>$assets->finished_assets
            ]);
    
        }

            $recs->all();

            return $recs;


    

    }
    public function getassetsforadmin(Request $request)
    {

        // $sites=DB::select("CALL geSites()");
        if($request->type==1)
        {

            $assets=DB::select('CALL getAssetsCooler(?)',array($request->bottler));
            $recs=collect([]);
     
            foreach($assets as $site)
            {
                $recs->push([
                    'region'=>$site->region_name,
                    'city'=>$site->city_name,
                    'bottler'=>$site->bottler,
                    'city_id'=>$site->city,
                    'total_assets_in_city'=>$site->total_assets,
                    'assets_active'=>$site->active_assets,
                    'assets_conducted'=>$site->conducted_assets,
                    'assets_finished'=>$site->finished_assets
                ]);
        
            }
    
                $recs->all();
        
        }
        else{
            $assets=DB::select('CALL getAssetsVehicle(?)',array($request->bottler));
            $recs=collect([]);
     
            foreach($assets as $site)
            {
                $recs->push([
                    'bottler'=>$site->bottler,
                    'bottler_id'=>$site->bottler_id,
                    'total_assets_in_city'=>$site->total_assets,
                    'assets_active'=>$site->active_assets,
                    'assets_conducted'=>$site->conducted_assets,
                    'assets_finished'=>$site->finished_assets
                ]);
        
            }
    
                $recs->all();
        }
        

            return $recs;


    

    }
    public function surveygeneralinfo($id,Request $request)
    {
        $db=DB::table('assets')
        ->where('id',$id)
        ->select('asset_type')
        ->get();

        $data=[
            'token'=>$request->session()->get('token'),
            'id'=>$id,
            'user_id'=>$request->user()->id,
            'survey_type'=>$db[0]->asset_type,


        ];
        // return $data;
        return view('assets.surveygeneral',compact('data'));
    }
    public function surveyeditinfo($id,Request $request)
    {
        $db=DB::table('assets')
        ->where('id',$id)
        ->select('asset_type')
        ->get();

        $data=[
            'token'=>$request->session()->get('token'),
            'id'=>$id,
            'user_id'=>$request->user()->id,
            'survey_type'=>$db[0]->asset_type,


        ];
        // return $data;
        return view('assets.surveyeditinfo',compact('data'));
    }
    public function surveyassetinfo($id,Request $request)
    {
        $db=DB::table('assets')
        ->where('id',$id)
        ->select('asset_type')
        ->get();

        $data=[
            'token'=>$request->session()->get('token'),
            'id'=>$id,
            'user_id'=>$request->user()->id,
            'survey_type'=>$db[0]->asset_type,


        ];
        // return $data;
        return view('assets.assetdetails',compact('data'));
    }
    public function surveyimages($id,Request $request)
    {
        $data=[
            'token'=>$request->session()->get('token'),
            'id'=>$id,
            'user_id'=>$request->user()->id,


        ];
        return view('assets.surveyimages',compact('data'));
    }
    public function getImages($id,Request $request)
    {

       return Asset::getImages($id,$request);

    }
    // image order 
    public function updateOrder(Request $r, $id){
        $orderId = $r->orderID;
        $result = DB::table('assets_images')->where('id', $id)->update([
            'order_path' => $orderId
        ]);
    
        if ($result) {
            return response()->json(['message' => 'Update successful'], 200);
        } else {
            return response()->json(['message' => 'Update failed'], 500);
        }
    }
    // end 
    public function uploadimages(Request $request)
    {

        Asset::uploadimages($request);

    }
    public function getDataForUpdate($id,Request $request)
    {

       return Asset::getDataForUpdate($id,$request);

    }

    public function create(Request $request)
    {
        $data=[
            // 'token'=>$request->session()->get('token')
            'token'=>$request->session()->get('token')
        ];
        return view('assets.create',compact('data'));
    }
    public function storeAsset(Request $request)
    {
       echo Asset::storeAsset($request);     
          
    }
    public function storeAssetsByFar(Request $request)
    {
        $theArray = Excel::toCollection('',$request->file('myfile'));
       
        if($request->type==1)
        {
            Asset::coolerBulk($request,$theArray);
        }
        else{
            Asset::vehicleBulk($request,$theArray);

        }
        
        // return $theArray[0];    
    }
    public function updateAsset($id,Request $request)
    {
       echo Asset::updateAsset($id,$request);     
          
    }





    public function getUserRole(){

$id = auth()->user()->id;

        $role=DB::table('users')
        ->where('id',$id)
        ->select('role')
        ->first();

 return $role;
    }



  public function getImageCount($id){

    
    $assetCount = DB::table('assets_images')
    ->where('asset_id', $id)
    ->count();
return $assetCount;
  }


}
