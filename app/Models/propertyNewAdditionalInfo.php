<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class propertyNewAdditionalInfo extends Model
{
    use HasFactory;
    protected $table = 'propertyadditionalinfo';

    protected $fillable = [
        'LeasingTerms',
        'QualifiyingCriteria',
        'Parking',
        'PetPolicy',
        'Neighborhood',
        'Schools',
        'drivedirection',
        'ModifiedOn',
        'PropertyId',
    ];

    public $timestamps = false;

    protected $casts = [
        'ModifiedOn' => 'datetime',
    ];

    public function propertyinfo()
    {
        return $this->belongsTo(PropertyInfo::class, 'PropertyId', 'Id');
    }
}
