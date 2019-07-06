<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('gender_id');
            $table->integer('age');
            $table->integer('height');
            $table->integer('weight');
            $table->unsignedInteger('activity_id');
            $table->integer('maintain_weight')->default(0);
            $table->integer('lose_weight')->default(0);
            $table->integer('lose_weight_fast')->default(0);
            $table->timestamps();

            $table->foreign('gender_id')
            ->references('id')->on('genders')
            ->onDelete('cascade');
            $table->foreign('activity_id')
            ->references('id')->on('activity')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
