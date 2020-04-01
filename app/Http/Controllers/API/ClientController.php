<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreClientRequest;

class ClientController extends Controller
{
    public function index()
    {
        return ClientResource::collection(
            Client::all()
        );
    }

    public function show($client)
    {
        return new ClientResource(
            Client::find($client)
        );
    }


    public function store(StoreClientRequest $request)
    {
        return new ClientResource(
            client::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'avatar' => $request->avatar,
                'national_id' => $request->national_id,
                'avatar' => $request->avatar,
                'gender' => $request->gender,
                'birth_day' => $request->birth_day,
                'mobile' => $request->mobile,


            ])
        );
    }


    public function edit($id)
    {
        $where = array('id' => $id);

        $data['client'] = Client::where($where)->first();

        return $data;
    }


    public function update(Request $request, $id)
    {
        $update = ['name' => $request->name, 'password' => $request->password, 'national_id' => $request->national_id, 'avatar' => $request->avatar, 'birth_day' => $request->birth_day, 'mobile' => $request->mobile];
        Client::where('id', $id)->update($update);


        
    }




    public function destroy($id)
    {


        Client::find($id)->delete($id);


        return response()->json([

            'success' => 'Record deleted successfully!'

        ]);

    }
}






