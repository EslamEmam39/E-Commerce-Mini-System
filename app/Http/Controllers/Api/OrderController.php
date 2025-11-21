<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
        public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string'
        ]);

        $user = $request->user();

        $cartItems = $user->cartItems()->with('product')->get();

        if($cartItems->isEmpty()) {
            return response()->json([
                'error' => 'Cart is empty'
            ], 400);
        }


        DB::beginTransaction();

        try {
            /**
             * 1) انشاء عنوان المستخدم
             */
            $address = $user->addresses()->create([
                'address' => $request->address,
                'phone' => $request->phone
            ]);


                $total = 0;
              $itemsSummary = [];

            /**
             * 2) التحقق من كمية المنتجات
             */
            foreach ($cartItems as $item) {

                $product = Product::find($item->product_id);

                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    return response()->json([
                        'error' => "Product '{$product->name}' is out of stock"
                    ], 400);
                }

                $subtotal = $product->price * $item->quantity;
                $total += $subtotal;

                $itemsSummary[] = [
                    'name' => $product->name,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal
                ];

            }

            /**
             * 3) انشاء الطلب
             */
            $order = $user->orders()->create([
                'address_id' => $address->id,
                'total' => $total
            ]) ;



            // 3) إضافة عناصر الطلب
            foreach ($cartItems as $item) {

                 $product = $item->product;

                   $order->items()->create([
                       'product_id' => $product->id,
                       'quantity' => $item->quantity,
                       'price' => $product->price ,
                       'subtotal' => $product->price * $item->quantity
                   ]) ;


               // تحديث المخزون
                    $product->decrement('stock', $item->quantity);
                    $product->status = $product->stock == 0 ? 'out_of_stock' : 'in_stock';
                     $product->save();
             }

             $user->cartItems()->delete();

            DB::commit();

            // 7) رجوع الـ Response المطلوب في التاسك
            return response()->json([
                'order_number' => $order->id,
                'total' => $total,
                'items' => $itemsSummary
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong ' . $e->getMessage()], 500);
        }
    }
}
