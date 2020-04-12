<?php

namespace App\Http\Controllers;

use App\Medicine;
use App\Order;
use Illuminate\Http\Request;

class MedicineOrderController extends Controller
{
    public function store(Request $request)
    {

        if ($request->status == 'add') {

            $medicine = Medicine::create([
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price
            ]);
        } else {

            $medicine = Medicine::where('name', $request->name)->first();
        }

        $order = Order::find($request->hidden_id);

        $order->medicines()->attach($medicine, ['quantity' => $request->quantity,]);

        $order->price = $order->price + ($medicine->price * $request->quantity);
        $order->save();


        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function update(Order $order)
    {

        if($order->status == "Processing")
        {
            $user = $order->user->type;
            $order->status = 'Waiting';
            $user->notifyOrder($order->id);
            $order->save();
            return response()->json([
                'success' => 'User Notified',
            ]);
        }

           
        
        
        return redirect('/orders/'+$order->id);
    }
}
