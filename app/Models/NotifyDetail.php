<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyDetail extends Model
{
    use HasFactory;

    protected $table = "notifydetails";
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'send_time' => 'datetime',
        'respond_time' => 'datetime',
    ];

    public function propertyinfo(){
        return $this->belongsTo(PropertyInfo::class,'property_id','Id');
    }

    public function renterinfo(){
        return $this->belongsTo(RenterInfo::class,'renter_id','Login_ID');
    }




    
}
