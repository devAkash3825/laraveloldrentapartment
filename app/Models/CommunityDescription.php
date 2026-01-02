<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityDescription extends Model
{
    use HasFactory;
    protected $table = 'communitydescription';

    public $timestamps = false;
    protected $guarded = [];

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];


    public function propertyinfo(){
        return $this->belongsTo(PropertyInfo::class,'PropertyId','Id');
    }
}
