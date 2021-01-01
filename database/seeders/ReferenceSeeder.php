<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Education;
use App\Models\Golongan;
use App\Models\Grade;
use App\Models\Position;
use App\Models\QuestionType;
use App\Models\TransactionStatus;
use App\Models\UserType;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ReferenceSeeder extends Seeder
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

        $user_types = [
            ['name' => 'Admin'],
            ['name' => 'Teacher'],
            ['name' => 'Student'],
        ];

        UserType::insert($user_types);

        //position teacher
        $position_teacher = [
            ['name'  => 'Ketua'],
            ['name'  => 'Wakil'],
            ['name'  => 'Sekretaris'],
            ['name'  => 'Bendahara'],
        ];
        Position::insert($position_teacher);

        //education teacher
        $education_teacher = [
            ['name' => 'SD'],
            ['name' => 'SMP'],
            ['name' => 'SMA'],
            ['name' => 'D1'],
            ['name' => 'D2'],
            ['name' => 'D3'],
            ['name' => 'D4'],
            ['name' => 'S1'],
            ['name' => 'S2'],
            ['name' => 'S3'],
        ];
        Education::insert($education_teacher);


        //golongan teacher
        $golongan_teacher = [
            ['name' => 'I'],
            ['name' => 'II'],
            ['name' => 'III'],
        ];
        Golongan::insert($golongan_teacher);

        //grades
        $data = [
            ['name' => 'VII'],
            ['name' => 'VIII'],
            ['name' => 'IX'],
        ];

        Grade::insert($data);


        //question type
        $data = [
            ['name' => 'PG'],
            ['name' => 'ESSAY'],
        ];

        QuestionType::insert($data);

        //transaction status
        $transaction_status = [
            ['name'  => 'PENDING', 'color' => 'warning'],
            ['name'  => 'FINISH', 'color' => 'success'],
            ['name'  => 'REJECT', 'color' => 'error'],
        ];

        TransactionStatus::insert($transaction_status);

        for ($i = 0; $i < 10; $i++) {
            Announcement::create([
                'user_id'   => $faker->numberBetween(1, 3),
                'title'     => $faker->sentence(),
                'content'   => $faker->paragraph()
            ]);
        }
    }
}
