<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Pharmacy;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Datatables;



class RevenueControllerForPharmacy extends Controller
{
    public function index()
    {
        
        return view('revenuePerPharmacy.index');
    }

    function getdata()
    {
        

        //**********************************************
        $user = Auth::user();
        $id = $user->typeable_id;
        $pharmacies = Pharmacy::query()->where('id', $id);
        return DataTables()::of($pharmacies)
            ->addColumn('id', function (Pharmacy $pharmacy) {
                return $pharmacy->id;
            })
            ->addColumn('name', function (Pharmacy $pharmacy) {
                $id = Auth::id();
                return User::find($id)->name;
            })
            ->addColumn('totalOrders', function (Pharmacy $pharmacy) {
                $user = Auth::user();
                $id = $user->typeable_id;

                $ordersCount = DB::table('orders')->where('pharmacy_id', $id)->count();
                return $ordersCount;
            })
            ->addColumn('totalRevenue', function (Pharmacy $pharmacy) {
                $user = Auth::user();
                $id = $user->typeable_id;
                $totalIncome = DB::table('orders')->where('pharmacy_id', $id)->sum("price");
                return $totalIncome;
            })
            ->toJson();
    }
}
