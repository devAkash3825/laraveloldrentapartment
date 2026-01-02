<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryDetails extends Model
{
    use HasFactory;
    protected $table = 'gallerydetails';
    protected $guarded = [];

    public $timestamps = false;
    
    
    public function gallerytype()
    {
        return $this->belongsTo(GalleryType::class,'GalleryId','Id');
    }

    public function propertyfloorplandetails(){
        return $this->belongsTo(GalleryDetails::class,'floorplan_id','Id');
    }

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];
}
