<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplatePages extends Model
{
    protected $table = 'template_pages';
    protected $fillable = [
        'title', 
        'description', 
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function pages()
    {
        return $this->hasMany(Pages::class, 'template_id');
    }
}
