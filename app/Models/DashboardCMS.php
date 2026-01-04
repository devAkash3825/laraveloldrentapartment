<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardCMS extends Model
{
    use HasFactory;

    protected $table = 'dashboard_c_m_s';
    protected $fillable = [
        'renter_title',
        'renter_text',
        'renter_image',
        'manager_title',
        'manager_text',
        'manager_image'
    ];
}
