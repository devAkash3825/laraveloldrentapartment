<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteDetail extends Model
{
    use HasFactory;
    protected $table = 'notedetails';
    protected $primaryKey = 'note_id';
    public $timestamps = false;
    protected $guarded = [];

    protected $casts = [
        'send_time' => 'datetime',
    ];

    public function property()
    {
        return $this->belongsTo(PropertyInfo::class, 'property_id', 'Id');
    }

    public function user()
    {
        return $this->belongsTo(Login::class, 'user_id', 'Id');
    }
}
