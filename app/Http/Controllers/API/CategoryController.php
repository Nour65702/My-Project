<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryFormRequest;
use App\Models\Category;
use App\Helpers\FileHelper;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $this->authorize('viewAny', Category::class);
        $categories = $this->categoryService->getFilteredCategories();
        $categories->transform(function ($category) {
            FileHelper::getImageUrl($category->image);
            return $category;
        });
        return ApiResponse::success(['categories' => $categories]);
    }

    public function store(StoreCategoryFormRequest $request)
    {
        $this->authorize('create', Category::class);
        $validatedData = $request->validated();
        $category = Category::create($validatedData);
        FileHelper::getImageUrl($category->image);

        return ApiResponse::success([
            'message' => 'Category created successfully',
            'category' => $category
        ]);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('view', $category);
        $category = $this->categoryService->getCategoryWithFilteredChildren($id);
        FileHelper::getImageUrl($category->image);
        return ApiResponse::success(['category' => $category]);
    }

    public function update(StoreCategoryFormRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('update', $category);
        $category->update($request->validated());


        return ApiResponse::success([
            'message' => 'Category Updated successfully',
            'category' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('delete', $category);

        $category->delete();

        return ApiResponse::success([
            'message' => 'Category deleted successfully'
        ]);
    }
}
