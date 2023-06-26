<?php

namespace Database\Factories;

use App\Models\Notice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NoticeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        $subtitle = $this->faker->sentence();

        return [
            'author_id' => rand(1, 10),
            'title' => $title,
            'subtitle' => $subtitle,
            // 'slug' => Str::slug($title . '-' . $subtitle),
            'description' => $this->faker->sentence(),
            'active' => $this->faker->boolean(),
            'published_at' => $this->faker->dateTime(),
        ];
    }
}
