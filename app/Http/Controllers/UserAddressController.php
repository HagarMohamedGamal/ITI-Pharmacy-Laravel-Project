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
        if(request()->ajax()){
            return $this->indexDataTable();
        }
        return view('userAddresses.index');
    }
    function indexDataTable()
    {

            $userAddresses = UserAddress::query();
            return DataTables()::of($userAddresses)
            ->addColumn('action', function(UserAddress $userAddresse){

                $button = '<a name="show" id="'.$userAddresse->id.'" style="border-radius: 20px;" class="show btn btn-success btn-sm p-0" href="/useraddresses/'.$userAddresse->id.'"><i class="fas fa-eye m-2"></i></a>';
                $button .= '<a name="edit" id="'.$userAddresse->id.'" style="border-radius: 20px;" class="edit btn btn-primary btn-sm p-0" href="/useraddresses/'.$userAddresse->id.'/edit"><i class="fas fa-edit m-2"></i></a>';
                $button .= '<button type="button" name="delete" id="'.$userAddresse->id.'" style="border-radius: 20px;" class="delete btn btn-danger btn-sm p-0"><i class="fas fa-trash m-2"></i></button>';
                    return $button;
                
            })
            ->toJson();
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
