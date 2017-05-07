<?php

use App\User;
use App\UserGroup;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $group = UserGroup::create([
            'name' => 'administrator'
        ]);

        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@calendar.app',
            'password' => bcrypt('123456'),
            'is_active' => 1
        ]);

        $user->groups()->attach($group);
    }
}
