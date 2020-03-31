<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pharmacy;
class PharmacyController extends Controller
{
    public function index()
    {
        $pharmacies = Pharmacy::all();
        return view('pharmacy.index', [
            'pharmacies' => $pharmacies
        ]);
    }


    public function show(Request $request)
    {
        $pharmacy = Pharmacy::find($request->pharmacy);
        return view('pharmacy.show', [
            'pharmacy' => $pharmacy
        ]);
    }


    public function create()
    {
        $pharmacies = Pharmacy::all();
        return view('pharmacy.create', [
            'pharmacies' => $pharmacies
        ]);
    }


    public function store(Request $request)
    {
        $pharmacy = $request->only(['name', 'email', 'national_id', 'area_id', 'avatar', 'priority']);
        $avatar = isset($pharmacy['avatar'])? $pharmacy['avatar'] : "xx.png";
        Pharmacy::create([
            'name' => $pharmacy['name'],
            'email' => $pharmacy['email'],
            'national_id' => $pharmacy['national_id'],
            'area_id' => $pharmacy['area_id'],
            'avatar' => $avatar,
            'priority' => $pharmacy['priority'],
        ]);
        return redirect()->route('pharmacies.index');
    }


    public function edit(Request $request)
    {
        $pharmacies = Pharmacy::all();
        $pharmacy = Pharmacy::find($request->pharmacy);
        return view('pharmacy.edit', [
            'pharmacy' => $pharmacy,
            'pharmacies' => $pharmacies
        ]);
    }


    public function update(Request $request)
    {
        $pharmacyUser = Pharmacy::find($request->pharmacy);
        $pharmacy = $request->only(['name', 'email', 'national_id', 'area_id', 'avatar', 'priority']);
        $avatar = isset($pharmacy['avatar'])? $pharmacy['avatar'] : "xx.png";
        $pharmacyUser->update([
            'name' => $pharmacy['name'],
            'email' => $pharmacy['email'],
            'national_id' => $pharmacy['national_id'],
            'area_id' => $pharmacy['area_id'],
            'avatar' => $avatar,
            'priority' => $pharmacy['priority'],
        ]);
        return redirect()->route('pharmacies.index');
    }
}
