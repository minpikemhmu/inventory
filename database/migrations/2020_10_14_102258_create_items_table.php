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
            $table->date('expired_date');
            $table->integer('deposit');
            $table->integer('amount');
            $table->string('delivery_fees');
            $table->string('receiver_name');
            $table->text('receiver_address');
            $table->string('receiver_phone_no');
            $table->longText('remark');
            $table->string('paystatus')->default(0); 
            // 0,1 (ပုံမှန်ဆို မပေးရသေးတာ)
            
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('township_id');

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
