<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Concerts',
                'slug' => 'concerts',
                'status' => 'active',
                'type' => 'events',
                'user_id' => 1, 
            ],
            [
                'name' => 'Conferences',
                'slug' => 'conferences',
                'status' => 'active',
                'type' => 'events',
                'user_id' => 1,
            ],
            [
                'name' => 'Circus',
                'slug' => 'circus',
                'status' => 'active',
                'type' => 'events',
                'user_id' => 1,
            ],
            [
                'name' => 'Workshops',
                'slug' => 'workshops',
                'status' => 'inactive',
                'type' => 'events',
                'user_id' => 1,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
