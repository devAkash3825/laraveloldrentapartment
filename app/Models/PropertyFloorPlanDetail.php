<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFloorPlanDetail extends Model
{
    use HasFactory;
    
    protected $table = 'propertyfloorplandetails';
    public $timestamps = false;

    protected $fillable = [
        'PropertyId',
        'CategoryId',
        'PlanType',
        'FloorPlan',
        'PlanName',
        'Footage',
        'Price',
        'Comments',
        'CreatedOn',
        'ModifiedOn',
        'Status',
        'Available_Url',
        'special',
        'expiry_date',
        'avail_date',
        'isavailable',
        'deposit',
        'floorplan_link',
    ];

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
        'Price' => 'integer',
        'Footage' => 'integer',
        'isavailable' => 'integer',
    ];

    /**
     * Relationship: Belongs to PropertyInfo
     */
    public function propertyinfo(){
        return $this->belongsTo(PropertyInfo::class,'PropertyId','Id');
    }

    /**
     * Relationship: Has many gallery details (floor plan images)
     */
    public function gallerydetail(){
        return $this->hasMany(GalleryDetails::class,'floorplan_id','Id');
    }

    /**
     * Relationship: Belongs to Floor Plan Category
     */
    public function propertyfloorplancategory(){
        return $this->belongsTo(FloorPlanCategory::class,'CategoryId','Id');
    }

    /**
     * Accessor: Get formatted created date
     */
    public function getFormattedCreatedOnAttribute()
    {
        return $this->CreatedOn ? $this->CreatedOn->format('Y-m-d') : null;
    }

    /**
     * Accessor: Get formatted modified date
     */
    public function getFormattedModifiedOnAttribute()
    {
        return $this->ModifiedOn ? $this->ModifiedOn->format('Y-m-d') : null;
    }

    /**
     * Accessor: Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return $this->Price ? '$' . number_format($this->Price, 0) : 'N/A';
    }

    /**
     * Accessor: Get formatted footage
     */
    public function getFormattedFootageAttribute()
    {
        return $this->Footage ? number_format($this->Footage) . ' sq ft' : 'N/A';
    }

    /**
     * Scope: Get available floor plans
     */
    public function scopeAvailable($query)
    {
        return $query->where('Status', '1')
                    ->where('isavailable', 1);
    }

    /**
     * Scope: By property ID
     */
    public function scopeByProperty($query, $propertyId)
    {
        return $query->where('PropertyId', $propertyId);
    }

    /**
     * Scope: By category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('CategoryId', $categoryId);
    }

    /**
     * Get first floor plan image
     */
    public function getFirstImageAttribute()
    {
        $image = $this->gallerydetail()->where('Status', '1')->first();
        return $image ? $image->ImageName : null;
    }
}
