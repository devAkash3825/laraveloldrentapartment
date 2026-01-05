<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $guarded = [];

    public function conversation()
    {
        return $this->hasMany(Conversation::class,'messagesId','id');
    }

    public function loginrenter(){
        return $this->belongsTo(Login::class,'renterId','Id');
    }
    public function loginManager(){
        return $this->belongsTo(Login::class,'managerId','Id');
    }

    public function propertyinfo(){
        return $this->belongsTo(PropertyInfo::class,'propertyId','Id');
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function unreadCount($userId, $userType)
    {
        $query = $this->conversation()->where('is_read', false);
        if ($userType == 'R') {
            $query->whereNull('renterId');
        } elseif ($userType == 'M') {
            $query->whereNull('managerId');
        } elseif ($userType == 'A') {
            $query->whereNull('adminId');
        }
        return $query->count();
    }

    protected $dates = ['created_at', 'updated_at'];

    
}
