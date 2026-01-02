<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\PropertyInfo;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\GalleryType;
use App\Models\GalleryDetails;

class FavoriteRepository 
{
    public function getFavoriteProperties($userId)
    {
        $properties = PropertyInfo::where('ActiveOnSearch', 1)->where('Status', 1)
            ->whereHas('favorites', function ($query) use ($userId) {
                $query->where('UserId', $userId)->where('Status', 1);
            })
            ->with(['favorites' => function ($query) use ($userId) {
                $query->where('UserId', $userId)->where('Status', 1);
            }])
            ->with('city.state') 
            ->with('login')
            ->get();

        return $properties;
    }
    
}