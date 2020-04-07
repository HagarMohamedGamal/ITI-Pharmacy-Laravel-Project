<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Support\Facades\Hash;

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

        $client = $request->only(['name', 'email','password' ,'national_id', 'avatar', 'gender', 'birth_day', 'mobile']);
        $avatar = isset($client['avatar'])? $client['avatar'] : "";
        if ($avatar) 
        {
            $new_name = time() . '_' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images'), $new_name);
        }
        else
        {
            $new_name = "default.jpg";
        }
       
        $user = User::create([
            'name'=> $client['name'],
            'email'=> $client['email'],
            'password' => Hash::make($client['password']),

        ]);
        $clientUser = Client::create([
            'national_id' => $client['national_id'],
            'avatar' => $client['avatar'],
            'gender' => $client['gender'],
            'birth_day' => $client['birth_day'],
            'mobile' => $client['mobile'],
        ]);

        $user = $user->refresh();
        $clientUser=$clientUser->refresh();

        $clientUser->type()->save($user);
        $user->assignRole('client');

        return new ClientResource($clientUser);
    }


    public function update(UpdateClientRequest $request)
    {
        $client = $request->only(['name', 'email' ,'national_id', 'avatar', 'gender', 'birth_day', 'mobile']);
        $avatar = isset($client['avatar'])? $client['avatar'] : "";
        if ($avatar) 
        {
            $new_name = time() . '_' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images'), $new_name);
        }
        else
        {
            $new_name = "default.jpg";
        }
       
       $updateclient = Client::find($request->client);
        User::find($updateclient->type->id)->update([
            'name'=> $client['name'],
            'email'=> $client['email'],

        ]);
        $updateclient->update([
            'national_id' => $client['national_id'],
            'avatar' => $client['avatar'],
            'gender' => $client['gender'],
            'birth_day' => $client['birth_day'],
            'mobile' => $client['mobile'],
        ]);

        
        return new ClientResource($updateclient);
    }





    public function destroy($client)
    {


        Client::find($id)->delete($id);


        return response()->json([

            'success' => 'Record deleted successfully!'

        ]);

    }
}






