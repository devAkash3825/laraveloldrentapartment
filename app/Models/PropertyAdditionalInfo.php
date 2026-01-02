<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class propertyAdditionalInfo extends Model
{
    use HasFactory;
    protected $table = 'propertyadditionalinfo';

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'ModifiedOn' => 'datetime',
    ];


    public function propertyinfo()
    {
        return $this->belongsTo(PropertyInfo::class, 'PropertyId', 'Id');
    }
}
