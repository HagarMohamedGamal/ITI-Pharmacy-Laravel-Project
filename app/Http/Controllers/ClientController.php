<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequestWeb;

class ClientController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
        if (request()->ajax()) {
            return $this->indexDataTable();
        }
        return view('clients.index');
    }

    public function show($clientId)
    {
        $client = Client::find($clientId);
        $this->authorize('view', $client);
        if($client->avatar)
            $client->avatar = Storage::url($client->avatar);
        return view('clients.show', [
            "client" => $client,
        ]);
    }

    public function create(Request $request)
    {
        return view('clients.create');
    }

    public function store(StoreClientRequest $request)
    {
        $client = $request->only(['name', 'email', 'password', 'national_id', 'avatar', 'gender', 'birth_day', 'mobile']);
        $avatar = isset($client['avatar']) ? $client['avatar'] : "";
        if ($avatar) {
            $new_name = time() . '_' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images'), $new_name);
        } else {
            $new_name = "default.jpg";
        }

        $user = User::create([
            'name' => $client['name'],
            'email' => $client['email'],
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
        $clientUser = $clientUser->refresh();

        $clientUser->type()->save($user);
        $user->assignRole('client');
        return redirect()->route('clients.index');
    }

    function edit($clientId)
    {
        $client = Client::find($clientId);
        return view('clients.create', [
            "client" => Client::find($clientId),
        ]);
    }

    public function update(UpdateClientRequestWeb $request, $client)
    {
        $client = $request->only(['name', 'email', 'national_id', 'avatar', 'gender', 'birth_day', 'mobile']);
        // dd($client);
        $avatar = isset($client['avatar']) ? $client['avatar'] : "";
        if ($avatar) {
            $new_name = time() . '_' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images'), $new_name);
        } else {
            $new_name = "default.jpg";
        }

        $updateclient = Client::find($request->client);
        $user = User::find($updateclient->type->id);
        $user->update([
            'name' => $client['name'],
            'email' => $client['email'],
        ]);
        $updateclient->update([
            'national_id' => $client['national_id'],
            'avatar' => $new_name,
            'gender' => $client['gender'],
            'birth_day' => $client['birth_day'],
            'mobile' => $client['mobile'],
        ]);
        return redirect()->route('clients.index');
    }

    public function destroy($client)
    {
        $client = Client::find($client);
        if ($client) {
            User::find($client->type->id)->delete();
            $client->delete();
            return response()->json([
                'success' => 'Client deleted successfully!'
            ]);
        } else {
            return response()->json([
                'error' => 'there is no such id!'
            ]);
        }
    }


    function indexDataTable()
    {
        $user = Auth::user();
        $clients = Client::query();
        $data = DataTables()::of($clients)
            ->addColumn('id', function (Client $client) {
                return $client->id;
            })
            ->addColumn('name', function (Client $client) {
                return $client->type->name;
            })
            ->addColumn('email', function (Client $client) {
                return $client->type->email;
            })
            ->addColumn('created_at', function (Client $client) {
                return $client->type->created_at;
            })
            ->addColumn('action', function (Client $client) {
                $button = '<a name="show" id="' . $client->id . '" style="border-radius: 20px;" class="show btn btn-success btn-sm p-0" href="/clients/' . $client->id . '"><i class="fas fa-eye m-2"></i></a>';
                $button .= '<a name="edit" id="' . $client->id . '" style="border-radius: 20px;" class="edit btn btn-primary btn-sm p-0" href="/clients/' . $client->id . '/edit"><i class="fas fa-edit m-2"></i></a>';
                // $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $client->id . '" style="border-radius: 20px;" class="delete btn btn-danger btn-sm p-0"><i class="fas fa-trash m-2"></i></button>';
                return $button;
            });

        return $data->toJson();
    }
}
