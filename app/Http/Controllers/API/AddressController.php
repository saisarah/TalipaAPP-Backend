<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AddressController extends Controller
{
    private $address;

    public function __construct(AddressService $address)
    {
        $this->address = $address;
    }

    public function regions()
    {
        return $this->address->getRegions();
    }

    public function provinces(Request $request)
    {
        $region = $request->region;
        return $this->address->getProvinces($region);
    }

    public function cities(Request $request)
    {
        $province = $request->province;
        $region = $request->region;
        return $this->address->getCities($region, $province);
    }

    public function barangays(Request $request)
    {
        $province = $request->province;
        $region = $request->region;
        $city = $request->city;
        return $this->address->getBarangays($region, $province, $city);
    }
}
