<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class ImportDataFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from JSON files';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Чтение categories.json
        $categoriesJson = file_get_contents(storage_path('app/categories.json'));
        $categories = json_decode($categoriesJson, true);

        foreach ($categories as $categoryData) {
            // Валидация данных (например, проверка наличия external_id и title)
            if (!isset($categoryData['external_id'], $categoryData['title'])) {
                $this->error('Invalid category data: ' . json_encode($categoryData));
            }

            // Создание или обновление категории
            Category::query()
                ->updateOrCreate(['external_id' => $categoryData['external_id']], $categoryData);
        }

        // Чтение products.json
        $productsJson = file_get_contents(storage_path('app/products.json'));
        $products = json_decode($productsJson, true);

        foreach ($products as $productData) {
            // Валидация данных (например, проверка наличия external_id, title и price)
            if (!isset($productData['external_id'],
                $productData['title'], $productData['price'])) {
                $this->error('Invalid product data: ' . json_encode($productData));
            }

            // Создание или обновление продукта
            Product::query()
                ->updateOrCreate(['external_id' => $productData['external_id']], $productData);
        }

        $this->info('Data imported successfully!');
    }
}
