<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Product;
use App\Models\User;

class ProductAddedNotification extends Notification
{
    use Queueable;

    protected $product;
    

    public function __construct(Product $product)
    {
        $this->product = $product;
       
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->product->id,
            'name' => $this->product->name,
            'user_id' => $this->product->user_id,
            'description' => $this->product->description,
            'price' => $this->product->price,
            'status' => $this->product->status,
        ];
    }
}
