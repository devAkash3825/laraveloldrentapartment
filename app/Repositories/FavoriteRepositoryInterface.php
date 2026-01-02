<?php
namespace App\Repositories;

interface FavoriteRepositoryInterface
{
    public function getAllWithRelations();
    public function getLatLon();
    public function getBasicInfo();
}
