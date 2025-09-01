<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeWidgets extends Model
{
    protected $table = 'type_widgets';
    protected $fillable = [
        'title', 
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function widgets()
    {
        return $this->hasMany(Widgets::class, 'type_id');
    }
}
