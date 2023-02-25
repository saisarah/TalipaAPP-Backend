<?php

use App\Models\PaymongoTransaction;
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
        Schema::create('paymongo_transactions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id');
            $table->string('status')->default(PaymongoTransaction::STATUS_PENDING);
            $table->decimal('amount', 9,3);
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
        Schema::dropIfExists('paymongo_transactions');
    }
};
