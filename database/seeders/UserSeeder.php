<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Golongan;
use App\Models\Grade;
use App\Models\Position;
use App\Models\User;
use App\Models\UserStudent;
use App\Models\UserTeacher;
use App\Models\UserType;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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

        $position = Position::all();
        $education = Education::all();
        $golongan = Golongan::all();
        $grade = Grade::all();


        User::create([
            'user_type_id'  => 1,
            'name'          => 'Islamia',
            'email'         => 'islamia@gmail.com',
            'photo'         => 'storage/user/2.jpg',
            'phone'         => $faker->phoneNumber(),
            'address'       => $faker->address(),
            'password'      => '12341234'
        ]);

        $teacher = User::create([
            'user_type_id'  => 2,
            'name'          => $faker->name(),
            'email'         => 'teacher@gmail.com',
            'photo'         => 'storage/user/2.jpg',
            'phone'         => $faker->phoneNumber(),
            'address'       => $faker->address(),
            'password'      => '12341234'
        ]);

        UserTeacher::create([
            'user_id'       => $teacher->id,
            'position_id'   => $position->random()->id,
            'education_id'  => $education->random()->id,
            'golongan_id'   => $golongan->random()->id
        ]);


        $student = User::create([
            'user_type_id'  => 3,
            'name'          => $faker->name(),
            'email'         => 'student@gmail.com',
            'photo'         => 'storage/user/2.jpg',
            'phone'         => $faker->phoneNumber(),
            'address'       => $faker->address(),
            'password'      => '12341234'
        ]);

        UserStudent::create([
            'user_id'   => $student->id,
            'grade_id'  => $grade->random()->id,
        ]);

        //random data

        for ($i = 0; $i < 10; $i++) {
            $teacher = User::create([
                'user_type_id'  => 2,
                'name'          => $faker->name(),
                'email'         => $faker->email(),
                'photo'         => 'storage/user/2.jpg',
                'phone'         => $faker->phoneNumber(),
                'address'       => $faker->address(),
                'password'      => '12341234'
            ]);

            UserTeacher::create([
                'user_id'       => $teacher->id,
                'position_id'   => $position->random()->id,
                'education_id'  => $education->random()->id,
                'golongan_id'   => $golongan->random()->id
            ]);


            $student = User::create([
                'user_type_id'  => 3,
                'name'          => $faker->name(),
                'email'         => $faker->email(),
                'photo'         => 'storage/user/2.jpg',
                'phone'         => $faker->phoneNumber(),
                'address'       => $faker->address(),
                'password'      => '12341234'
            ]);

            UserStudent::create([
                'user_id'   => $student->id,
                'grade_id'  => $grade->random()->id,
            ]);
        }
    }
}
