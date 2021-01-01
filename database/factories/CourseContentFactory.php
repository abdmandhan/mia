<?php

namespace Database\Factories;

use App\Models\CourseContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseContent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'desc'          => $this->faker->paragraphs()[0],
            'content'       => $this->faker->paragraphs()[0],
            'file'          => 'storage/other/sample.pdf',
            'url_youtube'   => 'https://www.youtube.com/embed/jQG1q03OaaQ',
        ];
    }
}
