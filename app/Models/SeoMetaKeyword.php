<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SeoMetaKeyword extends Model
{
    protected $fillable = [
        'meta_title',
        'meta_desc',
        'keyword',
    ];

    public function setKeywordAttribute($value) // <- Ubah ke singular
    {
        $this->attributes['keyword'] = is_array($value) 
            ? implode(',', $value) 
            : preg_replace('/\s*,\s*/', ',', $value ?? '');
    }

    public function getKeywordArrayAttribute() // <- Accessor baru
    {
        return explode(',', $this->keyword ?? '');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Posts::class,
            'post_seo_meta',
            'seo_meta_id',
            'post_id'
        )->withTimestamps();
    }

}
