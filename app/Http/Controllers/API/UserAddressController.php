<?php

namespace App\Http\Controllers\API;

use App\Area;
use App\Client;
use App\UserAddress;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddressRequest;

use App\Http\Resources\UserAddressResource;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    public function index()
    {
        $userAddresses = UserAddress::with('area')->where('client_id', Auth::login()->typeable_id)->get();
        return UserAddressResource::collection($userAddresses);
    }

    public function show(UserAddress $useraddress)
    {

        return new UserAddressResource($useraddress);
    }

    

    public function update(UserAddressRequest $request)
    {
       
        $address = UserAddress::find($request->useraddress);
        $request = $request->only([
            'area_id', 'street_name', 'build_no',
            'floor_no', 'flat_no', 'is_main', 'useraddress'
        ]);
        $address->update([
            'area_id' => $request['area_id'],
            'street_name' => $request['street_name'],
            'build_no' => $request['build_no'],
            'floor_no' => $request['floor_no'],
            'flat_no' => $request['flat_no'],
            'is_main' => $request['is_main'],
            

        ]);
        return response()->json('updated');
    }

    public function store(UserAddressRequest $request)
    {

        $user = Auth::user();

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
            'client_id' => $user->typeable_id,
        ]);
        return response()->json('added succesful');
    }

    public function destroy(UserAddress $useraddress)
    {

        $useraddress->delete();
        return response()->json('deleted succesful');
    }
}
