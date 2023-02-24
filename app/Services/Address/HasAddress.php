<?php

namespace App\Services\Address;

use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasAddress
{
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
