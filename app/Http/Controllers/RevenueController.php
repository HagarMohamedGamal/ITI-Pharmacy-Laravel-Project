<?php

namespace App\Http\Controllers;
use App\Order;
use App\User;
use App\Pharmacy;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
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
}
