<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsSiteDetails extends Model
{
    use HasFactory;

    protected $table ='asset_site_details';

    protected $fillable=[
        'address',
        'contact_no',
        'is_site_accessible',
        'same_location',
        'assigned_on',
        'is_verified',
        'shop_name',
        'shopkeeper_name'
    
    ];

}
