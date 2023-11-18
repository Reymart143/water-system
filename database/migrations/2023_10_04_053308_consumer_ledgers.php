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
        Schema::create('consumer_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('customerName')->nullable();
            $table->string('account_id')->nullable();
            $table->date('transact_date')->nullable();
            $table->string('particular')->nullable();
            $table->string('or_no')->nullable();
            $table->float('issuance')->nullable();
            $table->float('collection')->nullable();
            $table->float('balance')->nullable();
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
        //
    }
};
