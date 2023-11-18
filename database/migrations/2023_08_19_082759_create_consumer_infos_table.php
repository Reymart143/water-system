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
        Schema::create('consumer_infos', function (Blueprint $table) {
            $table->id();
            $table->string('account_id');
            $table->string('customerName');
            $table->string('connectionDate');
            $table->string('rate_case');
            $table->string('classification');
            $table->string('cluster');
            $table->string('consumerName2')->nullable();
         
            $table->string('trade1')->nullable();
            $table->string('trade2')->nullable();
            $table->string('concessionerName')->nullable();
            $table->string('meter');
            $table->string('region');
            $table->string('municipality');
            $table->string('barangay');
            $table->string('purok');
            $table->string('Province');
            $table->string('status')->default(0);
            $table->string('updatestatusDate')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumer_infos');
    }
};
