<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $guarded = [];

    public function employedBy(Company $company): self
    {
        $this->company()->associate($company);

        return $this;
    }

    public function getFullNameAttribute(): string
    {
        return $this->firstname . ' ' . $this->surname;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);

    }
}
