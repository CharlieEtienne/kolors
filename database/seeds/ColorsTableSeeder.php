<?php

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            [ 'name' => "white", 'code' => "#ffffff", 'palette_id' => 2 ],
            [ 'name' => "black", 'code' => "#000000", 'palette_id' => 2 ],
            [ 'name' => "red", 'code' => "#FF5370", 'palette_id' => 2 ],
            [ 'name' => "orange", 'code' => "#F78C6C", 'palette_id' => 2 ],
            [ 'name' => "yellow", 'code' => "#FFCB6B", 'palette_id' => 2 ],
            [ 'name' => "green", 'code' => "#C3E88D", 'palette_id' => 2 ],
            [ 'name' => "cyan", 'code' => "#89DDFF", 'palette_id' => 2 ],
            [ 'name' => "blue", 'code' => "#82AAFF", 'palette_id' => 2 ],
            [ 'name' => "paleblue", 'code' => "#B2CCD6", 'palette_id' => 2 ],
            [ 'name' => "purple", 'code' => "#C792EA", 'palette_id' => 2 ],
            [ 'name' => "brown", 'code' => "#C17E70", 'palette_id' => 2 ],
            [ 'name' => "pink", 'code' => "#f07178", 'palette_id' => 2 ],
            [ 'name' => "violet", 'code' => "#bb80b3", 'palette_id' => 2 ],
        ];

        DB::table('colors')->insert($colors);
    }
}
