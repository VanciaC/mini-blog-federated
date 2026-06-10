<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title'     => $this->faker->sentence(),
            'body'      => $this->faker->paragraph(),
            'author_id' => $this->faker->numberBetween(1, 100),
        ];
    }
}