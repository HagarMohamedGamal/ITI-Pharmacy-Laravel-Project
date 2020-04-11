<?php

namespace App\Http\Controllers;

use App\User;
use App\Doctor;
use App\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDoctorRequest;

class DoctorController extends Controller
{
    function index()
    {
        if(request()->ajax()){
            return $this->indexDataTable();
        }
        return view('doctors.index');
    }

    function show(Doctor $doctor)
    {
       
        $this->authorize('view', $doctor);
        if($doctor->avatar)
            $doctor->avatar = Storage::url($doctor->avatar);
        return view('doctors.show', [
            "doctor" => $doctor,
        ]);
    }

    function destroy(Doctor $doctor)
    {
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
        $user = $request->only(['name', 'email', 'password']);
        $user['password'] = Hash::make($request['password']);
        $doctor = $request->only(['national_id', 'pharmacy_id', 'avatar', 'is_baned']);
        $avatar = $request->file('avatar');
        if($avatar){
            $doctor['avatar'] = 'images/'.time() . '_' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('storage/images'), $doctor['avatar']);
        }
        else
        {
            $doctor['avatar'] = "default.jpg";
        }
        $authUser = Auth::user();
        if($authUser->hasrole('pharmacy')){
            $doctor['pharmacy_id'] = $authUser->typeable->id;
        }
        $user = User::create($user)->refresh();
        $doctorNew=Doctor::create($doctor);
        $doctorNew->refresh();
        $doctorNew->type()->save($user);
        $pharmacy = Pharmacy::find($doctor['pharmacy_id']);
        $pharmacy->doctors()->save($doctorNew);
        $user->assignRole('doctor');
        return redirect()->route('doctors.index');
    }

    //  Edit Doctor View
    function edit(Doctor $doctor)
    {
        $this->authorize('update', $doctor);
        return view('doctors.create', [
            "doctor" => $doctor,
            "pharmacies" => Pharmacy::all(),
        ]);
    }

    //  Update Doctor
    function update(Request $request, $doctorId)
    {
        $user = $request->only(['name', 'email', 'password']);
        $user['password'] = Hash::make($request['password']);
        $doctor = $request->only(['national_id', 'pharmacy_id', 'avatar', 'is_baned']);
        $avatar = $request->file('avatar');

        if($avatar){
            $doctor['avatar'] = 'images/'.time() . '_' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('storage/images'), $doctor['avatar']);
        }
        else
        {
            $doctor['avatar'] = "default.jpg";
        }
        $doctorData = Doctor::find($doctorId);
        User::find($doctorData->type->id)->update($user);
        $doctorData->update($doctor);
        Pharmacy::find($doctor['pharmacy_id'])
        ->doctors()->save($doctorData);
        return redirect()->route('doctors.index');
    }

    function updateajax(Doctor $doctor){
        if (request()->ajax()) {
            
            $this->banDoctor($doctor);
            return response()->json([
                'is_baned' => $doctor->isBanned(),
            ]);
        }
    }
        
    function indexDataTable()
    {
        $user = Auth::user();
        if($user->hasrole('pharmacy')){
            $doctors = Doctor::with(['type'])->where('pharmacy_id', $user->typeable->id)->get();
        } else{
            $doctors = Doctor::with(['type'])->get();
        }
        $data = DataTables()::of($doctors)
            ->addColumn('action', function(Doctor $doctor){
                $ban = (!$doctor->isBanned())? "btn-dark":"btn-secondary";
                $button = '<a name="show" id="'.$doctor->id.'" style="border-radius: 20px;" class="show btn btn-success btn-sm p-0" href="/doctors/'.$doctor->id.'"><i class="fas fa-eye m-2"></i></a>';
                $button .= '<a name="edit" id="'.$doctor->id.'" style="border-radius: 20px;" class="edit btn btn-primary btn-sm p-0" href="/doctors/'.$doctor->id.'/edit"><i class="fas fa-edit m-2"></i></a>';
                $button .= '<button type="button" name="delete" id="'.$doctor->id.'" style="border-radius: 20px;" class="delete btn btn-danger btn-sm p-0"><i class="fas fa-trash m-2"></i></button>';
                $button .= '<button type="button" name="ban" id="'.$doctor->id.'" style="border-radius: 20px;" class="ban btn btn-sm '.$ban.' p-0"><i class="fas fa-ban m-2"></i></button>';
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

    function banDoctor(Doctor $doctor){
        if ($doctor->isBanned()) {
            $doctor->unban();
        } else {
            $doctor->ban();
        }
    }
}
