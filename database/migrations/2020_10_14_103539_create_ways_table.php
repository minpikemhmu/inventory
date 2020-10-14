<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ways', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('deliveryMen_id');
            $table->unsignedBigInteger('status_id');
            $table->string('status_code');
            $table->date('delivery_date');
            $table->date('refund_date');
            $table->unsignedBigInteger('staff_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('item_id')
                    ->references('id')->on('items')
                    ->onDelete('cascade');
            $table->foreign('status_id')
                    ->references('id')->on('statuses')
                    ->onDelete('cascade');
            $table->foreign('staff_id')
                    ->references('id')->on('staff')
                    ->onDelete('cascade');
            $table->foreign('deliveryMen_id')
                    ->references('id')->on('delivery_men')
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
        Schema::dropIfExists('ways');
    }
}
