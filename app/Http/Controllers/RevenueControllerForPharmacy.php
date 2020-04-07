<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Pharmacy;
use DB;
use Illuminate\Support\Facades\Auth;

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
        $id = Auth::id();
        // dd($id);
        $pharmacy=Pharmacy::find($id);
        // dd($pharmacies);
        return view('revenuePerPharmacy.index',[
            'pharmacy' => $pharmacy,
            // 'ordersCount' => $ordersCount,
            // 'totalIncome' => $totalIncome,
        ]);
    }
}