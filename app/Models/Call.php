<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;
    protected $table = 'calls';
    
    public function property()
    {
        return $this->belongsTo(PropertyInfo::class, 'property_id');
    }

    public function caller()
    {
        return $this->belongsTo(Login::class, 'caller_id');
    }
}
