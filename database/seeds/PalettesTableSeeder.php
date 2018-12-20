<?php

use Illuminate\Database\Seeder;

class PalettesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('palettes')->insert([
            [
                'name' => 'Scheme',
                'project_id' => 1,
            ],
            [
                'name' => 'Base',
                'project_id' => 1,
            ]
        ]);
    }
}
