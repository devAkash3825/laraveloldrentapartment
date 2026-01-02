<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $table = 'favorite';
    protected $guarded = [];
    protected $casts = [
        'AddedOn' => 'datetime',
    ];
    public $timestamps = false;
    
    public function propertyinfo()
    {
        return $this->belongsTo(PropertyInfo::class,'PropertyId','Id');
    }
    public function login()
    {
        return $this->belongsTo(Login::class);
    }
    public function getFormattedAddedOnAttribute()
    {
        return $this->AddedOn->format('Y-m-d');
    }

    public function city(){
        return $this->belongsTo(City::class,'PropertyId','Id');
    }

    


    
}
