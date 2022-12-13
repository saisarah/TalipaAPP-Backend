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
        Schema::create('farmer_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('address', 1000);
            $table->text('group_description');
            $table->string('contact_no');
            $table->string('email');
            $table->unsignedBigInteger('farmer_id');
            $table->string('type', 60);
            $table->string('year_founded');
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
