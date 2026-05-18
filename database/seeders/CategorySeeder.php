<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi'],
            ['name' => 'Non-Fiksi'],
            ['name' => 'Sains & Teknologi'],
            ['name' => 'Sastra & Seni'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
