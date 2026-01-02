<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $table = 'state';
    protected $guarded = [];
    
    public function city(){
        return $this->hasMany(City::class,'StateId');
    }

    public function accesses()
    {
        return $this->hasMany(AdminAccess::class, 'admin_state_id', 'Id');
    }

    public $timestamps = false;


    // public static function getStateNameById($stateId)
    // {
    //     $admin = self::find($stateId);
    //     return $admin ? $admin->admin_name : 'Unknown Admin';
    // }
}
