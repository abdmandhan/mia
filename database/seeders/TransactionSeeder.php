<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Transaction;
use App\Models\TransactionStatus;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
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

        $users = User::all(['id', 'name']);

        $courses = Course::all(['id', 'price']);

        $transaction_status = TransactionStatus::all();

        foreach ($users as $key => $value) {
            $course = $courses->random();
            Transaction::create([
                'user_id'               => $value->id,
                'course_id'             => $course->id,
                'transaction_status_id' => $transaction_status->random()->id,
                'transaction_date'      => $faker->date(),
                'amount'                => $course->price,
                'image'                 => 'storage/transaction/0whGB3ZQM1mGTRCbvh5tjd4a7SoMRDZUwf0D71qg.png',
                'account_no'            => $faker->numerify('#########'),
                'account_name'          => $value->name
            ]);
        }
    }
}
