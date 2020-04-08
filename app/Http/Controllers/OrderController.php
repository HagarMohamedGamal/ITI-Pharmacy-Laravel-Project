<?php

namespace App\Http\Controllers;

use App\Area;
use App\Client;
use App\Doctor;
use App\Medicine;
use App\Order;
use App\Pharmacy;
use App\User;
use App\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
  public function index()
  {

    if (request()->ajax()) {
      $user = Auth::user();

      if ($user->hasRole('super-admin'))
        $orders = Order::with(['pharmacy.type', 'user.type'])->latest()->get();
      elseif ($user->hasRole('pharmacy'))
        $orders = Order::with(['pharmacy.type', 'user.type'])->where('pharmacy_id', $user->typeable_id)->latest()->get();
      elseif ($user->hasRole('doctor')) {
        $doctor = Doctor::where('id', $user->typeable_id)->first();
        $orders = Order::with(['pharmacy.type', 'user.type'])->where('pharmacy_id', $doctor->pharmacy_id)->latest()->get();
      } 
      else
        $orders = null;

      return datatables()->of($orders)
        ->addColumn('action', function ($data) {
          $button = '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
          $button .= '<a type="button" href="/orders/' . $data->id . '" name="show" id="' . $data->id . '" class=" btn btn-primary btn-sm">show</a>';
          return $button;
        })
        ->rawColumns(['action'])
        ->make(true);
    }



    return view('orders.index');
  }

  public function create()
  {
    $clients = Client::all();
    return view('orders.create', [
      'clients' => $clients
    ]);
  }

  public function store(Request $request)
  {
    // dd($request->delivering_address);
    // $request->validate([
    //   'is_insured' => 'boolean',
    // ]);

    $useradd = UserAddress::find($request->delivering_address);
    $pharmacy = Pharmacy::where('area_id', $useradd->area_id)->orderby('priority', 'desc')->first();

    $doctor = Auth::user();

    $order = Order::create([
      'user_id' => $request->user_id,
      'useraddress_id' => $request->delivering_address,
      'doctor_id' => $doctor->typeable_id,
      'is_insured' => $request->is_insured,
      'status' => 'Processing',
      'pharmacy_id' => $pharmacy->id,
      'Actions' => '--',
      'creator_type' => 'Doctor'
    ]);


    // if ($request->has('medicine_select')) {
    //   $selected_medicines = $request->get('medicine_select');
    //   $order->medicines()->sync($selected_medicines);
    // }

    return redirect("/orders/$order->id");
  }


  public function edit($id)
  {
    $order = Order::find($id);
    $this->authorize('update', $order);
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
    $order = Order::find($request->user_id);
    $this->authorize('update', $order);
    if ($order->status == "Confirmed") {
      $order->status == "Delivered";
      $order->save();
    }

    // return response()->json(['success' => 'Data is successfully updated']);

    return redirect()->route('orders.index');
  }

  public function show(Request $request)
  {
    $user = Auth::user();
    $order = Order::find($request->order);
    // $this->authorize('view', $order);
    // if ($user->hasRole('pharmacy'))
    if ($order->status == 'new')
      $order->status = 'Processing';
    $order->save();

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
