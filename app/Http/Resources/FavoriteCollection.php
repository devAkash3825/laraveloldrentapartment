<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FavoriteCollection extends ResourceCollection
{
    public function toArray($request)
    {   
        return $this->collection->map(function($property){
            return [
                    'id' => $property->Id,
                    'propertyname'=>$property->PropertyName,
                    'company'=>$property->Company,
                    'address'=>$property->Address,
                    'area'=>$property->Area,
                    'longitude'=>$property->longitude,
                    'latitude'=>$property->latitude,
                    'zip'=>$property->Zip,
                    'propertyfeature'=>$property->PropertyFeatures,
                    'image'=>$property->getGalleryImages(),
                    'city' => $this->getCityName($property),
                    'state' => $this->getStateName($property),
                    'lat'=>$property->latitude,
                    'lon'=>$property->longitude,
                    'username'=> $property->login->UserName,
                    'features' => $property->CommunityFeatures,
            ];
        })->all();
    }

    public function getCityName($property)
    {
        return $property->city ? $property->city->CityName : '';
    }

    public function getStateName($property)
    {
        return $property->city->state ? $property->city->state->StateName : '';
    }

    public function withAdditionalFields()
    {
        return $this->collection->transform(function ($property) {
            return [
                'id' => $property->id,
                'name' => $property->name,
                'features' => $property->features,
                'imageDetails' => $property->imageDetails,
                'additionalField1' => $property->additionalField1,
                'additionalField2' => $property->additionalField2,
            ];
        });
    }
}