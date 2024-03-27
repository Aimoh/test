<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory(50000)->create();

        Category::factory(20)->create();

        for ($i = 1; $i <= 50000; $i++) {

            $data[] = [
                'product_id' => $i,
                'category_id' => rand(1, 20),
            ];
        }

        DB::table('product_category')->insert($data);
    }
}
