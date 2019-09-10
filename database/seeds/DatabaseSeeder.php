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
        $this->call(UsersTableSeeder::class);
        $this->call(SpecialitesTableSeeder::class);
        $this->call(MedecinsTableSeeder::class);
        $this->call(FormationsTableSeeder::class);
    }
}
