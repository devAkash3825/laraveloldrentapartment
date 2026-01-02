<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'city';
    protected $guarded = [];
    public $timestamps = false;

    public function state(){
        return $this->belongsTo(State::class,'StateId','Id');
    }
    
    public function propertyinfo()
    {
        return $this->hasMany(PropertyInfo::class,'CityId','Id');
    }

    public function renterinfo(){
        return $this->hasMany(RenterInfo::class,'CityId','Id');
    }

    public function adminaccess(){
        return $this->hasMany(AdminAccess::class,'admin_city_id','Id');
    }
    
    public function favorite(){
        return $this->hasMany(Favorite::class,'PropertyId','Id');
    }

    public function getSelectCities($list){
        $selectedStateCities = City::whereIn('Id',$list)->get();
        return $selectedStateCities;

    }

    // public static function getCityNameById($cityId)
    // {
    //     $admin = self::find($cityId);
    //     return $admin ? $admin->admin_name : 'Unknown Admin';
    // }


}
