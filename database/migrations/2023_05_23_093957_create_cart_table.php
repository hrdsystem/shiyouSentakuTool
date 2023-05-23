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
            $table->string('type',225); 
            $table->string('image',225)->nullable(); 
            $table->string('accessories_image',225)->nullable(); 
            $table->string('item',225)->nullable(); 
            $table->string('product',225)->nullable(); 
            $table->string('color',225)->nullable(); 
            $table->string('color_img',225)->nullable(); 
            $table->string('price',225)->nullable(); 
            $table->string('description',225)->nullable(); 
            $table->dateTime('added_date')->useCurrent(); 
            $table->dateTime('modified_date')->nullable(); 
            $table->dateTime('deleted_date')->nullable();
            // $table->timestamps();
        });
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
