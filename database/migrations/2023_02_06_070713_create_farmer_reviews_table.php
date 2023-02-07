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
        Schema::create('farmer_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farmer_id');
            $table->unsignedBigInteger('vendor_id');
            $table->string('comment', 1000);
            $table->string('rate', 255);
            $table->foreign('farmer_id')->references('user_id')->on('farmers');
            $table->foreign('vendor_id')->references('user_id')->on('vendors');
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
        Schema::dropIfExists('farmer_reviews');
    }
};
