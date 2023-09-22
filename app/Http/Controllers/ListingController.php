<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ListingController extends Controller
{
    public function getUsers(Request $request)
    {
        // echo $request->type;
     
        return DB::table('users')
        ->where('users.role',$request->type)
        ->leftJoin('city','users.city','=','city.id')
        ->leftJoin('sub_city','users.sub_city','=','sub_city.id')
        ->select(
        'users.id',
        'users.name',
        'city.name as city_name',
        'sub_city.name as sub_city_name',
        
        )->get();
    }
    
    public function getUsersListing(Request $request)
    {
        // echo $request->type;
     
        return DB::table('users')
        ->leftJoin('user_role','users.role','=','user_role.id')
        ->leftJoin('city','users.city','=','city.id')
        ->leftJoin('region','city.region_id','=','region.id')
        ->leftJoin('sub_city','users.sub_city','=','sub_city.id')
        ->select(
        'users.id',
        'users.name',
        'user_role.name as role',
        'users.email',
        'region.name as region_name',
        'city.name as city_name',
        'sub_city.name as sub_city_name',
        
        )->get();
    }
    
    public function getTypes()
    {
        return DB::table('asset_type')->select('*')->get();
    }
    public function getRefId()
    {
        // return DB::table('assets')->select('*')->get();
        $rec=DB::table('assets')->latest('created_at')->first();
        return $rec->id+1;
    }

    public function getRegions()
    {
        return DB::table('region')->select('*')->get();
    }

    public function getCity(Request $request)
    {
        return DB::table('city')
        ->where('region_id',$request->city)
        ->select('*')->get();
    }
    public function getBottlers(Request $request)
    {
        return DB::table('bottler')
        // ->where('region_id',$request->city)
        ->select('*')->get();
    }

    public function getCityForDashboard(Request $request)
    {
        return DB::table('city')
        // ->where('region_id',$request->city)
        ->select('*')->get();
    }


    public function getDistrictsForDashboard(Request $request)
    {
        return DB::table('sub_city')
        // ->where('city_id',$request->city)
        ->select('*')->get();
    }
    public function getDistricts(Request $request)
    {
        return DB::table('sub_city')
        ->where('city_id',$request->city)
        ->select('*')->get();
    }
    public function getSites(Request $request)
    {
        return DB::table('asset_site_details')
        ->where('city',$request->city)
        ->select('*')->get();
    }
    public function getSiteDetails(Request $request)
    {
        return DB::table('asset_site_details')
        ->leftJoin('city','asset_site_details.city','=','city.id')
        ->leftJoin('region','city.region_id','=','region.id')
        ->leftJoin('sub_city','asset_site_details.sub_city','=','sub_city.id')
        ->where('asset_site_details.id',$request->site)
        ->select(
            'region.name as region_name',
            'region.id as region_id',
            'city.name as city_name',
            'city.id as city_id',
            'city.prefix as city_prefix',
            'sub_city.name as district_name',
            'sub_city.id as district_id',
            'asset_site_details.address',
            'asset_site_details.contact_no',
            'asset_site_details.other_address',
            'asset_site_details.is_site_accessible',
            'asset_site_details.shop_name',
            'asset_site_details.shopkeeper_name',
            'asset_site_details.same_location',

 
            )->get();
    }


}
