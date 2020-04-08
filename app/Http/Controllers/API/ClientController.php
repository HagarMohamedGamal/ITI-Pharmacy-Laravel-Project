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

use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Validation\ValidationException;
use Auth;

class ClientController extends Controller
{
    use VerifiesEmails;
    public $successStatus = 200;

    public function index()
    {
        return ClientResource::collection(
            Client::all()
        );
    }

    public function show($client)
    {
        $exist = User::where('id', $client);
        if ($exist->count()>0) 
        {
            return new ClientResource(
                Client::find(User::find($client)->typeable->id)
            );
        }
        else
        {
            return response()->json([
                "message" => "client not found"
            ], 404);
        }
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return [
            'Access Tocken' => $user->createToken($request->device_name)->plainTextToken,
            'Data' => new ClientResource(
                Client::find($user->typeable->id)
            )
        ];
    }

    public function register(StoreClientRequest $request)
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
            'avatar' => $new_name,
            'gender' => $client['gender'],
            'birth_day' => $client['birth_day'],
            'mobile' => $client['mobile'],
        ]);

        $user = $user->refresh();
        $clientUser=$clientUser->refresh();

        $clientUser->type()->save($user);
        $user->assignRole('client');

        $user->sendApiEmailVerificationNotification();
        $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
        return response()->json([
            'success' => $success,
            'Data' => new ClientResource($clientUser)
        ], $this->successStatus);
        return new ClientResource($clientUser);
    }


    public function update(UpdateClientRequest $request, $client)
    {
        $exist = User::where('id', $client);
        if ($exist->count()>0) 
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

           $user = User::find($client);
           $updateclient = Client::find($user->typeable->id);
            $user->update([
                'name'=> $client['name'],
                'email'=> $client['email'],

            ]);
            $updateclient->update([
                'national_id' => $client['national_id'],
                'avatar' => $new_name,
                'gender' => $client['gender'],
                'birth_day' => $client['birth_day'],
                'mobile' => $client['mobile'],
            ]);

            return new ClientResource($updateclient);
        }
        else
        {
            return response()->json([
                "message" => "client not found"
            ], 404);
        }

    }





    public function destroy($client)
    {
        User::find($client)->delete($client);
        return response()->json([
            'success' => 'Client deleted successfully!'
        ]);
    }

}






