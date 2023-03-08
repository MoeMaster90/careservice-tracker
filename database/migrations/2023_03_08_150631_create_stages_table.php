<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stage_type_id');
            $table->unsignedBigInteger('patient_id')->nullable(true);
            $table->text('extra_notes');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->timestamps();

            $table->foreign('stage_type_id')->references('id')->on('stage_types');
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stages');
    }
};
