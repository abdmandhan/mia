<?php

namespace Database\Factories;

use App\Models\Discussion;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscussionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discussion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_type_id'    => $this->faker->numberBetween(1, 3),
            'text'              => $this->faker->paragraph(),
            'is_done'           => $this->faker->numberBetween(0, 1)
        ];
    }
}
