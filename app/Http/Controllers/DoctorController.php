<?php

namespace App\Http\Controllers;

use App\User;
use App\Doctor;
use DataTables;
use App\Pharmacy;
use Illuminate\Http\Request;
use App\Http\Requests\DoctorRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use Spatie\Permission\Models\Role;
// use Response;

class DoctorController extends Controller
{
    function index()
    {
        if(request()->ajax()){
            return $this->indexDataTable();
        }
        return view('doctors.index');
    }

    function show($doctorId)
    {
        $doctor = Doctor::find($doctorId);
        $this->authorize('view', $doctor);
        if($doctor->avatar)
            $doctor->avatar = Storage::url($doctor->avatar);
        return view('doctors.show', [
            "doctor" => $doctor,
        ]);
    }

    function destroy(Request $request)
    {
        $doctor = Doctor::find($request->doctor);
        $this->authorize('delete', $doctor);
        User::find($doctor->type->id)->delete();
        $doctor->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    function create()
    {
        $pharmacies = Pharmacy::all();
        return view('doctors.create', [
            "pharmacies" => $pharmacies,
        ]);
    }

    function store(StoreDoctorRequest $request)
    {
        $uploadedFile = $request->file('avatar');
        if($uploadedFile){
            $filename =  time().'_'.$uploadedFile->getClientOriginalName();
            $path = $request->file('avatar')->storeAs("public/avatars", $filename);
            $pathPeices = explode('/', $path);
            array_shift($pathPeices);
            $path = implode('/', $pathPeices);
        }

        $authUser = Auth::user();
        if($authUser->hasrole('pharmacy')){
            $request->pharmacy_id = $authUser->typeable->id;
        }

        $user =User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
        ]);
        $user= $user->refresh();

        $doctor=Doctor::create([
            'national_id' => $request->national_id,
            'avatar' => $uploadedFile ? $path : "",
            'pharmacy_id' => $request->pharmacy_id,
            'is_baned' => $request->is_baned
        ]);
        $doctor = $doctor->refresh();

        $pharmacy = Pharmacy::find($request->pharmacy_id);
        $pharmacy->doctors()->save($doctor);

        $doctor->type()->save($user);
        $user->assignRole('doctor');
        return redirect()->route('doctors.index');
    }

    //  Edit Doctor View
    function edit($doctorId)
    {
        $doctor = Doctor::find($doctorId);
        $this->authorize('update', $doctor);
        $pharmacies = Pharmacy::all();
        return view('doctors.create', [
            "doctor" => Doctor::find($doctorId),
            "pharmacies" => $pharmacies,
        ]);
    }

    //  Update Doctor
    function update(Request $request)
    {
        if (request()->ajax()) {
            $doctor = Doctor::find($request->doctor);
            $this->banDoctor($doctor);
            return response()->json([
                'is_baned' => $doctor->isBanned(),
            ]);
        }
        $uploadedFile = $request->file('avatar');
        if($uploadedFile){
            $filename =  time().'_'.$uploadedFile->getClientOriginalName();
            $path = $request->file('avatar')->storeAs("public/avatars", $filename);
            $pathPeices = explode('/', $path);
            array_shift($pathPeices);
            $path = implode('/', $pathPeices);
        }
        $doctor = Doctor::find($request->doctor);
        User::find($doctor->type->id)->update(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request['password']),
            ]
        );
        Doctor::find($request->doctor)->update(
            [
                'national_id' => $request->national_id,
                'avatar' => $uploadedFile ? $path : "",
                'pharmacy_id' => $request->pharmacy_id,
                'is_baned' => $request->is_baned
            ]
        );
        $pharmacy = Pharmacy::find($request->pharmacy_id);
        $pharmacy->doctors()->save($doctor);
        return redirect()->route('doctors.index');
    }

        
    function indexDataTable()
    {
        $user = Auth::user();
        if($user->hasrole('pharmacy')){
            $doctors = Doctor::query()->where('pharmacy_id', $user->typeable->id);
        } else{
            $doctors = Doctor::query();
        }
        $data = DataTables()::of($doctors)
            ->addColumn('id', function(Doctor $doctor){
                return $doctor->id;
            })
            ->addColumn('name', function(Doctor $doctor){
                return $doctor->type->name;
            })
            ->addColumn('email', function(Doctor $doctor){
                return $doctor->type->email;
            })
            ->addColumn('created_at', function(Doctor $doctor){
                return $doctor->type->created_at;
            })
            ->addColumn('action', function(Doctor $doctor){
                $ban = (!$doctor->isBanned())? "btn-dark":"btn-secondary";

                $button = '<a name="show" id="'.$doctor->id.'" style="border-radius: 20px;" class="show btn btn-success btn-sm p-0" href="/doctors/'.$doctor->id.'"><i class="fas fa-eye m-2"></i></a>';
                $button .= '<a name="edit" id="'.$doctor->id.'" style="border-radius: 20px;" class="edit btn btn-primary btn-sm p-0" href="/doctors/'.$doctor->id.'/edit"><i class="fas fa-edit m-2"></i></a>';
                // $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$doctor->id.'" style="border-radius: 20px;" class="delete btn btn-danger btn-sm p-0"><i class="fas fa-trash m-2"></i></button>';
                $button .= '<button type="submit" name="ban" id="'.$doctor->id.'" style="border-radius: 20px;" class="ban btn btn-sm '.$ban.' p-0"><i class="fas fa-ban m-2"></i></button>';
                return $button;
            });

            if(! $user->hasrole('pharmacy')){
                $data->addColumn('pharmacy_id', function(Doctor $doctor){
                    $pharmacy = $doctor->pharmacy;
                    $pharmacy = $pharmacy ? $pharmacy->type->name : "";
                    return $pharmacy;
                });
            }

            return $data->toJson();
    }

    function banDoctor($doctor){
        if ($doctor->isBanned()) {
            $doctor->unban();
        } else {
            $doctor->ban();
        }
    }
}
