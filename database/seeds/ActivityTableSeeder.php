<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity')->insert([
            'activity' => 'Sedentary Lifestyle',
        ]);
        DB::table('activity')->insert([
            'activity' => 'Slightly Active',
        ]);
        DB::table('activity')->insert([
            'activity' => 'Moderately Active',
        ]);
        DB::table('activity')->insert([
            'activity' => 'Active Lifestyle',
        ]);
        DB::table('activity')->insert([
            'activity' => 'Very Active Lifestyle',
        ]);
    }
}
