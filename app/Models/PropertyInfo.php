<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PropertyInfo extends Model
{
    use Notifiable;
    
    use HasFactory;
    protected $table = 'propertyinfo';
    public $timestamps = false;
    protected $guarded = [];
    
    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class,'PropertyId', 'Id');
    }

    public function gallerytype()
    {
        return $this->hasOne(GalleryType::class,'PropertyId','Id');
    }

    public function city(){
        return $this->belongsTo(City::class,'CityId','Id');
    }

    public function state(){
        return $this->belongsTo(State::class,'Id');
    }

    public function getGalleryImages()
    {
        $imageIds = GalleryType::where('PropertyId', $this->Id)->pluck('Id');
        $imageDetails = GalleryDetails::whereIn('GalleryId', $imageIds)
            ->where('DefaultImage', 1)
            ->where('Status', 1)
            ->get(['Id', 'ImageName']);

        return $imageDetails;
    }


    public function getBannerImage(){
        $imageIds = GalleryType::where('PropertyId', $this->Id)->pluck('Id');
        $listingimg = GalleryDetails::whereIn('GalleryId', $imageIds)
            ->where('DefaultImage', 1)
            ->where('Status', 1)
            ->first(['Id', 'ImageName']);
        return $listingimg;
    }

    public function userproperty(){
        return $this->hasMany(UserProperty::class,'propertyId','Id');
    }

    public function propertyfloorplandetails(){
        return $this->hasMany(PropertyFloorPlanDetail::class,'PropertyId','Id');
    }

    public function getFormattedModifiedOnAttribute()
    {
        return $this->ModifiedOn->format('d-m-Y');
    }

    public function special(){
        return $this->hasMany(Special::class,'PropertyId','Id');
    }


    public function communitydescription(){
        return $this->hasOne(CommunityDescription::class,'PropertyId','Id');
    }
    public function login(){
        return $this->belongsTo(Login::class,'UserId','Id');
    }

    public function calls()
    {
        return $this->hasMany(Call::class, 'property_id');
    }

    public function propertyAdditionalInfo(){
        return $this->hasOne(propertyAdditionalInfo::class,'PropertyId','Id');
    }

    public function newAdditionalInfo(){
        return $this->hasOne(propertyNewAdditionalInfo::class,'PropertyId','Id');
    }

    public function propertyinquiry(){
        return $this->hasMany(PropertyInquiry::class,'PropertyId','Id');
    }

    public function messages(){
        return $this->hasMany(Message::class,'propertyId','Id');
    }


    public function getFirstImageUrl()
    {   
        if ($this->gallerytype && $this->gallerytype->gallerydetail->isNotEmpty()) {
            return "https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_". $this->Id . "/Original/" . $this->gallerytype->gallerydetail->first()->ImageName;
        }
        return 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fstock.adobe.com%2Fsearch%2Fimages%3Fk%3Dno%2Bimage%2Bavailable&psig=AOvVaw1Ld6qHZlaccx-bDFb0SLzf&ust=1727155408676000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCMCR2Lyp2IgDFQAAAAAdAAAAABAE';
    }

    public function apartmentfeatures(){
        return $this->belongsTo(ApartmentFeature::class,'PropertyFeatures','Id');
    }

    public function communityamenities(){
        return $this->belongsTo(CommunityAmenities::class,'CommunityFeatures','id');
    }

    public function notifydetails(){
        return $this->hasMany(NotifyDetail::class,'property_id','Id');
    }
    
    
}
