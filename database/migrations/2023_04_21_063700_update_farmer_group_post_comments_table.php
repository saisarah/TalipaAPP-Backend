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
        Schema::table('farmer_group_post_comments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('farmer_group_id');
            $table->unsignedBigInteger('farmer_group_post_id')->after('id');
            $table->foreign('farmer_group_post_id')->references('id')->on('farmer_group_posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
