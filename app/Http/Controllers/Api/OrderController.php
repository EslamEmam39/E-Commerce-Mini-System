<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

        protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

       public function index(){
          return OrderResource::collection(
              Order::with(['items.product', 'address'])->get()
         );
       }
        public function store(StoreOrderRequest $request)
      {

        $user = $request->user();
        $cartItems = $user->cartItems()->with('product')->get();

            if($cartItems->isEmpty()) {
                return ApiResponse::error([], 'Cart is empty', 400);
            }


        try {

        $order = $this->orderService->createOrder($user, $cartItems, $request->only(['address','phone']));

         return ApiResponse::success(
             new OrderResource($order),);

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
      }
}
