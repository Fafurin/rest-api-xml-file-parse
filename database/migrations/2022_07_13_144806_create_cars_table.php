<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('year_id');
            $table->unsignedBigInteger('run');
            $table->unsignedBigInteger('color_id');
            $table->unsignedBigInteger('body_type_id');
            $table->unsignedBigInteger('engine_type_id');
            $table->unsignedBigInteger('transmission_id');
            $table->unsignedBigInteger('gear_type_id');

            $table->index('year_id', 'car_year_idx');
            $table->index('color_id', 'car_color_idx');
            $table->index('body_type_id', 'car_body_type_idx');
            $table->index('engine_type_id', 'car_engine_type_idx');
            $table->index('transmission_id', 'car_transmission_idx');
            $table->index('gear_type_id', 'car_gear_type_idx');

            $table->foreign('year_id', 'car_year_fk')->on('years')->references('id')->onDelete('cascade');
            $table->foreign('color_id', 'car_color_fk')->on('colors')->references('id')->onDelete('cascade');
            $table->foreign('body_type_id', 'car_body_type_fk')->on('body_types')->references('id')->onDelete('cascade');
            $table->foreign('engine_type_id', 'car_engine_type_fk')->on('engine_types')->references('id')->onDelete('cascade');
            $table->foreign('transmission_id', 'car_transmission_fk')->on('transmissions')->references('id')->onDelete('cascade');
            $table->foreign('gear_type_id', 'car_gear_type_fk')->on('gear_types')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
