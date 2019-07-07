<?php

use Illuminate\Database\Seeder;

class MealTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meal_types')->insert([
            'meal_type' => 'Breakfast',
        ]);
        DB::table('meal_types')->insert([
            'meal_type' => 'Lunch',
        ]);
        DB::table('meal_types')->insert([
            'meal_type' => 'Dinner',
        ]);
        DB::table('meal_types')->insert([
            'meal_type' => 'Snack',
        ]);
    }
}
