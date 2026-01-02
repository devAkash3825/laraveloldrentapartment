<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyInquiry extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'propertyinquiry';  
    public $timestamps = false;
    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];
    
    public function propertyinfo(){
        return $this->belongsTo(PropertyInfo::class,'PropertyId','Id');
    }
}
