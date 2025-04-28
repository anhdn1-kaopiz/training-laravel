<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory {
    protected $model = Category::class;
    public function definition(): array {
        $name = fake()->unique()->words(rand(1, 3), true);
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
        ];
    }
}
