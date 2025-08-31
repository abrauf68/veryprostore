<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create sample products
        $products = [
            [
                'name' => 'Alarm Clock With Lamp',
                'slug' => Str::slug('Alarm Clock With Lamp'),
                'vendor_id' => null,
                'sku' => 'ACWL-123456',
                'short_description' => 'A powerful Alarm Clock with advanced features.',
                'description' => 'The Alarm Clock With Lamp offers a 6.5-inch display, 128GB storage, and a high-performance processor for seamless multitasking.',
                'main_image' => 'frontAssets/images/products/featured/1-800x900.jpg',
                'category_id' => 46,
                'price' => '160.00',
                'profit' => '50.00',
                'discount' => '0',
                'stock' => '150',
                'is_active' => 'active',
                'is_popular' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bodycare Smooth Powder',
                'slug' => Str::slug('Bodycare Smooth Powder'),
                'vendor_id' => null,
                'sku' => 'BSP-789012',
                'short_description' => 'Stylish and comfortable Bodycare Smooth Powder.',
                'description' => 'This Bodycare Smooth Powder is made from 100% organic cotton, offering a soft feel and modern fit for casual wear.',
                'main_image' => 'frontAssets/images/products/accordion/1-800x900.jpg',
                'category_id' => 94,
                'price' => '125.00',
                'profit' => '40',
                'discount' => '0',
                'stock' => '100',
                'is_active' => 'active',
                'is_popular' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Classic Simple Backpack',
                'slug' => Str::slug('Classic Simple Backpack'),
                'vendor_id' => null,
                'sku' => 'CSB-345678',
                'short_description' => 'High-quality Classic Simple Backpack with noise cancellation.',
                'description' => 'Experience immersive sound with these Classic Simple Backpack, featuring active noise cancellation and up to 20 hours of battery life.',
                'main_image' => 'frontAssets/images/products/section/1-800x900.jpg',
                'category_id' => 1,
                'price' => '85.00',
                'profit' => '25.00',
                'discount' => '0',
                'stock' => '30',
                'is_active' => 'active',
                'is_popular' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create sample product images
        $productImages = [
            [
                'product_id' => 1,
                'image' => 'frontAssets/images/products/featured/2-800x900.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'image' => 'frontAssets/images/products/featured/3-800x900.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'image' => 'frontAssets/images/products/featured/4-800x900.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'image' => 'frontAssets/images/products/accordion/2-800x900.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'image' => 'frontAssets/images/products/accordion/3-800x900.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'image' => 'frontAssets/images/products/accordion/4-800x900.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'image' => 'frontAssets/images/products/section/2-800x900.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'image' => 'frontAssets/images/products/section/3-800x900.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'image' => 'frontAssets/images/products/section/4-800x900.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($productImages as $productImage) {
            ProductImage::create($productImage);
        }
    }
}
