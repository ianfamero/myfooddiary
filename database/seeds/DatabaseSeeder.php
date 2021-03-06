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
        $this->call(GendersTableSeeder::class);
        $this->call(ActivityTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(MealTypesTableSeeder::class);
        $this->call(DietTypeTableSeeder::class);
    }
}
