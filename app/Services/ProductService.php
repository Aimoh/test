<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function store(array $data): Product
    {
        return Product::query()->create($data);
    }

    public function destroy(string $slug)
    {
        $product = Product::query()->where('slug', $slug)->first();

        if (!$product) {
            return false;
        }

        return $product->delete();
    }
}
