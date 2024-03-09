<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class ProductStatusNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $status;

    public function __construct(Product $product, $status)
    {
        $this->product = $product;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $productName = $this->product->name;
        $status = ucfirst($this->status);

        return (new MailMessage)
            ->subject("Product Status Update")
            ->line("Your product '$productName' has been $status by the admin.")
            ->action('View Product', url('/products/' . $this->product->id));
    }
}
