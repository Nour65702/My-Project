<?php

namespace App\Services;

use App\Models\Category;


class CategoryService
{
    public function getFilteredCategories()
    {
        return Category::with(['children.products' => function ($query) {
            $query->where('price', '>=', 150)
                ->with(['user' => function ($query) {
                    $query->where('name', 'like', '%a%');
                }]);
        }])->whereNull('parent_id')->get();
    }

    public function getCategoryWithFilteredChildren($id)
    {
        return Category::with(['children.products' => function ($query) {
            $query->where('price', '>=', 150)
                ->with(['user' => function ($query) {
                    $query->where('name', 'like', '%a%');
                }]);
        }])->findOrFail($id);
    }

}
