<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProductAddedNotification;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'category_id', 'user_id','status'
    ];

    protected $appends = ['created_from'];

    public function getCreatedFromAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imageable()
    {
        return $this->morphMany(Images::class, 'imageable');
    }
   
}
