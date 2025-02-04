<?php

namespace Database\Factories\Product;

use Illuminate\Support\Str;
use App\Models\Product\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product\Category>
 */
class CategoryFactory extends Factory
{

    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryName =  'Category '. ucfirst($this->faker->unique()->word());
        return [
            'name' => $categoryName,
            'slug' => Str::slug($categoryName),
        ];
    }
}
