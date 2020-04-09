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
        //    $id=2;
        //     $ordersCount = DB::table('orders')->where('pharmacy_id',$id)->count();
        //     $totalIncome = DB::table('orders')->where('pharmacy_id',$id)->sum("price");
        //     dd($ordersCount,$totalIncome);

        //$myPharm= Pharmacy::find(2)->orders->sum("price");/*this line for admin */
        //dd($myPharm);
        // $id = Auth::id();
        // dd($id);
        // $pharmacy=Pharmacy::find($id);
        // $pharmacy_name=User::find($id)->name;
        // dd($pharmacy);

        return view('revenuePerPharmacy.index');
    }

    function getdata()
    {
        // dd("a");
        //  $id = Auth::id();
        //  // $pharmacy=Pharmacy::find($id);
        // $pharmacy = Pharmacy::select('id', 'national_id','priority');
        // $pharmacy = DB::table('pharmacies')->select('name', 'national_id')->get();
        // return DataTables::of($pharmacy)->make(true);
        // return DataTables()::of($pharmacy)->make(true);

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
