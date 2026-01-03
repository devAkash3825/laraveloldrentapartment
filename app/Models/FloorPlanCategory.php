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
        return $this->CreatedOn ? $this->CreatedOn->format('Y-m-d') : null;
    }
    
    public function getFormattedModifiedOnAttribute()
    {
        return $this->ModifiedOn ? $this->ModifiedOn->format('Y-m-d') : null;
    }

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];
}