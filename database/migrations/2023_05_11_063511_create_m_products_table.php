<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_products', function (Blueprint $table) {
            $table->id(); 
            $table->string('category_code', 10)->nullable(); 
            $table->string('main_items_code', 10)->nullable(); 
            $table->string('sub_items_code', 10)->nullable(); 
            $table->string('code', 10)->unique();
            $table->string('product_name', 50); 
            $table->string('price', 225); 
            $table->string('maker_code', 50)->nullable(); 
            $table->string('color_code', 10)->nullable(); 
            $table->string('description', 225)->nullable();
            $table->string('image_path', 225)->nullable(); 
            $table->string('add_image', 225)->nullable(); 
            $table->dateTime('Created_at')->useCurrent();
            $table->dateTime('Updated_Date')->nullable(); 
            $table->dateTime('Deleted_Date')->nullable(); 
            $table->string('Updated_by',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_products');
    }
}
