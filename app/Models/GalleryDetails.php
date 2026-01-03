<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryDetails extends Model
{
    use HasFactory;
    
    protected $table = 'gallerydetails';
    public $timestamps = false;
    
    protected $fillable = [
        'GalleryId',
        'ImageTitle',
        'Description',
        'ImageName',
        'DefaultImage',
        'display_in_gallery',
        'CreatedOn',
        'ModifiedOn',
        'Status',
        'floorplan_id',
    ];

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
        'DefaultImage' => 'integer',
        'display_in_gallery' => 'integer',
    ];

    /**
     * Relationship: Belongs to GalleryType
     */
    public function gallerytype()
    {
        return $this->belongsTo(GalleryType::class,'GalleryId','Id');
    }

    /**
     * Relationship: Belongs to PropertyFloorPlanDetail (optional)
     */
    public function propertyfloorplandetails(){
        return $this->belongsTo(PropertyFloorPlanDetail::class,'floorplan_id','Id');
    }

    /**
     * Scope: Active images
     */
    public function scopeActive($query)
    {
        return $query->where('Status', '1');
    }

    /**
     * Scope: Default images
     */
    public function scopeDefault($query)
    {
        return $query->where('DefaultImage', '1');
    }

    /**
     * Scope: Gallery display images
     */
    public function scopeDisplayInGallery($query)
    {
        return $query->where('display_in_gallery', '1');
    }

    /**
     * Scope: Floor plan images
     */
    public function scopeFloorPlanImages($query)
    {
        return $query->whereNotNull('floorplan_id');
    }

    /**
     * Get full image URL
     */
    public function getImageUrlAttribute()
    {
        if (!$this->ImageName || !$this->gallerytype) {
            return null;
        }

        $propertyId = $this->gallerytype->PropertyId;
        return "https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{$propertyId}/Original/{$this->ImageName}";
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        if (!$this->ImageName || !$this->gallerytype) {
            return null;
        }

        $propertyId = $this->gallerytype->PropertyId;
        return "https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{$propertyId}/Thumbnail/{$this->ImageName}";
    }

    /**
     * Set as default image (unset others first)
     */
    public function setAsDefault()
    {
        // Unset all other default images in this gallery
        self::where('GalleryId', $this->GalleryId)
            ->where('Id', '!=', $this->Id)
            ->update(['DefaultImage' => '0']);

        // Set this as default
        $this->update(['DefaultImage' => '1']);
    }

    /**
     * Check if this is a floor plan image
     */
    public function isFloorPlanImage()
    {
        return !is_null($this->floorplan_id);
    }
}
