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
        Schema::create('vendor_crops', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('crops_id');
            $table->timestamps();
            $table->foreign('vendor_id')->references('user_id')->on('vendors');
            $table->foreign('crops_id')->references('id')->on('crops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_crops');
    }
};
