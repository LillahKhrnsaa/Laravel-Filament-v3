<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'preview',
        'content',
        'category_id',
        'published_at',
        'is_published',
        'thumbnail',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tags::class,
            'post_tag',
            'post_id',
            'tag_id'
        )->withTimestamps();
    }

    public function seoMetaKeywords(): BelongsToMany
    {
        return $this->belongsToMany(
            SeoMetaKeyword::class,
            'post_seo_meta', // Nama pivot table
            'post_id',       // FK untuk Post di pivot
            'seo_meta_id'    // FK untuk SeoMetaKeyword di pivot
        )->withTimestamps(); // Opsional: jika pivot pakai timestamps
    }
}
