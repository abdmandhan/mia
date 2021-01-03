<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            ReferenceSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            DiscussionSeeder::class,
            TransactionSeeder::class
        ]);

        //absesnsi
        $users = User::all();
        foreach ($users as $key => $value) {
            for ($i = 1; $i <= 20; $i++) {
                $date = date_create("2021-01-$i");
                Absensi::create([
                    'user_id'   => $value->id,
                    'date'      => $date
                ]);
            }
        }
    }
}
