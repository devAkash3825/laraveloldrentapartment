<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFloorPlanDetail extends Model
{
    use HasFactory;
    protected $table = 'propertyfloorplandetails';

    public $timestamps = false;
    protected $guarded = [];

    public function getFormattedCreatedOnAttribute()
    {
        return $this->CreatedOn->format('Y-m-d');
    }
    public function getFormattedModifiedOnAttribute()
    {
        return $this->ModifiedOn->format('Y-m-d');
    }

    public function propertyinfo(){
        return $this->belongsTo(PropertyInfo::class,'PropertyId','Id');
    }

    public function gallerydetail(){
        return $this->hasMany(GalleryDetails::class,'floorplan_id','Id');
    }

    public function propertyfloorplancategory(){
        return $this->belongsTo(FloorPlanCategory::class,'CategoryId','Id');
    }

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];
    
}
