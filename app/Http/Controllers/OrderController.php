<?php

namespace App\Http\Controllers;

use App\Medicine;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

      $medicines= Medicine::all();

      return view('orders.index', ['medicines' => $medicines]);
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

    $order = Order::create([
      'user_id' => $request->user_id,
      'useraddress_id' => $request->useraddress_id,
      'doctor_id' => $request->doctor_id,
      'is_insured' => $request->is_insured,
      'status' => $request->status,
      'creator_type' => $request->creator_type,
      'pharmacy_id' => $request->pharmacy_id,
      'Actions' => $request->Actions,
    ]);

    if($request->has('medicine_select')) {
        $selected_medicines = $request->get('medicine_select');
        $order->medicines()->sync($selected_medicines);
    }
    return response()->json(['success' => 'Data Added successfully.']);
  }


  public function edit($id)
  {
    if (request()->ajax()) {
      $data = Order::findOrFail($id);
      $medicines_id = $data->medicines()->pluck('id')->toArray();
      return response()->json(['data' => $data, 'medicine_ids' =>  $medicines_id]);
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
    $ordersId = $request->order;
    $order = Order::find($ordersId);
    return view('orders.show', [
      'order' => $order,
    ]);
  }

  public function destroy()
  {
    $request = request();
    $orderId = $request->order;
    $order = Order::find($orderId);
    $order->delete();
    // return redirect()->route('orders.index');
  }
}
