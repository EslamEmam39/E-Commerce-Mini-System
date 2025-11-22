<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder($user, $cartItems, $addressData)
    {
        DB::beginTransaction();

        try {
            // 1) إنشاء العنوان
            $address = $user->addresses()->create($addressData);

            $total = 0;
            $itemsSummary = [];

            // 2) تحقق stock وحساب total
            foreach ($cartItems as $item) {
                $product = $item->product;
                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    throw new \Exception("Product '{$product->name}' is out of stock");
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

            // 3) إنشاء الطلب
            $order = $user->orders()->create([
                'address_id' => $address->id,
                'total' => $total
            ]);

            // 4) إنشاء عناصر الطلب وتحديث المخزون
            foreach ($cartItems as $item) {
                $product = $item->product;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                    'subtotal' => $product->price * $item->quantity
                ]);

                $product->decrement('stock', $item->quantity);
                $product->status = $product->stock == 0 ? 'out_of_stock' : 'in_stock';
                $product->save();
            }

            $user->cartItems()->delete();

            DB::commit();

            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

