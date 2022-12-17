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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('public_market_id')->nullable();
            $table->string('authorization')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('public_market_id')->references('id')->on('public_markets');
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
        Schema::dropIfExists('vendors');
    }
};
