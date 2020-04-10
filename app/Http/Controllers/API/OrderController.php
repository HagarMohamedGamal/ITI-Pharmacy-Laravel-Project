<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Area;
use App\Client;
use App\Doctor;
use App\Medicine;
use App\Order;
use App\Pharmacy;
use App\User;
use App\UserAddress;
use App\OrderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreClientOrderRequest;

class OrderController extends Controller
{
  public function index()
  {

  }

  public function store(StoreClientOrderRequest $request)
  {
	    $OrderSent = $request->only(['is_insured', 'delivering_address_id', 'image']);

	    $useradd = UserAddress::find($OrderSent['delivering_address_id']);
	    $pharmacy = Pharmacy::where('area_id', $useradd->area_id)->orderby('priority', 'desc')->first();

	    $user = Auth::user();

	    $order = Order::create([
	      'user_id' => $user->id,
	      'useraddress_id' => $OrderSent['delivering_address_id'],
	      'doctor_id' => null,
	      'is_insured' => $OrderSent['is_insured'],
	      'status' => 'New',
	      'pharmacy_id' => $pharmacy->id,
	      'Actions' => '--',
	      'creator_type' => 'Client'
	    ]);

			foreach ($request->file('image') as $image) 
			{
	            $new_name = time() . '_' . $image->getClientOriginalName();
	            $image->move(public_path('images'), $new_name);

				$prescription = OrderImage::create([
					'image' => $new_name
				]);

	    		$prescription=$prescription->refresh();
				$order->images()->save($prescription);
			}

    	return response()->json([
    		'order' => $order,
	    	'prescription' => $order->images()->get()
    	]);
  }


  public function update(StoreClientOrderRequest $request)
  {
	$user = Auth::user();

    $exist = Order::where('id', $request->order);
    if ($exist->count()>0) 
    {
		$order = Order::find($request->order);
    	if($order->user_id == $user->id)
    	{
    		$OrderSent = $request->only(['is_insured', 'delivering_address_id', 'image']);

		    $useradd = UserAddress::find($OrderSent['delivering_address_id']);
		    $pharmacy = Pharmacy::where('area_id', $useradd->area_id)->orderby('priority', 'desc')->first();

		    $order->update([
		      'user_id' => $user->id,
		      'useraddress_id' => $OrderSent['delivering_address_id']?$OrderSent['delivering_address_id']:$order->useraddress_id,
		      'doctor_id' => null,
		      'is_insured' => $OrderSent['is_insured']?$OrderSent['is_insured']:$order->is_insured,
		      'status' => 'New',
		      'pharmacy_id' => $pharmacy->id,
		      'Actions' => '--',
		      'creator_type' => 'Client'
		    ]);

		    if (isset($OrderSent['image']))
		    {
		    	$order->images()->delete();
				foreach ($request->file('image') as $image) 
				{
		            $new_name = time() . '_' . $image->getClientOriginalName();
		            $image->move(public_path('images'), $new_name);

					$prescription = OrderImage::create([
						'image' => $new_name
					]);

		    		$prescription=$prescription->refresh();
					$order->images()->save($prescription);
				}
			}

	    	return ['updated Order' => response()->json([
	    		'order' => $order,
		    	'prescription' => $order->images()->get()
	    	])];

		    
		}
	}
	return response()->json(['message' => 'Order Not Found'], 403);
  }



  public function show($order)
  {
	$user = Auth::user();

    $exist = Order::where('id', $order);
    if ($exist->count()>0) 
    {
		$order = Order::find($order);
    	if($order->user_id == $user->id)
    	{
	    	return response()->json([
	    		'order' => $order,
		    	'prescription' => $order->images()->get()
	    	], 200);
		}
	}
	return response()->json(['message' => 'Order Not Found'], 403);
  }

  public function destroy($order)
  {
	$user = Auth::user();

    $exist = Order::where('id', $order);
    if ($exist->count()>0) 
    {
		$order = Order::find($order);
    	if($order->user_id == $user->id)
    	{
    		$order->images()->delete();
    		$order->delete();
	    	return response()->json([
	    		'Data'=> "data deleted successufuly"
	    	], 200);
		}
	}
	return response()->json(['message' => 'Order Not Found to be deleted'], 403);

  }
}


