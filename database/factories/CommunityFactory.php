<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    // protected $model = Community::class;


    public function definition()
    {
        $name = $this->faker->text(30);

        return [
            'name' => $name,
            'user_id' => rand(1, 100),
            'description' => $this->faker->text(200),
            'slug' => Str::slug($name)
        ];
    }
}
