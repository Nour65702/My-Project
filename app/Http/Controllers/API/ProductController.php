<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Helpers\ApiResponse;
use App\Helpers\FileHelper;
use App\Http\Requests\StoreProductFormRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('imageable')->get();

        $products->transform(function ($product) {
            FileHelper::getImageUrl($product);
            return $product;
        });

        return ApiResponse::success(['products' => $products]);
    }

    public function store(StoreProductFormRequest $request)
    {
        $validatedData = $request->validated();

        $product = Product::create($validatedData);

        FileHelper::getImageUrl($request, $product);

        return ApiResponse::success([

            'message' => 'Product created successfully',
            'product' => $product
        ]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        FileHelper::getImageUrl($product);

        return ApiResponse::success(['product' => $product]);
    }

    public function update(StoreProductFormRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $product = Product::findOrFail($id);
            $product->update($validatedData);

            return ApiResponse::success([

                'message' => 'Product updated successfully'
            ]);
        } catch (\Exception $e) {
            return ApiResponse::error([

                'success' => false,
                'message' => 'Failed to update product.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return ApiResponse::success([

            'message' => 'Product deleted successfully'
        ]);
    }
}
