<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Address\Address;
use App\Services\Address\AddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function index()
    {
        $user = Auth::user();
        $address = Address::select(
            'region',
            'province',
            'municipality',
            'barangay',
            'street',
            'house_number'
        )
            ->where('user_id', $user->id)
            ->first();
        return $address;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'newRegion' => 'required',
            'newProvince' => 'required',
            'newMunicipality' => 'required',
            'newBarangay' => 'required',
            'newStreet' => 'required',
            'newHouseNumber' => 'required',
        ]);
        $newRegion = $request->newRegion;
        $newProvince = $request->newProvince;
        $newMunicipality = $request->newMunicipality;
        $newBarangay = $request->newBarangay;
        $newStreet = $request->newStreet;
        $newHouseNumber = $request->newHouseNumber;

       
    }
}
