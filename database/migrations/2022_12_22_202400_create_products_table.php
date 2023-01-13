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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer("author_id");
            $table->integer("category_id");
            $table->string("name");
            $table->integer("stock");
            $table->integer("isbn");
            $table->string("image");
            $table->tinyInteger("is_active")->default('0')->comment("0 => Is Available , 1 => Is not Available");
            $table->tinyInteger("status")->default('0')->comment("0 => In the Library , 1 => At a Student");
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
        Schema::dropIfExists('products');
    }
};
