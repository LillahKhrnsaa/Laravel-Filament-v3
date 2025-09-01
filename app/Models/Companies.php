<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Companies extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'alias',
        'address',
        'phone',
        'postal_code',
        'logo',
        'status',
    ];

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Companies::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Companies::class, 'parent_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 
        'user_company', 
        'company_id', 
        'user_id')
        ->withTimestamps();
    }

}
