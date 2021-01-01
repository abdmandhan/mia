<?php

namespace Database\Seeders;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\User;
use Illuminate\Database\Seeder;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::all(['id']);

        foreach ($user as $key => $value) {
            Discussion::factory(2)->create([
                'user_id'   => $value
            ])->each(function ($data) {
                DiscussionReply::factory(2)->create([
                    'discuss_id'    => $data->id,
                ]);
            });
        }
    }
}
