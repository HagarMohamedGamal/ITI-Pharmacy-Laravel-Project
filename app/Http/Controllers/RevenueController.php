<?php

namespace App\Http\Controllers;
use App\Order;
use App\User;
use App\Pharmacy;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Datatables;
class RevenueController extends Controller
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
        $pharmacies=Pharmacy::all();
        // $x=Pharmacy::find(1)->pharmacy_name->name;
        // dd($x);
        // dd($pharmacies);
        return view('revenue.index',[
            'pharmacies' => $pharmacies,
            // 'ordersCount' => $ordersCount,
            // 'totalIncome' => $totalIncome,
        ]);
    }



    function getAllData()
    {
      // dd("a");
     //  $id = Auth::id();
     //  // $pharmacy=Pharmacy::find($id);
     // $pharmacy = Pharmacy::select('id', 'national_id','priority');
    // $pharmacy = DB::table('pharmacies')->select('name', 'national_id')->get();
     // return DataTables::of($pharmacy)->make(true);
     // return DataTables()::of($pharmacy)->make(true);

     //**********************************************
       // $id = Auth::id();
       $pharmacies = Pharmacy::query();
       return DataTables()::of($pharmacies)
             ->editColumn('id', function(Pharmacy $pharmacy) {
                 return $pharmacy->id ;
             })
             ->addColumn('name', function(Pharmacy $pharmacy) {
                  $id = $pharmacy->id;
                 return User::find($id)->name;
             })
             ->addColumn('totalOrders', function(Pharmacy $pharmacy) {
                  // $id = Auth::id();
                  $ordersCount = DB::table('orders')->where('pharmacy_id',$pharmacy->id)->count();
                 return $ordersCount;
             })
             ->addColumn('totalRevenue', function(Pharmacy $pharmacy) {
                  // $id = Auth::id();
                  $totalIncome = DB::table('orders')->where('pharmacy_id',$pharmacy->id)->sum("price");
                 return $totalIncome;
             })
             ->toJson();

    }



}
