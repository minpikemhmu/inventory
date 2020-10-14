<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('codeno');
            $table->unsignedBigInteger('client_id');
            $table->date('expired_date');
            $table->string('deposit');
            $table->string('amount');
            $table->unsignedBigInteger('township_id');
            $table->string('township_id');
            $table->string('delivery_fees');
            $table->string('receiver_name');
            $table->string('receiver_address');
            $table->string('receiver_phone_no');
            $table->longText('remark');
            $table->date('received_date');
            $table->string('paystatus');
            
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('client_id')
                    ->references('id')->on('clients')
                    ->onDelete('cascade');
            $table->foreign('township_id')
                    ->references('id')->on('townships')
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
        Schema::dropIfExists('items');
    }
}
