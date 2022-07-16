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
        Schema::create('generations', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->nullable();
            $table->string('generation_id')->unique()->nullable();
            $table->unsignedBigInteger('car_model_id');

            $table->index('car_model_id', 'generation_car_model_idx');

            $table->foreign('car_model_id', 'generation_car_model_fk')->on('car_models')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generations');
    }
};
