<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaseReport extends Model
{
    use HasFactory;

    protected $table = 'lease_reports';
    protected $guarded = [];

    public function renter()
    {
        return $this->belongsTo(Login::class, 'renter_id', 'Id');
    }
}
