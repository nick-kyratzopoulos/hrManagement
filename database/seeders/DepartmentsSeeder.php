<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = Department::factory()->times(5)->hasMany(User::factory())->create();

        $users = User::all();

        $users->each(function($user) use ($departments) {
            $id = $departments->random(1)->id;

            $user->update(['department_id' => (int)$id]);
        });
    }
}
