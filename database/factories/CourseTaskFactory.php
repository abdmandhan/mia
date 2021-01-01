<?php

namespace Database\Factories;

use App\Models\CourseTask;
use App\Models\Difficulty;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'              => 'Latihan' . $this->faker->numberBetween(1, 100),
            'difficulty_id'     => Difficulty::all()->random()->id,
        ];
    }
}
