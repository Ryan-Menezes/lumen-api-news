<?php

namespace Database\Factories;

use App\Models\NoticeImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticeImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NoticeImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'notice_id' => rand(1, 10),
            'source' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence(),
            'active' => $this->faker->boolean(),
        ];
    }
}
