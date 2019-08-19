<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommedationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendation_matrix', function (Blueprint $table) {
            $table->integer('zip');
            $table->text('community');
            $table->float('cost_2018',11,2);
            $table->float('growth_2018',11,10);
            $table->float('growth_2017',11,10);
            $table->float('growth_2016',11,10);
            $table->float('lat',13,10);
            $table->float('long',13,10);
            $table->float('marijuana_dispenseries',11,10);
            $table->float('post_office',11,10);
            $table->float('theme_park',11,10);
            $table->float('atm',11,10);
            $table->float('animal_shelter',11,10);
            $table->float('historic_landmark',11,10);
            $table->float('doctors_and_medicine',11,10);
            $table->float('colleges_and_universities',11,10);
            $table->float('culture',11,10);
            $table->float('clothing_retail',11,10);
            $table->float('personal_grooming',11,10);
            $table->float('retail',11,10);
            $table->float('food_and_beverage_retailer',11,10);
            $table->float('large_retail',11,10);
            $table->float('bars_and_clubs',11,10);
            $table->float('movies_and_theaters',11,10);
            $table->float('drinking',11,10);
            $table->float('parks',11,10);
            $table->float('professional_sports',11,10);
            $table->float('outdoor_athletics',11,10);
            $table->float('indoor_athletics',11,10);
            $table->float('restaurants',11,10);
            $table->float('video_games',11,10);
            $table->float('travel_amenities',11,10);
            $table->float('travel',11,10);
            $table->float('cars',11,10);
            $table->float('water',11,10);
            $table->primary('zip');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recommendation_matrix');
    }
}
