<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPageSection extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function page()
    {
        return $this->belongsTo(CmsPage::class, 'cms_page_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}
