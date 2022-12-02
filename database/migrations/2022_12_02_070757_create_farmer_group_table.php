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
        Schema::create('farmer_group', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('address', 255);
            $table->unsignedBigInteger('farmer_id');
            $table->string('type', 60);
            $table->date('year_founded');
            $table->string('status', 20);
            $table->string('authorization', 255);
            $table->foreign('farmer_id')->references('user_id')->on('farmers');
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
        Schema::dropIfExists('farmer_group');
    }
};
