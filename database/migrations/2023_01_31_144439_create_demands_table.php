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
        Schema::create('demands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedDecimal('budget');
            $table->unsignedBigInteger('quantity');
            $table->string('description', 2000);
            $table->string('status', 10)->default("open");
            $table->unsignedBigInteger('crop_id');
            $table->foreign('vendor_id')->references('user_id')->on('vendors');
            $table->foreign('crop_id')->references('id')->on('crops');
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
        Schema::dropIfExists('demands');
    }
};
