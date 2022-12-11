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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('crop_id');
            $table->string('author_type', 20);
            $table->string('caption', 255);
            $table->string('payment_option', 5);
            $table->string('delivery_option', 20);
            $table->string('unit', 20);
            $table->string('pricing_type', 20);
            $table->string('status', 10);
            $table->string('min_order', 20);
            $table->timestamps();
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
        Schema::dropIfExists('post');
    }
};
