<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUsCMS extends Model
{
    use HasFactory;
    protected $table = 'contactus';
    public $timestamps = false;
    protected $guarded = [];
    
    protected $casts = [
        'CreatedOn' => 'datetime',
        'ModifiedOn' => 'datetime',
    ];

}
