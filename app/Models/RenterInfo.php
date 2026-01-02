<?php

namespace App\Models;

use App\Models\Login;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenterInfo extends Model
{
    use HasFactory;
    protected $table   = 'renter_info';
    protected $guarded = [];
    public $timestamps = false;
    
    protected $dates = ['Emove_date', 'Lmove_date', 'Reminder_date'];

    public function login()
    {
        return $this->belongsTo(Login::class, 'Login_ID', 'Id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'Cityid', 'Id');
    }

    public function renterInfoUpdates()
    {
        return $this->hasMany(RenterInfoUpdate::class, 'user_id', 'Login_ID');
    }

    public function admindetails()
    {
        return $this->belongsTo(AdminDetail::class, 'added_by', 'id');
    }


    public function getFormattedEmoveDateAttribute()
    {
        return $this->Emove_date->format('Y-m-d');
    }
    public function getFormattedLmoveDateAttribute()
    {
        return $this->Lmove_date->format('Y-m-d');
    }
    protected $casts = [
        'Emove_date' => 'datetime',
        'Lmove_date' => 'datetime',
    ];

    public function renterUpdateHistories()
    {
        return $this->hasMany(RenterUpdateHistory::class, 'user_id', 'Login_ID');
    }


    public function addedByAdmin()
    {
        return $this->belongsTo(AdminDetail::class, 'added_by', 'admin_detail_id');
    }

    public function notifydetails()
    {
        return $this->hasMany(NotifyDetail::class, 'renter_id', 'Login_ID');
    }

    public function getAllReminder(array $cityIds = [], $option = '', $agentId = null)
    {
        $query = RenterInfo::query();
        
        if (! empty($agentId)) {
            $query->where('added_by', $agentId);
        }
        
        if (! empty($cityIds)) {
            $query->whereIn('CityId', $cityIds);
        }
        
        if (! empty($option) && is_array($option)) {
            $query->whereBetween('Reminder_date', [$option['reminderfrom'], $option['reminderto']]);
        } elseif ($option === 'all') {
            // No Reminder_date condition
        } else {
            // Default: only past due or today's reminders
            $query->whereRaw('DATEDIFF(Reminder_date, NOW()) <= 0');
        }

        // Order by reminder date
        return $query
            ->select([
                'CityId',
                'Login_Id',
                'Firstname',
                'Lastname',
                'Reminder_date',
                'added_by',
                'bedroom',
                'Rent_start_range',
                'Rent_end_range',
                'Emove_date',
                'Area_move',
                'probability',
            ])
            ->orderBy('Reminder_date')
            ->get();
    }

} 
