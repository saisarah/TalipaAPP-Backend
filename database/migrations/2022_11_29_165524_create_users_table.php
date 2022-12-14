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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 64);
            $table->string('middlename', 64)->nullable();
            $table->string('lastname', 64);
            $table->string('contact_number', 10)->unique();
            $table->string('email', 255)->unique()->nullable();
            $table->string('user_type', 7);
            $table->string('gender', 6)->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('password', 255);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
