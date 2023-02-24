<?php

namespace App\Services\Address;

use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasAddress
{
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function completeAddress()
    {
        $address = $this->address;
        if (!$address) return "";

        return sprintf(
            "%s, %s, %s, %s, %s, %s",
            $address->house_number,
            $address->street,
            $address->barangay,
            $address->municipality,
            $address->province,
            $address->region
        );
    }

    public function cityAddress()
    {
        $address = $this->address;
        if (!$address) return "";

        return sprintf(
            "%s, %s, %s",
            $address->municipality,
            $address->province,
            $address->region
        );        
    }
}
