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
        Schema::create('stage_treatment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('treatment_id')->nullable(true);
            $table->timestamps();

            $table->foreign('stage_id')->references('id')->on('stages');
            $table->foreign('treatment_id')->references('id')->on('treatments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stage_treatment');
    }
};
