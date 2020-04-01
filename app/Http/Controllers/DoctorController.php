<?php

namespace App\Http\Controllers;

use App\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    function index(){
        $doctors = Doctor::all();
        return view('doctors.index', [
                "doctors" => $doctors,
            ]);
    }

    function show($doctorId){
        $doctor = Doctor::find($doctorId);
        return view('doctors.show', [
                "doctor" => $doctor,
            ]);
    }

    function destroy(Request $request){
        // dd($request);
        Doctor::find($request->doctor)->delete();
        // return response()->json([
        //     'success' => 'Record deleted successfully!'
        // ]);
    }

    function create(){
        return view('doctors.create');
    }

    function store(){
        $request = request();
        // dd($request->name);
        // $input = $request->only(['name', 'email', 'is_baned']);
        Doctor::create(
            [
                'name' => $request->name,
                'email' => $request->email, 
                'password' => "", 
                'national_id' => "", 
                'avatar' => "", 
                'pharmacy_name' => "", 
                'is_baned' => $request->is_baned
            ]
        );
        return redirect()->route('doctors.index');
    }

    function edit($doctorId){
        return view('doctors.create', [
            "doctor" => Doctor::find($doctorId)
        ]);
    }

    function update(Request $request){
        Doctor::find($request->doctor)->update(
            [
                'name' => $request->name,
                'email' => $request->email, 
                'password' => "", 
                'national_id' => "", 
                'avatar' => "", 
                'pharmacy_name' => "", 
                'is_baned' => $request->is_baned
            ]
        );
        return redirect()->route('doctors.index');
    }


    
}
