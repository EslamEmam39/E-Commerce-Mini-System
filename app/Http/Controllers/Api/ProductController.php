<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     // Get all products
        public function index()
    {
         $products = Product::latest()->paginate(10);

    return ApiResponse::success(new ProductCollection($products));

    } // end index


    // Create product
    public function store(ProductStoreRequest $request)
    {

      $status = $request->stock == 0 ? 'out_of_stock' : 'in_stock';

      $product =   Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $status
      ]);

      return ApiResponse::success(
        new ProductResource($product),
        null,
        'Product created successfully',
        201
    );
    } // end store


    // Update product
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return ApiResponse::error(
                null,
                'Product not found',
                404
            );
        }

         $product->update($request->only(['name','description','price','stock']));

        $product->status = $product->stock == 0 ? 'out_of_stock' : 'in_stock';
        $product->save();

       return ApiResponse::success(
        new ProductResource($product),
        null,
        'Product updated successfully'
    );
    } // end update


    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return ApiResponse::success(
            null,
            null,
            'Product deleted successfully'
        );
    } // end destroy

}
