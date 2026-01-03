<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Login extends Authenticatable
{

    use Notifiable;

    use HasFactory;
    protected $table = 'login';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $guarded = [];


    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function renterinfo()
    {
        return $this->hasOne(RenterInfo::class, 'Login_ID', 'Id');
    }


    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getFormattedCreatedOnAttribute()
    {
        return $this->CreatedOn ? $this->CreatedOn->format('Y-m-d') : null;
    }
    public function getFormattedModifiedOnAttribute()
    {
        return $this->ModifiedOn->format('Y-m-d');
    }

    public function propertyInfo()
    {
        return $this->hasMany(PropertyInfo::class, 'UserId', 'Id');
    }
    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];

    public function calls()
    {
        return $this->hasMany(Call::class, 'caller_id');
    }

    public function messagerenter()
    {
        return $this->hasMany(Message::class, 'renterId', 'Id');
    }

    public function messagemanager()
    {
        return $this->hasMany(Message::class, 'managerId', 'Id');
    }

    public function getProfilePicUrlAttribute()
    {
        return $this->profile_pic ? asset('uploads/profile_pics/' . $this->profile_pic) : asset('img/avatar-of-aavtarimg.jpg');
    }



}
