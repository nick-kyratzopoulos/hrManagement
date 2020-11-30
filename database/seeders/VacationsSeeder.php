<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vacation;
use Illuminate\Database\Seeder;

class VacationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vacations = Vacation::factory()->times(5)->create();

        $users = User::all();

        $vacations->each(function($vacation) use ($users) {
            $id = $users->random(1)->pluck('id')[0];

            $vacation->update(['user_id' => (int)$id]);
        });
    }
}
