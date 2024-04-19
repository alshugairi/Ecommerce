<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = [];
        $languages = Language::all();

        foreach ($languages as $language) {
            $names[$language->code] = $this->faker->unique()->words(2, true);
        }

        return [
            'name' => $names,
        ];
    }
}
