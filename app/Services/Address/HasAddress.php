<?php

namespace App\Services\Address;

use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasAddress
{
    public function address(): HasOne
    {
        $foreign_key = $this->addressKey ?? $this->primaryKey ?? 'id';
        return $this->hasOne(Address::class, 'user_id', $foreign_key);
    }

    public function shortAddress()
    {
        $address = $this->address;
        if (!$address) return "";

        return sprintf(
            "%s %s, %s, %s",
            $address->house_number,
            $address->street,
            $address->barangay,
            $address->municipality,
        );        
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

    public function transportifyAddress()
    {
        $address = $this->address;
        if (!$address) return "";

        return sprintf(
            "%s, %s, %s",
            $address->barangay,
            $address->municipality,
            $address->province
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
