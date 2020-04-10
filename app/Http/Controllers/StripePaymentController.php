<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Session;

use Stripe;



class StripePaymentController extends Controller

{

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function stripe()

    {

        return view('stripe');

    }



    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

      public function stripePost(Request $request)

    {

        $order_id=$request->order_id;
        $amount = DB::table("orders") ->select(DB::raw("SUM((medicines.price /100)* medicine_order.quantity) as total_price")) ->leftjoin("medicine_order","medicine_order.order_id","=","orders.id")->leftjoin("medicines","medicine_order.medicine_id","=","medicines.id")->where('orders.id',$request->order_id)->first();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([

            "amount" => $amount->total_price,

            "currency" => "usd",

            "source" => $request->stripeToken,

            "description" => "Test payment from itsolutionstuff.com."

        ]);



        Session::flash('success', 'Payment successful!');



        return back();

    }

}
