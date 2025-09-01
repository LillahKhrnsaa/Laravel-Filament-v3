<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tags extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'slug',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Posts::class,      
            'post_tag',       
            'tag_id',         
            'post_id'         
        )->withTimestamps();  
    }
}
