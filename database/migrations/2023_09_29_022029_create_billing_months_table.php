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
        Schema::create('billing_months', function (Blueprint $table) {
            $table->id();
            $table->date('billingmonth_date');
            $table->string('billingrate_name')->nullable();
            $table->string('penalty_name')->nullable();
            $table->string('discount_name')->nullable();
            $table->string('trustfund_name')->nullable();
            $table->string('status_bill_month')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_months');
    }
};
