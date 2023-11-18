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
        Schema::create('encoders', function (Blueprint $table) {
            $table->id();
            $table->string('account_id');
            $table->string('customerName');
            $table->string('previous_reading');
            $table->string('current_reading')->nullable();
            $table->string('amount_bill');
            $table->string('cluster');
            $table->string('volume');
            $table->date('from_reading_date');
            $table->date('date_delivered');
            $table->string('Reader');  
            $table->string('rate_case');
            $table->string('classification');
           
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encoders');
    }
};
