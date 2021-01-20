<?php

namespace Database\Seeders;

use App\Models\Difficulty;
use App\Models\Tryout;
use App\Models\TryoutAnswer;
use App\Models\TryoutQuestion;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TryoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        $faker = Factory::create();

        $data_try_out = [
            [
                'name'              => 'TRY OUT NASIONAL 1',
                'difficulty_id'     => Difficulty::all()->random()->id,
                'date_start'        => '2021-01-01',
                'date_finish'       => '2021-02-01',
                'time'              => '00:30:00',
                'is_show_review'    => 1,
            ],
            [
                'name'              => 'TRY OUT NASIONAL 2',
                'difficulty_id'     => Difficulty::all()->random()->id,
                'date_start'        => '2021-01-01',
                'date_finish'       => '2021-02-01',
                'time'              => '00:30:00',
                'is_show_review'    => 0,
            ]
        ];

        foreach ($data_try_out as $key => $value) {
            $try_out = Tryout::create($value);

            for ($i = 0; $i < 3; $i++) {
                $try_out_question = TryoutQuestion::create([
                    'tryout_id'        => $try_out->id,
                    'question'          => $faker->paragraph(),
                ]);

                for ($j = 0; $j < 4; $j++) {
                    $isTrue = (($j == 0) ? true : false);
                    TryoutAnswer::create([
                        'tryout_question_id'       => $try_out_question->id,
                        'answer'                    => $faker->paragraph(),
                        'is_true'                   => $isTrue
                    ]);
                }
            }
        }
    }
}
