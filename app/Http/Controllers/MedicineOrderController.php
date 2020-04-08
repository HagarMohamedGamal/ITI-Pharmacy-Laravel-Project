<?php

namespace App\Http\Controllers;

use App\Medicine;
use App\Order;
use Illuminate\Http\Request;

class MedicineOrderController extends Controller
{
    public function store(Request $request)
    {
        
        if ($request->status == 'new') {
           
            $medicine = Medicine::create([
                'name' => $request->name,
                'quantity' => $request->quantity,
                'type' => $request->type,
                'price' => $request->price
            ]);
            
        }
        else
        {
            
            $medicine=Medicine::where('name', $request->name)->first();
            
        }

        $order = Order::find($request->hidden_id);
        
        $order->medicines()->attach($medicine, ['quantity' => $request->quantity,]);



        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function update($id)
    {
        $order = Order::find($id);
        // dd($order);
        $order->status = 'waiting';
        $order->save();
        return redirect('/orders');
    }
}
