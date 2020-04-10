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
use App\Http\Resources\OrderResource;
use App\Http\Resources\DeliveredOrderResource;
use File;

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
			'user_id' => $user->typeable->id,
			'useraddress_id' => $OrderSent['delivering_address_id'],
			'doctor_id' => null,
			'is_insured' => $OrderSent['is_insured'],
			'status' => 'New',
			'pharmacy_id' => $pharmacy->id,
			'Actions' => '--',
			'creator_type' => 'Client'
		]);

		$this->orderPrescription($request->file('image'), $order);
		return response()->json(new OrderResource($order), 201);
	}


	public function update(StoreClientOrderRequest $request)
	{
		$user = Auth::user();

		$exist = Order::where('id', $request->order);
		if ($exist->count() > 0) {
			$order = Order::find($request->order);
			if ($order->user_id == $user->typeable->id) {
				if ($order->status == 'New') {
					$OrderSent = $request->only(['is_insured', 'delivering_address_id', 'image']);

					$useradd = UserAddress::find($OrderSent['delivering_address_id']);
					$pharmacy = Pharmacy::where('area_id', $useradd->area_id)->orderby('priority', 'desc')->first();

					$order->update([
						'user_id' => $user->typeable->id,
						'useraddress_id' => $OrderSent['delivering_address_id'] ? $OrderSent['delivering_address_id'] : $order->useraddress_id,
						'doctor_id' => null,
						'is_insured' => $OrderSent['is_insured'] ? $OrderSent['is_insured'] : $order->is_insured,
						'status' => 'New',
						'pharmacy_id' => $pharmacy->id,
						'Actions' => '--',
						'creator_type' => 'Client'
					]);

					if (isset($OrderSent['image'])) {
						$this->deletePriscription($order->images, $order);
						$this->orderPrescription($request->file('image'), $order);
					}

					return new OrderResource($order);
				}

				return response()->json([
					'message' => 'Can\'t modify Order, it\'s already ' . $order->status
				], 400);
			}
		}
		return response()->json(['message' => 'Order Not Found'], 404);
	}



	public function show($order)
	{

		$user = Auth::user();

		$exist = Order::where('id', $order);

		if ($exist->count() > 0) {
			$order = Order::find($order);
			if ($order->user_id == $user->typeable->id) {
				return new DeliveredOrderResource($order);
			}
		}
		return response()->json(['message' => 'Order Not Found'], 404);
	}

	public function destroy($order)
	{
		$user = Auth::user();

		$exist = Order::where('id', $order);
		if ($exist->count() > 0) {
			$order = Order::find($order);
			if ($order->status == "New") {
				if ($order->user_id == $user->typeable->id) {
					$this->deletePriscription($order->images, $order);
					$order->delete();
					return response()->json([
						'Data' => "data deleted successufuly"
					], 200);
				}
			}
			return response()->json(['message' => 'Order can Not be deleted it\'s already ' . $order->status], 404);
		}
		return response()->json(['message' => 'Order Not Found to be deleted'], 404);
	}


	public function orderPrescription($images, &$order)
	{
		foreach ($images as $image) {
			$new_name = time() . '_' . $image->getClientOriginalName();
			$image->move(public_path('images'), $new_name);

			$prescription = OrderImage::create([
				'image' => $new_name
			]);

			$prescription = $prescription->refresh();
			$order->images()->save($prescription);
		}
	}

	public function deletePriscription($images, &$order)
	{
		foreach ($images as $value) {
			$image_path = public_path('images') . '/' . $value->image;
			if (File::exists($image_path)) {
				File::delete($image_path);
			}
			$order->images()->delete();
		}
	}

	public function confirmorder($orderId)
	{
		Order::find($orderId)->update([
			'status' => 'Confirmed',
		]);
		return response()->json(['success' => 'Order Confirmed'], 200);
	}
}
