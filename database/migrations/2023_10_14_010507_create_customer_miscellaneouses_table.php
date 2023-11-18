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
        Schema::create('customer_miscellaneouses', function (Blueprint $table) {
            $table->id();
            $table->string('account_id')->nullable();
            $table->string('customerName')->nullable();
            $table->string('miscellaneous_name')->nullable();
            $table->float('amount')->nullable();
            $table->integer('status')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_miscellaneouses');
    }
};
