<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('way_id');
            $table->string('delivery_fees');
            $table->string('amount');
            $table->unsignedBigInteger('payment_type_id');
            $table->unsignedBigInteger('bank_id');
            $table->string('bank_amount');
            $table->string('cash_amount');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('way_id')
                    ->references('id')->on('ways')
                    ->onDelete('cascade');
            $table->foreign('payment_type_id')
                    ->references('id')->on('payment_types')
                    ->onDelete('cascade');
            $table->foreign('bank_id')
                    ->references('id')->on('banks')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
    }
}
