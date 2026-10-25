<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
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
        $name = fake()->unique()->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 9999),
            'category' => fake()->randomElement(['Software', 'Consulting', 'Cloud Services', 'Hardware', 'Training']),
            'price' => fake()->randomFloat(2, 29, 999),
            'stock' => fake()->numberBetween(5, 100),
            'short_description' => fake()->sentence(12),
            'description' => fake()->paragraphs(3, true),
            'image_path' => null,
            'is_active' => true,
            'is_featured' => fake()->boolean(30),
        ];
    }

    /**
     * Indicate that the product is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the product is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
