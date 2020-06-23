<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $guarded = [];

    public function getLogoUrlAttribute(): string
    {
        return asset('logos/' . $this->logo);
    }

    public function employees(): hasMany
    {
        return $this->hasMany(Employee::class);
    }
}
