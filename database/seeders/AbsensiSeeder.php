<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Database\Seeder;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
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
