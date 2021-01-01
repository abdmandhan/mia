<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseContent;
use App\Models\CourseTask;
use App\Models\CourseTaskAnswer;
use App\Models\CourseTaskQuestion;
use App\Models\CourseTeacher;
use App\Models\CourseType;
use App\Models\Difficulty;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Factory::create('id_ID');

        CourseType::insert([
            ['name' => 'Matematika'],
            ['name' => 'Fisika'],
            ['name' => 'Biologi'],
        ]);

        Difficulty::insert([
            ['name' => 'Easy', 'color' => 'green'],
            ['name' => 'Medium', 'color' => 'yellow'],
            ['name' => 'Hard', 'color' => 'red'],
        ]);

        $teacher = collect(User::where('user_type_id', 2)->get());

        Course::factory(10)->create()->each(function ($course) use ($teacher, $faker) {
            CourseContent::factory(4)->create([
                'course_id' => $course->id,
                'name'      => $course->name,
            ]);

            $teachers = $teacher->random(3);

            foreach ($teachers as $key => $value) {
                CourseTeacher::create([
                    'course_id'     => $course->id,
                    'teacher_id'    => $value->id
                ]);
            }

            CourseTask::factory(1)->create([
                'course_id' => $course->id
            ])->each(function ($courseTask) use ($faker) {
                for ($i = 0; $i < 3; $i++) {
                    $courseTaskQuestion = CourseTaskQuestion::create([
                        'course_task_id'    => $courseTask->id,
                        'question'          => $faker->paragraph(),
                        'question_type_id'  => 1 //PG
                    ]);

                    for ($j = 0; $j < 4; $j++) {
                        $isTrue = (($j == 0) ? true : false);
                        CourseTaskAnswer::create([
                            'course_task_question_id'   => $courseTaskQuestion->id,
                            'answer'                    => $faker->paragraph(),
                            'is_true'                   => $isTrue
                        ]);
                    }
                }
                //pertanyaan ESSAY
                $courseTaskQuestion = CourseTaskQuestion::create([
                    'course_task_id'    => $courseTask->id,
                    'question'          => $faker->paragraph(),
                    'question_type_id'  => 2 //ESSAY
                ]);
            });
        });
    }
}
