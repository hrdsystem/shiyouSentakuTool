<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRManufacturerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_manufacturer_products', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer_code',10);
            $table->string('product_code',10);
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
        Schema::dropIfExists('r_manufacturer_products');
    }
}
