<?php

namespace App\Http\Controllers;

use DB;
use App\Area;
use App\User;
use App\Order;
use App\Client;
use App\Doctor;
use App\Medicine;
use App\Pharmacy;
use App\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            $user = Auth::user();

            if ($user->hasRole('super-admin'))
                $orders = Order::with(['pharmacy.type', 'address', 'address.area','doctor.type', 'user.type'])->latest()->get();
            elseif ($user->hasRole('pharmacy'))
                $orders = Order::with(['pharmacy.type', 'address', 'address.area','doctor.type', 'user.type'])->where('pharmacy_id', $user->typeable_id)->latest()->get();
            elseif ($user->hasRole('doctor')) {
                $doctor = Doctor::where('id', $user->typeable_id)->first();
                $orders = Order::with(['pharmacy.type', 'address', 'address.area','doctor.type', 'user.type'])->where('pharmacy_id', $doctor->pharmacy_id)->latest()->get();
            } else
                $orders = null;

            $table= datatables()::of($orders)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    $button .= '<a type="button" href="/orders/' . $data->id . '" name="show" id="' . $data->id . '" class=" btn btn-primary btn-sm">show</a>';
                    $order = Order::find($data->id);
                    if ($order->status == 'confirmed') {
                        $button .= '<a type="button" href="/stripe/' . $data->id . '" name="pay" id="' . $data->id . '" class=" btn btn-danger btn-sm">pay online</a>';
                    }
                    return $button;
                });

            if ($user->hasRole('super-admin')) {
                $table->addColumn('pharmacy', function ( $data) {

                    return  $data->pharmacy ? $data->pharmacy->type->name : "";
                });
                $table->addColumn('creator', function ($data) {

                    return  $data->creator_type ;
                });


            }
            return $table->toJson();
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

    public function store(StoreOrderRequest $request)
    {
        $user = Auth::user();
        $useradd = UserAddress::find($request->delivering_address);
        $doctor = null;
        $status = 'Processing';

        if ($user->hasRole('doctor')) {
            $doctor = Doctor::find($user->typeable_id);
            $creator = 'doctor';
            $pharmacy = Pharmacy::find($doctor->pharmacy_id);
            $doctor = $doctor->id;
        } elseif ($user->hasRole('pharmacy')) {
            $creator = 'pharmacy';
            $pharmacy = Pharmacy::find($user->typeable_id);
        } else {
            $creator = 'admin';
            $pharmacy = Pharmacy::where('area_id', $useradd->area_id)->orderby('priority', 'desc')->first();
            $status = 'new';
        }


        $doctor = Auth::user()->typeable_id;


        $order = Order::create([
            'user_id' => $request->user_id,
            'useraddress_id' => $request->delivering_address,
            'doctor_id' => $doctor,
            'is_insured' => $request->is_insured ? $request->is_insured : 0,
            'status' => $status,
            'pharmacy_id' => $pharmacy->id,
            'Actions' => '--',
            'creator_type' => $creator
        ]);

        return redirect("/orders/$order->id");
    }


    public function edit()
    {
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

    public function show(Order $order)
    {
        $user = Auth::user();


        $this->authorize('view', $order);
        if ($user->hasAnyRole('pharmacy , doctor', 'super-admin'))
            if ($order->status=="New")
                $order->status = 'Processing';
        $order->save();


        return view('orders.show', [
            'order' => $order,
        ]);
    }

    public function destroy(Order $order)
    {

        $this->authorize('delete', $order);
        $order->delete();

    }

    public function pay(Request $request)
    {
        $user = Auth::user();
        $ordersId = $request->order;
        $order = Order::find($ordersId);
        $amountTotal = DB::table("orders")->select(DB::raw("SUM((medicines.price /100)* medicine_order.quantity) as total_price"))->leftjoin("medicine_order", "medicine_order.order_id", "=", "orders.id")->leftjoin("medicines", "medicine_order.medicine_id", "=", "medicines.id")->where('orders.id', $order->id)->first();
        $userData = DB::table("users")->select(DB::raw("users.name as username , users.id as userId,users.email as email_user"))->leftjoin("orders","orders.user_id","=","users.id")->where('orders.id', $order->id)->first();
        return view('stripe', [
            'order' => $order->id,
            'amountTotal' => $amountTotal->total_price,
            'user' => $userData->email_user,
            'userId' => $userData->userId
        ]);
    }

    public function notifyuser($userId, $orderId){
        User::find($userId)->notifyOrder($orderId);
        return response()->json([
            'success' => 'User Notified',
        ]);
    }
}
