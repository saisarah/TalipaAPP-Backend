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
        Schema::create('farmer_crops', function (Blueprint $table) {
            $table->unsignedBigInteger('farmer_id');
            $table->unsignedBigInteger('crop_id');
            $table->foreign('farmer_id')->references('user_id')->on('farmers');
            $table->foreign('crop_id')->references('id')->on('crops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farmer_crops');
    }
};
