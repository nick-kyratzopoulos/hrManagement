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
        $departments = Department::factory()->times(10)->create();
        $users       = User::all();

        $users->each(function($user) use ($departments) {
            $id = $departments->random(1)->pluck('id')[0];

            $user->update(['department_id' => (int)$id]);
        });
    }
}
