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
        Schema::create('event_participants_models', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->integer('participants');
            $table->integer('status')->comment('0 => Cancelled, 1 => Will Join');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_participants_models');
    }
};
