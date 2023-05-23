<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code',10);
            $table->string('classification1_code',10);
            $table->string('classification2_code',10);
            $table->string('classification3_code',10);
            $table->string('product_code',10);
            $table->string('color_code',10);
            $table->string('main_item_code',10);
            $table->string('sub_item_code',10);
            $table->string('category_code',10);
            $table->string('maker_code',10);
            $table->string('house_type_code',10);
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
        Schema::dropIfExists('orders');
    }
}
