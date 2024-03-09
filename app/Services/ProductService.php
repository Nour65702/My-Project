<?php

namespace App\Services;

use App\Models\Product;
use App\Notifications\ProductStatusNotification;

class ProductService
{
    public function updateStatus(Product $product, string $status): void
    {
        $product->status = $status;
        $product->save();

        $product->user->notify(new ProductStatusNotification($product, $status));
    }
}
