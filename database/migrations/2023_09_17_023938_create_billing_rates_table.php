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
        Schema::create('billing_rates', function (Blueprint $table) {
            $table->id();
            $table->string('billingrate_name');
            $table->string('rate_case');
            $table->string('classification');
            $table->string('minVol');
            $table->string('maxVol');
            $table->string('minAmount');
            $table->string('increment');
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
        Schema::dropIfExists('billing_rates');
    }
};
