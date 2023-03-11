<?php

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
        $this->call(LaratrustSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(KlienTableSeeder::class);
        $this->call(PemasokTableSeeder::class);
        $this->call(GeneralSettingTableSeeder::class);
    }
}
