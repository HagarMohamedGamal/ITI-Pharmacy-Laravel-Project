<?php

namespace App\Http\Controllers;

use App\Area;
use App\Client;
use App\UserAddress;
use Illuminate\Http\Request;
use App\Http\Requests\UserAddressRequest;

class UserAddressController extends Controller
{
    public function index()
    {
        $userAddresses = UserAddress::all();
        return view('userAddresses.index');
    }

    public function show()
    {
        $request = request();
        $addressid = $request->useraddress;
        $address = UserAddress::find($addressid);
        return view('userAddresses.show', [
            'address' => $address
        ]);
    }

    public function edit()
    {
        $request = request();
        $clients = Client::all();
        $areas = Area::all();
        $addressid = $request->useraddress;
        $address = UserAddress::find($addressid);
        return view('userAddresses.edit', [
            'address' => $address,
            'clients' => $clients,
            'areas' => $areas,
        ]);
    }

    public function update(UserAddressRequest $request)
    {
        $addressid = $request->useraddress;
        $address = UserAddress::find($addressid);
        $address->update([
            'area_id' => $request['area_id'],
            'street_name' => $request['street_name'],
            'build_no' => $request['build_no'],
            'floor_no' => $request['floor_no'],
            'flat_no' => $request['flat_no'],
            'is_main' => $request['is_main'],
            'client_id' => $request['client_id'],

        ]);
        return redirect()->route('useraddresses.index');
    }

    public function store(UserAddressRequest $request)
    {
        $request = $request->only([
            'area_id', 'street_name', 'build_no',
            'floor_no', 'flat_no', 'is_main', 'client_id'
        ]);

        UserAddress::create([
            'area_id' => $request['area_id'],
            'street_name' => $request['street_name'],
            'build_no' => $request['build_no'],
            'floor_no' => $request['floor_no'],
            'flat_no' => $request['flat_no'],
            'is_main' => $request['is_main'],
            'client_id' => $request['client_id'],
        ]);
        return redirect()->route('useraddresses.index');
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
        $clients = Client::all();
        return view('userAddresses.create', [
            'areas' => $areas,
            'clients' => $clients
        ]);
    }
}
