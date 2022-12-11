<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AddressService
{
    private function getData($jsonFile)
    {
        return collect(
            json_decode(Storage::disk('local')->get("philippine-addresses/$jsonFile.json"))
        );
    }

    public function getRegions()
    {
        return Cache::rememberForever("address:regions", function () {
            return $this->getData("region");
        });
    }

    public function getProvinces($region)
    {
        return Cache::rememberForever("address:provinces:$region", function () use ($region) {
            $provinces = $this->getData("province")->groupBy("region_code");
            $code = $this->getRegionCode($region);
            return $provinces->get($code);
        });
    }

    public function getCities($region, $province)
    {
        return Cache::rememberForever("address:cities:$region,$province", function () use ($region, $province) {
            $province_code = $this->getProvinceCode($region, $province);
            $cities = $this->getData("city")->groupBy(("province_code"));
            return $cities->get($province_code);
        });
    }

    public function getBarangays($region, $province, $city)
    {
        return Cache::rememberForever("address:barangays:$region,$province,$city", function () use ($region, $province, $city) {
            $city_code = $this->getCityCode($region, $province, $city);
            $barangays = $this->getData("barangay")->groupBy("city_code");
            return $barangays->get($city_code);
        });
    }

    private function getRegionCode($region_name)
    {
        $regions = $this->getRegions()?->keyBy("region_name");
        return $regions?->get($region_name)?->region_code;
    }


    private function getProvinceCode($region_name, $province_name)
    {
        $provinces = $this->getProvinces($region_name)?->keyBy("province_name");
        return $provinces?->get($province_name)?->province_code;
    }

    private function getCityCode($region_name, $province_name, $city_name)
    {
        $cities = $this->getCities($region_name, $province_name)?->keyBy("city_name");
        return $cities?->get($city_name)?->city_code;
    }
}
