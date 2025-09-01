<?php

namespace App\Models;

use App\Models\Pages;
use Illuminate\Database\Eloquent\Model;

class Widgets extends Model
{
    protected $table = 'widgets';
    protected $fillable = [
        'page_id',
        'name', 
        'type_id',
        'order',
        'settings',   // 👈 tambahkan ini
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function type()
    {
        return $this->belongsTo(TypeWidgets::class, 'type_id');
    }
    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id');
    }
}
