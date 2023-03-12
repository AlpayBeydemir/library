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
        Schema::create('borrow_products', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('category_id');
            $table->tinyInteger('type_of_delivery')->comment('0=>From Library, 1=>Deliver To Address');
            $table->date('issued_date');
            $table->date('delivered_date');
            $table->tinyInteger('delivered')->default(0)->comment('0=>Not Delivered, 1=>Delivered');
            $table->tinyInteger('on_time')->default(0)->comment('0=>Delay, 1=>On Time');
            $table->integer('application_number');
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
        Schema::dropIfExists('borrow_products');
    }
};
