<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloorPlanCategory extends Model
{
    use HasFactory;
    protected $table = 'propertyfloorplancategory';
    public $timestamps = false;
    protected $guarded = [];

    public function getFloorPlanDetails($propertyId, $categoryId)
    {
        $properties = PropertyFloorPlanDetail::where('PropertyId', $propertyId)->where('CategoryId', $categoryId)
        ->with('gallerydetail')
        ->get();
        return $properties;
    }


    public function floorplandetails(){
        return $this->hasMany(PropertyFloorPlanDetail::class,'CategoryId','Id');
    }
    
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

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];
}