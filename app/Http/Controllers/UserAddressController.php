<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Requests\UserAddressRequest;
use App\UserAddress;

class UserAddressController extends Controller
{
    public function index()
    {
        $userAddresses = UserAddress::all();
        return $userAddresses;
    }

    public function show()
    {
        $request = request();
        $addressid = $request->useraddress;
        $address = UserAddress::find($addressid);
        return $address;
    }

    public function edit()
    {
        $request = request();
        $addressid = $request->useraddress;
        $address = UserAddress::find($addressid);
    }

    public function update(UserAddressRequest $request)
    {
        $addressid = $request->useraddress;
        $address = UserAddress::find($addressid);
        $address::update([
            'area_id' => $request['area_id'],
            'street_name' => $request['street_name'],
            'build_no' => $request['build_no'],
            'floor_no' => $request['floor_no'],
            'flat_no' => $request['flat_no'],
            'is_main' => $request['is_main'],

        ]);
    }

    public function store(UserAddressRequest $request)
    {
        $request = $request->only([
            'area_id', 'street_name', 'build_no',
            'floor_no', 'flat_no', 'is_main'
        ]);

        UserAddress::create([
            'area_id' => $request['area_id'],
            'street_name' => $request['street_name'],
            'build_no' => $request['build_no'],
            'floor_no' => $request['floor_no'],
            'flat_no' => $request['flat_no'],
            'is_main' => $request['is_main'],

        ]);
    }

    public function destroy()
    {
        $request = request();
        $addressid = $request->useraddress;
        UserAddress::destroy($addressid);
    }

    public function create()
    {
        $areas = Area::all();
        return view('userAddresses.create', [
            'areas' => $areas
        ]);
    }
}
