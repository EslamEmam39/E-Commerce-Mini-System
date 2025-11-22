<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
      $products = \App\Models\Product::count();
      $orders = \App\Models\Order::count();

      return ApiResponse::success([
          'data' => [
              'products' => $products,
              'orders' => $orders
          ]
      ]);
    }
}
