<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'parent_id','image'
    ];

    protected $appends = ['created_from'];

    public function getCreatedFromAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function imageable()
    {
        return $this->morphOne(Images::class, 'imageable');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children.products');
    }
}
