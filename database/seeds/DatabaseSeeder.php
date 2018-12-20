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
        $this->call(ProjectsTableSeeder::class);
        $this->call(ColorsTableSeeder::class);
        $this->call(PalettesTableSeeder::class);
        $this->call(TyposTableSeeder::class);
    }
}
