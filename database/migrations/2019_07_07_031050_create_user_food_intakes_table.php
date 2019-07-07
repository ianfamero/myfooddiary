<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFoodIntakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_food_intakes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->unsignedInteger('meal_type_id');
            $table->unsignedInteger('food_list_id');
            $table->unsignedInteger('profile_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_food_intakes');
    }
}
