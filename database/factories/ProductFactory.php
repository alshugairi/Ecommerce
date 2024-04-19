<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = [];
        $descriptions = [];
        $languages = Language::all();

        foreach ($languages as $language) {
            $names[$language->code] = $this->faker->unique()->words(3, true);
            $descriptions[$language->code] = $this->faker->paragraph();
        }

        return [
            'name' => $names,
            'description' => $descriptions,
            'price' => $this->faker->numberBetween(100, 1000),
            'quantity' => $this->faker->numberBetween(10, 100),
            'category_id' => Category::inRandomOrder()->first()->id,
            'image' => $this->faker->imageUrl(),
            'created_by' => 1,
            'updated_by' => 1
        ];
    }
}
