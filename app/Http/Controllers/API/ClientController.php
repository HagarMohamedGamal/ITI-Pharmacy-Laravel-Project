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
            Client::create([
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


        $client = $request->only(['name', 'password', 'national_id', 'avatar', 'birth_day','mobile','gender']);


        Client::where('id', $id)->update($client);
         return response()->json([

        'success' => 'Record update successfully!'

    ]);
    }




    public function destroy($id)
    {


        Client::find($id)->delete($id);


        return response()->json([

            'success' => 'Record deleted successfully!'

        ]);

    }
}






