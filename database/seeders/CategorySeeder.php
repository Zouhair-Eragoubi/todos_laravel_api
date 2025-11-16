<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Work', 'description' => 'Work related tasks'],
            ['name' => 'Personal', 'description' => 'Personal tasks and errands'],
            ['name' => 'Shopping', 'description' => 'Shopping lists and purchases'],
            ['name' => 'Health', 'description' => 'Health and fitness related'],
            ['name' => 'Study', 'description' => 'Learning and education'],
            ['name' => 'Home', 'description' => 'Home maintenance and chores'],
            ['name' => 'Family', 'description' => 'Family activities and events'],
            ['name' => 'Finance', 'description' => 'Financial tasks and bills'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
