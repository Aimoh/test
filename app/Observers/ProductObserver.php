<?php

namespace App\Observers;

use App\Models\Product;
use App\Notifications\ProductEmailCreatedNotification;
use App\Notifications\ProductEmailUpdatedNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

class ProductObserver
{
    public function updated(Product $product)
    {
        Cache::forget('popularProducts');

        Notification::route('mail', config('mail.email_to_send'))
            ->notify(new ProductEmailUpdatedNotification($product));
    }

    public function created(Product $product)
    {
        Notification::route('mail', config('mail.email_to_send'))
            ->notify(new ProductEmailCreatedNotification($product));
    }
}
