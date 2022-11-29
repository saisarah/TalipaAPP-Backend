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
        Schema::create('crops_variant', function (Blueprint $table) {
            $table->id('crops_id');
            $table->string('name', 60);
            $table->timestamps();
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
        Schema::dropIfExists('crops_variant');
    }
};
