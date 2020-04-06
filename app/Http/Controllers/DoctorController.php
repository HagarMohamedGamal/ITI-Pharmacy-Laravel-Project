<?php

namespace App\Http\Controllers;

use App\User;
use App\Doctor;
use Illuminate\Http\Request;
use App\Http\Requests\DoctorRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDoctorRequest;
use DataTables;
// use Response;

class DoctorController extends Controller
{
    function index()
    {
        // $doctors = Doctor::all();
        return view('doctors.index');
    }
    function indexDataTable()
    {
        if (request()->ajax()) {
            $model = Doctor::with('type')->get();
            return DataTables()::of($model)->toJson();
        }
        // $doctors = Doctor::all();
        // return view('doctors.index', [
        //     "doctors" => $doctors,
        // ]);
    }

    function show($doctorId)
    {
        $doctor = Doctor::find($doctorId);
        $doctor->avatar = Storage::url($doctor->avatar);
        return view('doctors.show', [
            "doctor" => $doctor,
        ]);
    }

    function destroy(Request $request)
    {
        $doctor = Doctor::find($request->doctor);
        User::find($doctor->type->id)->delete();
        $doctor->delete();
        // return Response::json($doctor);
    }

    function create()
    {
        return view('doctors.create');
    }

    function store(StoreDoctorRequest $request)
    {
        $user =User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            
        ]);
        $user= $user->refresh();

        $uploadedFile = $request->file('avatar');
        if($uploadedFile){
            $filename =  time().'_'.$uploadedFile->getClientOriginalName();
            $path = $request->file('avatar')->storeAs("public/avatars", $filename);
            $pathPeices = explode('/', $path);
            array_shift($pathPeices);
            $path = implode('/', $pathPeices);
        }

       $doctor=Doctor::create([

            'national_id' => $request->national_id,
            'avatar' => $uploadedFile ? $path : "",
            'pharmacy_name' => $request->pharmacy_name,
            'is_baned' => $request->is_baned
        ]);
        $doctor = $doctor->refresh();

        $doctor->type()->save($user);
        $user->assignRole('doctor');
        return redirect()->route('doctors.index');
    }

    function edit($doctorId)
    {
        return view('doctors.create', [
            "doctor" => Doctor::find($doctorId)
        ]);
    }

    function update(Request $request)
    {
        if (request()->ajax()) {
            $doctor = Doctor::find($request->doctor);
            if ($doctor->isBanned()) {
                $doctor->unban();
            } else {
                $doctor->ban();
            }
            return response()->json([
                'is_baned' => $doctor->isBanned(),
            ]);
        }
        Doctor::find($request->doctor)->update(
            [
                'national_id' => $request->national_id,
                'avatar' => isset($request->avatar) ? $request->avatar : "",
                'pharmacy_name' => $request->pharmacy_name,
                'is_baned' => $request->is_baned
            ]
        );
        return redirect()->route('doctors.index');
    }
}
