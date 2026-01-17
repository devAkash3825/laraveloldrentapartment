<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenterInfoHistory extends Model
{
    use HasFactory;

    protected $table = 'renter_info_history';

    protected $fillable = [
        'renter_info_id',
        'admin_id',
        'snapshot',
    ];

    protected $casts = [
        'snapshot' => 'json',
    ];

    public function renterInfo()
    {
        return $this->belongsTo(RenterInfo::class, 'renter_info_id', 'Id');
    }

    public function admin()
    {
        return $this->belongsTo(AdminDetail::class, 'admin_id', 'id');
    }
}
