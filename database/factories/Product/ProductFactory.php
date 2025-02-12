<?php

namespace Database\Factories\Product;

use App\Models\Brand;
use Illuminate\Support\Str;
use App\Models\Product\Product;
use App\Models\Product\Category;
use App\Enums\GenderIdentification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product\Product>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = 'Product-' .  $this->faker->words(2, true); // Generate a random name
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'description' => $this->faker->paragraph(),
            'volume' => $this->faker->randomElement([30, 50, 75, 100]),
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 500, 5000),
            'discount' => $this->faker->randomFloat(2, 0, 100),
            'images' => json_encode([$this->faker->imageUrl(640, 480, 'perfume')]),
            'gender' => $this->faker->randomElement(GenderIdentification::cases())->value,
        ];
    }
}
