<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProperty extends Model
{
    use HasFactory;
    protected $table = 'userproperty';
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = [
        'lastviewed' => 'datetime',
    ];

    public function propertyinfo(){
        return $this->belongsTo(PropertyInfo::class,'propertyId','Id');
    }
}
