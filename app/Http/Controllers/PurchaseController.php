<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Payment;
use App\OrderedProduct;
use DB;

class PurchaseController extends Controller
{
   

    public function placeOrder(Request $request){
        /**
         * expected json object
         * {
         *   userId:2,
         *   amount: 200,
         *   products:[
         *    { id: 23, quantity: 3},
         *    { id: 2, quantity: 1},
         *    { id: 43, quantity: 6}
         *   ]
         * }
         */
      $this->validate($request,[
        'amount'=>'required',
        'userId'=>'required',
        'products'=>'required'
      ]);

      DB::transaction(function(){
        
        //place
        $payment = new Payment();
        $payment->amount = $request->amount;
        $payment->transcode = \uniqid('TR_');
        $payment->save();
        //insert an order
        if(!$payment){
            throw new \Exception('Payment details not processed');
        }
        $order = new Order();
        $order->transcode = $payment->transcode;
        $order->user_id = $request->userId;
        $order->save();

        if(!$order){
            throw new \Exception('Error placing your order');
        }

        //insert into ordered_goods
        foreach($request->products as $product){
            $ordered_product = new OrderProduct();
            $ordered_product->order->id = $order->id;
            $ordered_product->product->id = $product['id'];
            $ordered_product->quantity = $product['quantity'];
            $ordered_product->save();

            if(!$ordered_product){
                throw new \Exception('Error placing your order');
            }
        }
      });

      return response()->json([
          'message'=>'Order placed successfully',
          'transactionId'=> $payment->transcode,
          'orderId'=>$order->id
      ]);
  }
}
