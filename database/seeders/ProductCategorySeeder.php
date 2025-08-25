<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define categories with their hierarchy
        $categories = [
            [
                'name' => 'Fashion',
                'icon' => 'w-icon-tshirt2',
                'image' => 'frontAssets/images/demos/demo1/categories/2-1.jpg',
                'description' => 'Explore the latest in fashion for men and women.',
                'is_popular' => '1',
                'children' => [
                    [
                        'name' => 'Women',
                        'children' => [
                            ['name' => 'New Arrivals'],
                            ['name' => 'Best Sellers'],
                            ['name' => 'Trending'],
                            ['name' => 'Clothing'],
                            ['name' => 'Shoes'],
                            ['name' => 'Bags'],
                            ['name' => 'Accessories'],
                            ['name' => 'Jewelry & Watches'],
                        ]
                    ],
                    [
                        'name' => 'Men',
                        'children' => [
                            ['name' => 'New Arrivals'],
                            ['name' => 'Best Sellers'],
                            ['name' => 'Trending'],
                            ['name' => 'Clothing'],
                            ['name' => 'Shoes'],
                            ['name' => 'Bags'],
                            ['name' => 'Accessories'],
                            ['name' => 'Jewelry & Watches'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Home & Garden',
                'icon' => 'w-icon-home',
                'image' => 'images/categories/home_garden.jpg',
                'description' => 'Everything you need for your home and garden.',
                'is_popular' => '0',
                'children' => [
                    [
                        'name' => 'Bedroom',
                        'children' => [
                            ['name' => 'Beds, Frames & Bases'],
                            ['name' => 'Dressers'],
                            ['name' => 'Nightstands'],
                            ['name' => 'Kid\'s Beds & Headboards'],
                            ['name' => 'Armoires'],
                        ]
                    ],
                    [
                        'name' => 'Living Room',
                        'children' => [
                            ['name' => 'Coffee Tables'],
                            ['name' => 'Chairs'],
                            ['name' => 'Tables'],
                            ['name' => 'Futons & Sofa Beds'],
                            ['name' => 'Cabinets & Chests'],
                        ]
                    ],
                    [
                        'name' => 'Office',
                        'children' => [
                            ['name' => 'Office Chairs'],
                            ['name' => 'Desks'],
                            ['name' => 'Bookcases'],
                            ['name' => 'File Cabinets'],
                            ['name' => 'Breakroom Tables'],
                        ]
                    ],
                    [
                        'name' => 'Kitchen & Dining',
                        'children' => [
                            ['name' => 'Dining Sets'],
                            ['name' => 'Kitchen Storage Cabinets'],
                            ['name' => 'Bakers Racks'],
                            ['name' => 'Dining Chairs'],
                            ['name' => 'Dining Room Tables'],
                            ['name' => 'Bar Stools'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Electronics',
                'icon' => 'w-icon-electronics',
                'image' => 'frontAssets/images/demos/demo1/categories/2-6.jpg',
                'description' => 'Latest technology and electronic devices.',
                'is_popular' => '1',
                'children' => [
                    [
                        'name' => 'Laptops & Computers',
                        'children' => [
                            ['name' => 'Desktop Computers'],
                            ['name' => 'Monitors'],
                            ['name' => 'Laptops'],
                            ['name' => 'Hard Drives & Storage'],
                            ['name' => 'Computer Accessories'],
                        ]
                    ],
                    [
                        'name' => 'TV & Video',
                        'children' => [
                            ['name' => 'TVs'],
                            ['name' => 'Home Audio Speakers'],
                            ['name' => 'Projectors'],
                            ['name' => 'Media Streaming Devices'],
                        ]
                    ],
                    [
                        'name' => 'Digital Cameras',
                        'children' => [
                            ['name' => 'Digital SLR Cameras'],
                            ['name' => 'Sports & Action Cameras'],
                            ['name' => 'Camera Lenses'],
                            ['name' => 'Photo Printer'],
                            ['name' => 'Digital Memory Cards'],
                        ]
                    ],
                    [
                        'name' => 'Cell Phones',
                        'children' => [
                            ['name' => 'Carrier Phones'],
                            ['name' => 'Unlocked Phones'],
                            ['name' => 'Phone & Cellphone Cases'],
                            ['name' => 'Cellphone Chargers'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Furniture',
                'icon' => 'w-icon-furniture',
                'image' => 'frontAssets/images/demos/demo1/categories/2-2.jpg',
                'description' => 'Quality furniture for every room.',
                'is_popular' => '1',
                'children' => [
                    [
                        'name' => 'Furniture',
                        'children' => [
                            ['name' => 'Sofas & Couches'],
                            ['name' => 'Armchairs'],
                            ['name' => 'Bed Frames'],
                            ['name' => 'Beside Tables'],
                            ['name' => 'Dressing Tables'],
                        ]
                    ],
                    [
                        'name' => 'Lighting',
                        'children' => [
                            ['name' => 'Light Bulbs'],
                            ['name' => 'Lamps'],
                            ['name' => 'Ceiling Lights'],
                            ['name' => 'Wall Lights'],
                            ['name' => 'Bathroom Lighting'],
                        ]
                    ],
                    [
                        'name' => 'Home Accessories',
                        'children' => [
                            ['name' => 'Decorative Accessories'],
                            ['name' => 'Candles & Holders'],
                            ['name' => 'Home Fragrance'],
                            ['name' => 'Mirrors'],
                            ['name' => 'Clocks'],
                        ]
                    ],
                    [
                        'name' => 'Garden & Outdoors',
                        'children' => [
                            ['name' => 'Garden Furniture'],
                            ['name' => 'Lawn Mowers'],
                            ['name' => 'Pressure Washers'],
                            ['name' => 'All Garden Tools'],
                            ['name' => 'Outdoor Dining'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Healthy & Beauty',
                'icon' => 'w-icon-heartbeat',
                'image' => 'images/categories/healthy_beauty.jpg',
                'description' => 'Products for health and beauty.',
                'is_popular' => '0',
            ],
            [
                'name' => 'Gift Ideas',
                'icon' => 'w-icon-gift',
                'image' => 'images/categories/gift_ideas.jpg',
                'description' => 'Perfect gifts for any occasion.',
                'is_popular' => '0',
            ],
            [
                'name' => 'Toy & Games',
                'icon' => 'w-icon-gamepad',
                'image' => 'frontAssets/images/demos/demo1/categories/2-5.jpg',
                'description' => 'Fun toys and games for all ages.',
                'is_popular' => '1',
            ],
            [
                'name' => 'Cooking',
                'icon' => 'w-icon-ice-cream',
                'image' => 'images/categories/cooking.jpg',
                'description' => 'Kitchen and cooking essentials.',
                'is_popular' => '0',
            ],
            [
                'name' => 'Smart Phones',
                'icon' => 'w-icon-ios',
                'image' => 'images/categories/smart_phones.jpg',
                'description' => 'Latest smartphones and accessories.',
                'is_popular' => '0',
            ],
            [
                'name' => 'Cameras & Photo',
                'icon' => 'w-icon-camera',
                'image' => 'images/categories/cameras_photo.jpg',
                'description' => 'Photography equipment and accessories.',
                'is_popular' => '0',
            ],
            [
                'name' => 'Accessories',
                'icon' => 'w-icon-ruby',
                'image' => 'frontAssets/images/demos/demo1/categories/2-6.jpg',
                'description' => 'Various accessories for all categories.',
                'is_popular' => '1',
            ],
        ];

        // Insert categories
        $this->insertCategories($categories);
    }

    /**
     * Recursively insert categories and their children.
     *
     * @param array $categories
     * @param int|null $parentId
     * @return void
     */
    private function insertCategories($categories, $parentId = null)
    {
        foreach ($categories as $category) {
            // Insert parent category
            $categoryId = DB::table('product_categories')->insertGetId([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'] ?? null,
                'image' => $category['image'] ?? null,
                'description' => $category['description'] ?? null,
                'is_active' => 'active',
                'is_popular' => $category['is_popular'] ?? '0',
                'parent_category_id' => $parentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert child categories if they exist
            if (isset($category['children'])) {
                $this->insertCategories($category['children'], $categoryId);
            }
        }
    }
}
