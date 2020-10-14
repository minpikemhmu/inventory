<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_men_id');
            $table->unsignedBigInteger('schedule_id');
            $table->integer('status');
            $table->unsignedBigInteger('staff_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('delivery_men_id')
                    ->references('id')->on('delivery_men')
                    ->onDelete('cascade');
            $table->foreign('schedule_id')
                    ->references('id')->on('schedules')
                    ->onDelete('cascade');
            $table->foreign('staff_id')
                    ->references('id')->on('staff')
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
        Schema::dropIfExists('pickups');
    }
}
