<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePharmacyRequest;
use App\Http\Requests\UpdatePharmacyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Pharmacy;
use App\User;
use App\Area;
use Illuminate\Support\Facades\Hash;

use Redirect,Response,DB,Config;
use Datatables;

class PharmacyController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            return $this->indexDataTable();
        }
        return view('pharmacy.index');
    }
// ===========================================================

    public function indexDataTable()
    {
        $pharmacies = Pharmacy::query();
          return DataTables()::of($pharmacies)
                ->addColumn('name', function(Pharmacy $pharmacy) {
                    return $pharmacy->type->name ;
                })
                ->addColumn('email', function(Pharmacy $pharmacy) {
                    return $pharmacy->type->email ;
                })
                ->addColumn('action', function(Pharmacy $pharmacy) {

                    $button = '<a name="show" id="'.$pharmacy->id.'" class="show btn btn-success btn-sm p-0" href="/pharmacies/'.$pharmacy->id.'" style="border-radius: 20px;"><i class="fas fa-eye m-2"></i></a>';
                    $button .= '<a name="edit" id="'.$pharmacy->id.'" class="edit btn btn-primary btn-sm p-0" href="/pharmacies/'.$pharmacy->id.'/edit" style="border-radius: 20px;"><i class="fas fa-edit m-2"></i></a>';
                    // $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$pharmacy->id.'" class="delete btn btn-danger btn-sm p-0" style="border-radius: 20px;"><i class="fas fa-trash m-2"></i></button>';
                    return $button;
                    
                })
                ->toJson();
    }
// ===========================================================    

    public function show(Request $request)
    {
        $pharmacy = Pharmacy::find($request->pharmacy);
        $this->authorize('view', $pharmacy);
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


    public function store(StorePharmacyRequest $request)
    {
        $pharmacy = $request->only(['name', 'email','password' ,'national_id', 'area_id', 'avatar', 'priority']);
        $avatar = isset($pharmacy['avatar'])? $pharmacy['avatar'] : "";
        if ($avatar) 
        {
            $new_name = time() . '_' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images'), $new_name);
        }
        else
        {
            $new_name = "default.jpg";
        }
        // dd($pharmacy['name']);
       
       
        $user = User::create([
            'name'=> $pharmacy['name'],
            'email'=> $pharmacy['email'],
            'password' => Hash::make($pharmacy['password']),

        ]);
        $pharmacy = Pharmacy::create([
            'national_id' => $pharmacy['national_id'],
            'area_id' => $pharmacy['area_id'],
            'avatar' => $new_name,
            'priority' => $pharmacy['priority'],
        ]);

        // dd($user);
        $user = $user->refresh();
        $pharmacy=$pharmacy->refresh();

        $pharmacy->type()->save($user);
        $user->assignRole('pharmacy');
        // return redirect()->route('pharmacies.index');
        return response()->json(['success' => 'Data Added successfully.']);
    }


    public function edit(Request $request)
    {
        $pharmacy = Pharmacy::find($request->pharmacy);
        $this->authorize('update', $pharmacy);
        $pharmacies = Pharmacy::all();
        
        return view('pharmacy.edit', [
            'pharmacy' => $pharmacy,
            'pharmacies' => $pharmacies
        ]);
    }


    public function update(UpdatePharmacyRequest $request)
    {
        $pharmacy = $request->only(['name', 'email' ,'national_id', 'area_id', 'avatar', 'priority']);
        $avatar = isset($pharmacy['avatar'])? $pharmacy['avatar'] : "";
        if ($avatar) 
        {
            $new_name = time() . '_' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images'), $new_name);
        }
        else
        {
            $new_name = "default.jpg";
        }
        // dd($pharmacy['name']);
       $updatePharmacy = Pharmacy::find($request->pharmacy);
       
        User::find($updatePharmacy->type->id)->update([
            'name'=> $pharmacy['name'],
            'email'=> $pharmacy['email'],

        ]);
        $updatePharmacy->update([
            'national_id' => $pharmacy['national_id'],
            'area_id' => $pharmacy['area_id'],
            'avatar' => $new_name,
            'priority' => $pharmacy['priority'],
        ]);
        return response()->json([
            'success' => 'Record Updated successfully!'
        ]);
        // return redirect()->route('pharmacies.index');
    }

    public function destroy(Request $request)
    {
        $pharmacyId = $request->pharmacy;
        $pharmacy = Pharmacy::withTrashed()
                ->where('id', $pharmacyId)
                ->get()->first();
        $pharmacy->forceDelete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
        // ret
    }



    public function softdelete(Request $request)
    {
        $pharmacy = Pharmacy::find($request->pharmacy);
        $pharmacy->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
        // return redirect()->route('pharmacies.index');
    }
    public function readsoftdelete()
    {
        $pharmacies = Pharmacy::onlyTrashed()
                    ->get();
        return view('pharmacy.softdelete', [
            'deletedPharmacies' => $pharmacies
        ]);
    }
    public function restore(Request $request)
    {
        $pharmacy = Pharmacy::onlyTrashed()->where('id', $request->pharmacy);
        $pharmacy->restore();
        return redirect()->route('pharmacies.index');
    }



}
