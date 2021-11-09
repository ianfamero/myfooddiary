<?php

use Illuminate\Database\Seeder;

class DietTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diet_types')->insert([
            'diet' => 'Ketogenic (5% carb, 75% fat, 20% protein)',
            'percent_carbs' => 5,
            'percent_fats' => 75,
            'percent_proteins' => 20 
        ]);

        DB::table('diet_types')->insert([
            'diet' => 'Atkins (9% carb, 62% fat, 29% protein)',
            'percent_carbs' => 9,
            'percent_fats' => 62,
            'percent_proteins' => 29 
        ]);

        DB::table('diet_types')->insert([
            'diet' => 'LCHF (Low Carb, High Fat) (15% carb, 65% fat, 20% protein)',
            'percent_carbs' => 15,
            'percent_fats' => 65,
            'percent_proteins' => 20 
        ]);

        DB::table('diet_types')->insert([
            'diet' => 'Paleo (33% carb, 45% fat, 22% protein)',
            'percent_carbs' => 33,
            'percent_fats' => 45,
            'percent_proteins' => 22 
        ]);

        DB::table('diet_types')->insert([
            'diet' => 'Mediteranean (38% carb, 46% fat, 16% protein)',
            'percent_carbs' => 38,
            'percent_fats' => 46,
            'percent_proteins' => 16 
        ]);

        DB::table('diet_types')->insert([
            'diet' => 'Zone Diet (40% carb, 30% fat, 30% protein)',
            'percent_carbs' => 40,
            'percent_fats' => 30,
            'percent_proteins' => 30 
        ]);

        DB::table('diet_types')->insert([
            'diet' => 'American (50% carb, 35% fat, 15% protein)',
            'percent_carbs' => 50,
            'percent_fats' => 35,
            'percent_proteins' => 15 
        ]);

        DB::table('diet_types')->insert([
            'diet' => 'Vegetarian (52% carb, 31% fat, 17% protein)',
            'percent_carbs' => 52,
            'percent_fats' => 31,
            'percent_proteins' => 17 
        ]);

        DB::table('diet_types')->insert([
            'diet' => 'Ornish (75% carb, 7% fat, 18% protein)',
            'percent_carbs' => 75,
            'percent_fats' => 7,
            'percent_proteins' => 18 
        ]);
    }
}
