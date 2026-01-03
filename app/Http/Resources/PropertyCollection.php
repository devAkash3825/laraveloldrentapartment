<?php

namespace App\Http\Resources;

// use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return $this->collection->map(function($property){
            return [
                'id' => $property->Id,
                'propertyname'=>$property->PropertyName,
                'managerId' => $property->UserId,
                'manageBy'=>$property->Company,
                'address'=>$property->Address,
                'lat'=>$property->latitude,
                'lon'=>$property->longitude,
                'noofunit'=>$property->Units,
                'year'=>$property->Year,
                'yearremodeled'=>$property->YearRemodel,
                'zip'=>$property->Zip,
                'contact'=>$property->ContactNo,
                'area'=>$property->Area,
                'faxno'=>$property->Fax,
                'website'=>$property->WebSite,
                'officehour'=>$property->officehour,
                'leaseinfo' => $property->propertyAdditionalInfo->LeasingTerms ?? '',
                'pets' => $property->propertyAdditionalInfo->PetPolicy ?? '',
                'school' => $property->propertyAdditionalInfo->Schools ?? '',
                'qualifycriteria' => $property->propertyAdditionalInfo->QualifiyingCriteria ?? '',
                'parking' => $property->propertyAdditionalInfo->Parking ?? '',
                'communitydescription' => $property->communitydescription->Description ?? '',
                'agentcomments' => $property->communitydescription->Agent_comments ?? '',
                'drivedirection'=> $property->propertyAdditionalInfo->drivedirection ?? '',
                'neighborhood'=> $property->propertyAdditionalInfo->Neighborhood ?? '',
                'apartmentinfo'=> $property->PropertyFeatures ?? '',
                'amenities'=> $property->CommunityFeatures,
                'price'=>$property->propertyfloorplandetails['Price'] ?? '',
                'image'=>$property->getGalleryImages() ?? '',
                'city' => $this->getCityName($property) ?? '',
                'state' => $this->getStateName($property) ?? '',
                'allimages'=> $property->gallerytype->gallerydetail ?? '',
                'floorplanimages' => $property->propertyfloorplandetails ?? '',
                'username' => $property->login->UserName ?? '',
                'userid' => $property->login->Id ?? '',
                'PropertyContact'=>$property->PropertyContact,
                'email' => $property->Email,
                'updatedon' => $property->floorplanimages->ModifiedOn ?? '',
                'listingImages' => $property->getBannerImage() ?? '',
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
}
