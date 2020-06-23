<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    public function getLogoUrlAttribute(): string
    {
        return asset('logos/' . $this->logo);
    }
}
