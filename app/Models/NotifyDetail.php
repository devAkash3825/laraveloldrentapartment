<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id';
    protected $table = "notifydetails";
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'send_time' => 'datetime',
        'respond_time' => 'datetime',
        'notified_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    public function propertyinfo(){
        return $this->belongsTo(PropertyInfo::class,'property_id','Id');
    }

    public function renterinfo(){
        return $this->belongsTo(RenterInfo::class,'renter_id','Login_ID');
    }

    public function loginrenter(){
        return $this->belongsTo(Login::class,'renter_id','Id');
    }

    public function messageThread()
    {
        return Message::where('propertyId', $this->property_id)
            ->where('renterId', $this->renter_id)
            ->first();
    }

    public function getConversationAttribute()
    {
        $thread = $this->messageThread();
        return $thread ? $thread->conversation : collect();
    }

    public function unreadCount($userId, $userType)
    {
        $thread = $this->messageThread();
        return $thread ? $thread->unreadCount($userId, $userType) : 0;
    }

    public function getNotifyManagerAttribute()
    {
        return 1; // It is a referral by definition
    }

    public function agent(){
        return $this->belongsTo(AdminDetail::class,'agent_id','id');
    }

    public function notes()
    {
        return $this->hasMany(NoteDetail::class, 'referral_id', 'notification_id');
    }

    public function scopeForManager($query, $managerId) {
        return $query->whereHas('propertyinfo', function($q) use ($managerId) {
            $q->where('UserId', $managerId);
        });
    }
}
