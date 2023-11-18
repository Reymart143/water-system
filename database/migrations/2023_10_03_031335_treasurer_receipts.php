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
        Schema::create('treasurer_receipts', function (Blueprint $table) {
            $table->id();
            $table->float('Total_Amount_Water_bill');
            $table->string('account_id')->nullable();
            $table->integer('receiptID');
            $table->string('customerName');
            $table->date('receiptcurrentDate');
            $table->integer('stub_no');
            $table->string('or_number');
            $table->string('rate_case');
            $table->string('cash');
            $table->string('drawee_Checkbox')->nullable();
            $table->string('drawee_input')->nullable();
            $table->string('drawee_number')->nullable();
            $table->date('draweeDate')->nullable();
            $table->string('money_checkbox')->nullable();
            $table->string('money_order_number')->nullable();
            $table->date('money_order_date')->nullable();
            $table->string('collector');
            $table->float('collection_bill')->nullable();
            $table->float('Total_balance')->nullable();
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
        //
    }
};
