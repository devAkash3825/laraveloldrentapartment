<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\AdminAccess;

class AdminDetail extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin_details';

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];


    public function getAuthIdentifierName()
    {
        return 'admin_login_id';
    }
    public function accesses()
    {
        return $this->hasMany(AdminAccess::class, 'admin_detail_id', 'id');
    }

    public function renterinfo()
    {
        return $this->hasMany(RenterInfo::class, 'added_by', 'id');
    }

    public function renterUpdateHistories()
    {
        $fetch_history = Login::with(['renterInfo.addedByAdmin'])
            ->where($searchConditions)
            ->orderBy('Id', 'desc')
            ->get();
        return $this->hasMany(RenterUpdateHistory::class, 'admin_id', 'admin_detail_id');
    }

    public static function getAdminNameById($adminId)
    {
        $admin = self::find($adminId);
        return $admin ? $admin->admin_name : 'Unknown Admin';
    }


    public function hasPermission($permissionField)
    {
        return $this->$permissionField === '1';
    }
    // public function hasPermission($permission)
    // {
    //     // return in_array($permission, $this->permissions); // assuming permissions is an array
    //     return in_array($permission, $this->permissions ?? []);
    // }


}