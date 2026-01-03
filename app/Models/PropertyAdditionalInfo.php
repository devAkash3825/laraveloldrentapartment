<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAdditionalInfo extends Model
{
    use HasFactory;
    
    protected $table = 'propertyadditionalinfo';
    public $timestamps = false;

    protected $fillable = [
        'PropertyId',
        'LeasingTerms',
        'QualifiyingCriteria',
        'Parking',
        'PetPolicy',
        'Pets',
        'Neighborhood',
        'Schools',
        'drivedirection',
        'ModifiedOn',
        'Status',
    ];

    protected $casts = [
        'ModifiedOn' => 'datetime',
    ];

    /**
     * Relationship: Belongs to PropertyInfo
     */
    public function propertyinfo()
    {
        return $this->belongsTo(PropertyInfo::class, 'PropertyId', 'Id');
    }

    /**
     * Accessor: Get formatted modified date
     */
    public function getFormattedModifiedOnAttribute()
    {
        return $this->ModifiedOn ? $this->ModifiedOn->format('Y-m-d H:i:s') : null;
    }

    /**
     * Check if additional info exists for property
     */
    public static function existsForProperty($propertyId)
    {
        return self::where('PropertyId', $propertyId)->exists();
    }

    /**
     * Get or create additional info for property
     */
    public static function getOrCreateForProperty($propertyId)
    {
        return self::firstOrCreate(
            ['PropertyId' => $propertyId],
            [
                'ModifiedOn' => now(),
                'Status' => '1'
            ]
        );
    }
}
