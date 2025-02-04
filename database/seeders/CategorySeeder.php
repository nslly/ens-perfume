<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        Category::factory()->count(10)->create();

    }
}
