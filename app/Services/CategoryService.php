<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function store($data)
    {
        return Category::query()->create($data);
    }

    public function destroy($slug)
    {
        $category = Category::query()->where('slug', $slug)->first();

        if (!$category) {
            return false;
        }

        return $category->delete();
    }
}
