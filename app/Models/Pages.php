<?php

namespace App\Models;

use App\Models\Widgets;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'pages';
    protected $fillable = [
        'title', 
        'content', 
        'slug', 
        'status',
        'meta_title',
        'meta_description',
        'featured_image',
        'template_id'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function widgets()
    {
        return $this->hasMany(Widgets::class, 'page_id');
    }

    public function template()
    {
        return $this->belongsTo(TemplatePages::class, 'template_id');
    }
}
