<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assets_Details extends Model
{
    use HasFactory;

    protected $table ='asset_details';

    protected $fillable=[
        'asset_id',
        'address',
        'contact_no',
        'is_site_accessible',
        'same_location',
        'shop_name',
        'shopkeeper_name',
        'tag_number',
        'tag_number_by_client',
        'existance',
        'functional',
        'make',
        'make_by_client',
        'type',
        'type_by_client',
        'reg_no',
        'engine_no',
        'engine_no_by_client',
        'chassis_no',
        'chassis_no_by_client',
        'reason_for_no_operational',
        'type_other',
        'is_cooler_accessible',
        'general_condition',
        'model_number',
        'model_no_by_client',
        'is_vehicle_destributed',
        'volume',
        'utilization',
        'utilization_pepsi',
        'utilization_shared',
        'shared_products_name'
    
    ];


}
