<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenterUpdateHistory extends Model
{
    use HasFactory;
    protected $table = 'renter_update_history';

    public function renterInfo()
    {
        return $this->belongsTo(RenterInfo::class, 'user_id', 'Login_ID');
    }

    public function adminDetail()
    {
        return $this->belongsTo(AdminDetail::class, 'admin_id', 'id');
    }

}
