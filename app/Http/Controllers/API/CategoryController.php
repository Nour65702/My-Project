<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryFormRequest;
use App\Models\Category;
use App\Helpers\FileHelper;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['imageable', 'products' => function ($query) {
            $query->where('price', '>=', 150)
                ->with(['user' => function ($query) {
                    $query->where('name', 'like', '%a%');
                }]);
        }])->get();

        $categories->transform(function ($category) {
            FileHelper::setImagePath($category);
            return $category;
        });

        return ApiResponse::success(['categories' => $categories]);
    }

    public function store(StoreCategoryFormRequest $request)
    {
        $validatedData = $request->validated();
        $category = Category::create($validatedData);

        FileHelper::uploadImage($request, $category);

        return ApiResponse::success([

            'message' => 'Category created successfully',
            'category' => $category
        ]);
    }

    public function show($id)
    {
        $category = Category::with(['products' => function ($query) {
            $query->where('price', '>=', 150)
                ->with(['user' => function ($query) {
                    $query->where('name', 'like', '%a%');
                }]);
        }])->findOrFail($id);

        FileHelper::setImagePath($category);

        return ApiResponse::success(['category' => $category]);
    }

    public function update(StoreCategoryFormRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->validated());

        return ApiResponse::success([

            'message' => 'Category Updated successfully',
            'category' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return ApiResponse::success([

            'message' => 'Category deleted successfully'
        ]);
    }
}
