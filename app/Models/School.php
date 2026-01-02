<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $table = "school_management";
    protected $fillable = ['school_name', 'school_type', 'added', 'modified'];
     // Disable default timestamp management
     public $timestamps = false;

     // Define custom timestamps
     protected $dates = ['added', 'modified'];
}
