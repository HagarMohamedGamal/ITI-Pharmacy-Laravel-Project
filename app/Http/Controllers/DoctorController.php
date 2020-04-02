<?php

namespace App\Http\Controllers;

use App\Doctor;
use Illuminate\Http\Request;

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
        Doctor::find($request->doctor)->delete();
    }

    function create(){
        return view('doctors.create');
    }

    function store(){
        $request = request();
        Doctor::create(
            [
                'name' => $request->name,
                'email' => $request->email, 
                'national_id' => $request->national_id, 
                'avatar' => $request->avatar, 
                'pharmacy_name' => $request->pharmacy_name, 
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
                'national_id' => $request->national_id, 
                'avatar' => isset($request->avatar)?$request->avatar:"", 
                'pharmacy_name' => $request->pharmacy_name, 
                'is_baned' => $request->is_baned
            ]
        );
        return redirect()->route('doctors.index');
    }


    
}
