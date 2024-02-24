<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Product;
use App\Models\Images;
use Illuminate\Support\Facades\Validator;

class FileHelper
{
    public static function uploadImage($request, $user)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|dimensions:max_width=3840,max_height=2160|mimes:gif,png,jpg|max:2700',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if ($request->hasFile('image')) {
            $filename = self::storeImage($request->file('image'), User::class, $user->id);
            $user->setAttribute('image_path', asset('images/' . $filename));
        }
    }

    public static function setImagePath($user)
    {
        $imagePath = $user->imageable ? 'images/' . $user->imageable->filename : null;
        unset($user->imageable);
        $user->setAttribute('image_path', asset($imagePath));
    }

    public static function uploadImages($request, $product)
    {
        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|dimensions:max_width=3840,max_height=2160|mimes:gif,png,jpg|max:2700',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];

            foreach ($request->file('images') as $image) {
                $filename = self::storeImage($image, Product::class, $product->id);
                $imagePaths[] = asset('images/' . $filename);
            }

            $product->setAttribute('image_paths', $imagePaths);
        }
    }

    public static function setImagePaths($product)
    {
        $imagePaths = [];

        foreach ($product->imageable as $image) {
            $imagePath = 'images/' . $image->filename;
            $imagePaths[] = asset($imagePath);
        }

        $product->setAttribute('image_paths', $imagePaths);
        unset($product->imageable);
    }

    private static function storeImage($image, $type, $id)
    {
        $filename = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $filename);

        Images::create([
            'filename' => $filename,
            'imageable_id' => $id,
            'imageable_type' => $type,
        ]);

        return $filename;
    }
}
