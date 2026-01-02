<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityAmenities extends Model
{
    use HasFactory;
    protected $table = 'communityamenity';
    protected $guarded = [];
    protected $casts = [
        'AddedOn' => 'datetime',
    ];
    public $timestamps = false;

    public function propertyinfo(){
        return $this->hasMany(PropertyInfo::class,'CommunityFeatures','id');
    }
}
