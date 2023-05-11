<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->string('item', 255);
            $table->string('image', 255);
            $table->string('kind', 255);
            $table->string('color', 255);
            $table->string('color_img', 255);
            $table->string('type', 255);
            $table->timestamp('added_date');
            $table->dateTime('modified_date');
            $table->dateTime('deleted_date');
        });
        // Schema::create('cart', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('item', 255);
        //     $table->string('image', 255);
        //     $table->string('kind', 255);
        //     $table->string('color', 255);
        //     $table->string('color_img', 255);
        //     $table->string('type', 255);
        //     $table->timestamp('added_date');
        //     $table->dateTime('modified_date');
        //     $table->dateTime('deleted_date');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
}
