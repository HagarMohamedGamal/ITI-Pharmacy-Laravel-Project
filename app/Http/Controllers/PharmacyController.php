<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Pharmacy;
use App\User;
use App\Area;
use Illuminate\Support\Facades\Hash;
class PharmacyController extends Controller
{
    public function index()
    {
        
        $pharmacies = Pharmacy::all();
        $deletedPharmacies = $this->readsoftdelete();
        return view('pharmacy.index', [
            'pharmacies' => $pharmacies,
            'deletedPharmacies' => $deletedPharmacies['pharmacies']
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
        $areas = Area::all();
        return view('pharmacy.create', [
            'areas' => $areas
        ]);
    }


    public function store(Request $request)
    {
        $pharmacy = $request->only(['name', 'email','password' ,'national_id', 'area_id', 'avatar', 'priority']);
        $avatar = isset($pharmacy['avatar'])? $pharmacy['avatar'] : "xx.png";
        // dd($pharmacy['name']);
       
       
        $user = User::create([
            'name'=> $pharmacy['name'],
            'email'=> $pharmacy['email'],
            'password' => Hash::make($pharmacy['password']),

        ]);
        $pharmacy = Pharmacy::create([
            'national_id' => $pharmacy['national_id'],
            'area_id' => $pharmacy['area_id'],
            'avatar' => $avatar,
            'priority' => $pharmacy['priority'],
        ]);

        // dd($user);
        $user = $user->refresh();
        $pharmacy=$pharmacy->refresh();

        $pharmacy->type()->save($user);
        $user->assignRole('pharmacy');
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
        $pharmacy = $request->only([ 'national_id', 'area_id', 'avatar', 'priority']);
        $avatar = isset($pharmacy['avatar'])? $pharmacy['avatar'] : "xx.png";
        $pharmacyUser->update([
            
            'national_id' => $pharmacy['national_id'],
            'area_id' => $pharmacy['area_id'],
            'avatar' => $avatar,
            'priority' => $pharmacy['priority'],
        ]);
        return redirect()->route('pharmacies.index');
    }

    public function destroy(Request $request)
    {
        $pharmacyId = $request->pharmacy;
        $pharmacy = Pharmacy::withTrashed()
                ->where('id', $request->pharmacy)
                ->get()->first();
        $pharmacy->forceDelete();
        return redirect()->route('pharmacies.index');
    }



    public function softdelete(Request $request)
    {
        $pharmacy = Pharmacy::find($request->pharmacy);
        $pharmacy->delete();
        return redirect()->route('pharmacies.index');
    }
    public function readsoftdelete()
    {
        $pharmacies = Pharmacy::onlyTrashed()
                    ->get();
        return [
                'pharmacies' => $pharmacies
                ];
    }
    public function restore(Request $request)
    {
        $pharmacy = Pharmacy::onlyTrashed()->where('id', $request->pharmacy);
        $pharmacy->restore();
        return redirect()->route('pharmacies.index');
    }



}
