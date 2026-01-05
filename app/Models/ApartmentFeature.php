<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentFeature extends Model
{
    use HasFactory;
    protected $table = 'propertyfeaturetype';
    public $timestamps = false;
    protected $guarded = [];

    public function propertyinfo(){
        return $this->hasMany(PropertyInfo::class,'PropertyFeatures','Id');
    }
}
