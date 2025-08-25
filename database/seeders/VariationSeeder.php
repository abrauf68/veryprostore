<?php

namespace Database\Seeders;

use App\Models\Variation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variations = [
            ['name' => 'Color', 'slug' => 'color', 'type' => 'color'],
            ['name' => 'Size', 'slug' => 'size', 'type' => 'size'],
        ];

        foreach ($variations as $variation) {
            Variation::create($variation);
        }
    }
}
