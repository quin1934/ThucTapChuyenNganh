<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsBlock extends Model
{
    use HasFactory;

    protected $table = 'cms_blocks';

    protected $fillable = [
        'page_id',
        'type',
        'title',
        'subtitle',
        'content',
        'image_path',
        'cta_text',
        'cta_url',
        'sort_order',
        'is_active',
        'start_at',
        'end_at',
        'created_by',
        'updated_by'
    ];

    public function page()
    {
        return $this->belongsTo(CmsPage::class, 'page_id');
    }
    
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('is_active', true)
                     ->where(function($q) use ($now) {
                         $q->whereNull('start_at')->orWhere('start_at', '<=', $now);
                     })
                     ->where(function($q) use ($now) {
                         $q->whereNull('end_at')->orWhere('end_at', '>=', $now);
                     })
                     ->orderBy('sort_order', 'asc');
    }
}