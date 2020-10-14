<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverymenTownshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverymen_townships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deliveryMen_id');
            $table->unsignedBigInteger('township_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('deliveryMen_id')
                    ->references('id')->on('delivery_men')
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
        Schema::dropIfExists('deliverymen_townships');
    }
}
