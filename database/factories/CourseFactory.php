<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseType;
use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_premium = $this->faker->numberBetween(0, 1);

        $course_type = CourseType::all()->random();

        return [
            'name'              => $course_type->name . $this->faker->numberBetween(1, 100),
            'desc'              => $this->faker->paragraph(),
            'is_premium'        => $is_premium,
            'price'             => $is_premium ? $this->faker->numberBetween(100, 1000) * 1000 : null,
            'course_type_id'    => $course_type->id,
            'grade_id'          => Grade::all()->random()->id,
        ];
    }
}
