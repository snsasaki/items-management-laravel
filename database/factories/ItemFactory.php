<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word() . ' 備品',
            'category' => $this->faker->randomElement(['PC', '周辺機器', 'AV機器']),
            'location' => $this->faker->randomElement(['東京本社', '大阪支社', '会議室A']),
            'status' => $this->faker->randomElement(['available', 'in_use', 'maintenance']),
            'note' => $this->faker->optional()->sentence(),
        ];
    }
}
