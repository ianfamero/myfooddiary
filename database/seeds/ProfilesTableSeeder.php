<?php

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            'gender_id' => 1, 
            'age' => 26, 
            'height' => 163,
            'weight' => 90,
            'activity_id' => 2
        ]);
    }
}
