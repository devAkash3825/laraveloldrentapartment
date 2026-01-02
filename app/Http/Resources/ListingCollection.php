<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function($propertyinfo){
            
            return [
                'Id' => $propertyinfo->Id ?? '',
                'state' => $propertyinfo->city->state->StateName ?? '',
                'city' => $propertyinfo->city->CityName ?? '',
                'area' => $propertyinfo->Area ?? '',
                'propertyname' => $propertyinfo->PropertyName ?? '',
                'address' => $propertyinfo->Address ?? '',
                'listingImages' => $propertyinfo->getBannerImage() ?? '',
            ];
        })->toArray();
    }
}
