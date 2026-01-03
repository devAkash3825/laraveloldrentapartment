<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryType extends Model
{
    use HasFactory;
    
    protected $table = 'gallerytype';
    public $timestamps = false;
    
    protected $fillable = [
        'PropertyId',
        'Title',
        'Description',
        'CreatedOn',
        'ModifiedOn',
        'Status',
    ];

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];

    /**
     * Relationship: Has many gallery details (images)
     */
    public function gallerydetail()
    {
        return $this->hasMany(GalleryDetails::class,'GalleryId', 'Id');
    }

    /**
     * Relationship: Belongs to PropertyInfo
     */
    public function propertyinfo(){
        return $this->belongsTo(PropertyInfo::class,'PropertyId','Id');
    }

    /**
     * Get active gallery images
     */
    public function activeImages()
    {
        return $this->gallerydetail()->where('Status', '1');
    }

    /**
     * Get default/logo image
     */
    public function defaultImage()
    {
        return $this->gallerydetail()
                    ->where('DefaultImage', '1')
                    ->where('Status', '1')
                    ->first();
    }

    /**
     * Get display gallery images
     */
    public function displayGalleryImages()
    {
        return $this->gallerydetail()
                    ->where('display_in_gallery', '1')
                    ->where('Status', '1')
                    ->get();
    }

    /**
     * Get or create gallery type for property
     */
    public static function getOrCreateForProperty($propertyId, $title = 'Property Gallery')
    {
        return self::firstOrCreate(
            ['PropertyId' => $propertyId],
            [
                'Title' => $title,
                'Description' => '',
                'CreatedOn' => now(),
                'ModifiedOn' => now(),
                'Status' => '1'
            ]
        );
    }
}
