<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(20)->hasTimesheets(5)->create()->each(function($user){
            $department = Department::inRandomOrder()->first();
            $user->department()->associate($department)->save();
        });
    }
}
