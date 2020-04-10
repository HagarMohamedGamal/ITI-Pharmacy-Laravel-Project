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
        
        $pharmacies=Pharmacy::all();
       
        return view('revenue.index',[
            'pharmacies' => $pharmacies,
           
        ]);
    }



    function getAllData()
    {
     
     //**********************************************
       // $id = Auth::id();
       $pharmacies = Pharmacy::query();
       return DataTables()::of($pharmacies)
             ->editColumn('id', function(Pharmacy $pharmacy) {
                 return $pharmacy->id ;
             })
             ->addColumn('name', function(Pharmacy $pharmacy) {
                //   $id = $pharmacy->id;
                 return $pharmacy->type->name;
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
