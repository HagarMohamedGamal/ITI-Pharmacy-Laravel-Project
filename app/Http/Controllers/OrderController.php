<?php

namespace App\Http\Controllers;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all(); 
       // dd($orders);
        // return view('orders.index', [
        //   'orders' => $orders,
        // ]);
        return view('orders.index',[
            'orders' => $orders,
        ]);
    }

    public function create()
    {
      return view('orders.create');
    }

    public function store(Request $request)
    { 

        $request->validate([
            'is_insured' => 'boolean',
        ]);
      Order::create([
        'order_user_name'=>$request->order_user_name,
        'delivering_address'=>$request->delivering_address,
        'doctor_name'=>$request->doctor_name,
        'is_insured'=>$request->is_insured,
        'status'=>$request->status,
        'creator_type'=>$request->creator_type,
        'assigned_pharmacy_name'=>$request->assigned_pharmacy_name,
        'Actions'=>$request->Actions,
      ]);
      return redirect()->route('orders.index');
    }


    public function edit()
    {
     $request = request();
     $orderId = $request->order;
     $order = Order::find($orderId);
     return view('orders.edit',[
         'order' => $order,
     ]);
    }

    public function update(Request $request)
    {   

    $request->validate([
        'is_insured' => 'boolean',
    ]);
    $orderId = $request->order;
    Order::where('id', $orderId)
        ->update([
            'order_user_name'=>$request->order_user_name,
            'delivering_address'=>$request->delivering_address,
            'doctor_name'=>$request->doctor_name,
            'is_insured'=>$request->is_insured,
            'status'=>$request->status,
            'creator_type'=>$request->creator_type,
            'assigned_pharmacy_name'=>$request->assigned_pharmacy_name,
            'Actions'=>$request->Actions,
          ]);
          return redirect()->route('orders.index');

    //return redirect()->route('orders.index');
    }

    public function show(Request $request)
    {
         $ordersId = $request->order;
         $order = Order::find($ordersId);
         return view('orders.show',[
             'order' => $order,
         ]);
    }

    public function destroy()
    {
      $request = request();
      $orderId = $request->order;
      $order = Order::find($orderId);
      $order->delete();
      return redirect()->route('orders.index');
    }

}
