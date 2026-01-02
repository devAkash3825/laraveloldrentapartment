<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyInfo;

class GalleryType extends Model
{
    use HasFactory;
    protected $table = 'gallerytype';
    protected $guarded = [];
    public $timestamps = false;
    

    public function gallerydetail()
    {
        return $this->hasMany(GalleryDetails::class,'GalleryId', 'Id');
    }

    // public function propertyInfo()
    // {
    //     return $this->belongsTo(PropertyInfo::class, 'Id');
    // }

    public function propertyinfo(){
        return $this->belongsTo(PropertyInfo::class,'PropertyId','Id');
    }

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];


    
}
