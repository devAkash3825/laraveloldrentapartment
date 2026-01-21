<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FavoriteCollection;
use App\Repositories\FavoriteRepository;

class FavoriteService
{
    protected $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function getFavoriteProperties()
    {
        $user = Auth::guard('renter')->user();
        if (!$user) {
            return collect();
        }
        $userId = $user->Id;
        $properties = $this->favoriteRepository->getFavoriteProperties($userId);
        return $properties;
    }


}
