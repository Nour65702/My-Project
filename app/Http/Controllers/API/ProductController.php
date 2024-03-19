<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Helpers\ApiResponse;
use App\Helpers\FileHelper;
use App\Notifications\ProductStatusNotification;
use App\Services\ProductNotificationService;
use App\Services\ProductService;
use App\Http\Requests\StoreProductFormRequest;
use Illuminate\Http\Request;



class ProductController extends Controller
{

    private $notificationService;
    private $productService;

    public function __construct(ProductNotificationService $notificationService, ProductService $productService)
    {
        $this->notificationService = $notificationService;
        $this->productService = $productService;
    }


    public function index()
    {
        $this->authorize('viewAny', Product::class);
        $products = Product::with('imageable')->get();

        $products->transform(function ($product) {
            FileHelper::getImageUrl($product);
            return $product;
        });

        return ApiResponse::success(['products' => $products]);
    }


    public function store(StoreProductFormRequest $request)
    {
        $this->authorize('create', Product::class);
        try {
            $productData = array_merge($request->validated(), ['status' => 'pending']);
            $product = Product::create($productData);


            $this->notificationService->notifyAdminAboutProduct($product);

            return response()->json([
                'product' => $product,
                'message' => 'The product added successfully. Please wait for admin approval.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('view', $product);
        FileHelper::getImageUrl($product);

        return ApiResponse::success(['product' => $product]);
    }

    public function update(StoreProductFormRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);

        try {
            $validatedData = $request->validated();
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
        $this->authorize('delete', $product);
        $product->delete();

        return ApiResponse::success([

            'message' => 'Product deleted successfully'
        ]);
    }


    public function updateStatus(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $this->authorize('update', $product);
            $request->validate([
                'status' => 'required|in:approved,rejected',
            ]);

            $this->productService->updateStatus($product, $request->status);

            return response()->json([
                'message' => 'Product status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
