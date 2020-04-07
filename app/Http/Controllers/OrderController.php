<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  public function index()
  {
  
    if (request()->ajax()) {
      $orders = Order::latest()->get();
      return datatables()->of($orders)
        ->addColumn('action', function ($data) {
          $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</button>';
          $button .= '&nbsp;&nbsp;';
          $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
          return $button;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

   
    return view('orders.index');
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
      'user_id' => $request->user_id,
      'useraddress_id' => $request->useraddress_id,
      'doctor_id' => $request->doctor_id,
      'is_insured' => $request->is_insured,
      'status' => $request->status,
      'creator_type' => $request->creator_type,
      'pharmacy_id' => $request->pharmacy_id,
      'Actions' => $request->Actions,
    ]);
    return response()->json(['success' => 'Data Added successfully.']);
  }


  public function edit($id)
  {
    $order = Order::find($id);
    $this->authorize('update', $order);
    if (request()->ajax()) {
      $data = Order::findOrFail($id);
      return response()->json(['data' => $data]);
    }
    // $request = request();
    // $orderId = $request->order;
    // $order = Order::find($orderId);
    // return view('orders.edit', [
    //   'order' => $order,
    // ]);
  }

  public function update(Request $request)
  {
    $order = Order::find($request->user_id);
    $this->authorize('update', $order);
    $request->validate([
      'is_insured' => 'boolean',
    ]);
    
    dd($request->user_id);
    $orderId = $request->order;
    Order::where('id', $orderId)
      ->update([
      'user_id' => $request->user_id,
      'useraddress_id' => $request->useraddress_id,
      'doctor_id' => $request->doctor_id,
      'is_insured' => $request->is_insured,
      'status' => $request->status,
      'creator_type' => $request->creator_type,
      'pharmacy_id' => $request->pharmacy_id,
      'Actions' => $request->Actions,
      ]);
    return response()->json(['success' => 'Data is successfully updated']);

    //return redirect()->route('orders.index');
  }

  public function show(Request $request)
  {
    $order = Order::find($request->order);
    $this->authorize('view', $order);
    $ordersId = $request->order;
    $order = Order::find($ordersId);
    return view('orders.show', [
      'order' => $order,
    ]);
  }

  public function destroy()
  {
    $request = request();
    $order = Order::find($request->order);
    $this->authorize('delete', $order);
    
    $orderId = $request->order;
    $order = Order::find($orderId);
    $order->delete();
    // return redirect()->route('orders.index');
  }
}
