<?php

namespace App\Services;


use App\Models\User;
use App\Models\Product;
use App\Notifications\ProductAddedNotification;

class ProductNotificationService
{
    public function notifyAdminAboutProduct(Product $product)
    {
        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->first();

        if ($admin) {
            $admin->notify(new ProductAddedNotification($product));
        }
    }
}
