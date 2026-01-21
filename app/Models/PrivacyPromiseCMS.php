<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPromiseCMS extends Model
{
    use HasFactory;
    
    protected $table = 'privacy_promise_cms';
    protected $guarded = [];
    public $timestamps = true;
}
