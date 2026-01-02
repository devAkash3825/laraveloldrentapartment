<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdminDetail;

class AdminAccess extends Model
{
    use HasFactory;
    protected $table = 'admin_access';
    protected $guarded = [];

    public $timestamps = false;

    public function detail()
    {
        return $this->belongsTo(AdminDetail::class, 'admin_detail_id', 'id');
    }

    public function city(){
        return $this->belongsTo(City::class,'admin_city_id','Id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'admin_state_id', 'Id');
    }
}
