<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'Robby',
            'username' => 'robbyismyid1',
            'email' => 'robbyismyid1@gmail.com',
            'password' => bcrypt('sdf749re11'),
            'image' => 'admin.png'
        ]);
        $user->attachRole('super_admin');
    }
}
