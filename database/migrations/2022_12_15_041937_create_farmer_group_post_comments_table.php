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
        Schema::create('farmer_group_post_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farmer_group_id');
            $table->unsignedBigInteger('farmer_id');
            $table->string('content', 200);
            $table->foreign('farmer_group_id')->references('id')->on('farmer_groups');
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
        Schema::dropIfExists('farmer_group_post_comments');
    }
};