<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRClassification2Classification3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_classification2_classification3', function (Blueprint $table) {
            $table->id();
            $table->string('house_type_code',50);
            $table->string('category_code',50);
            $table->string('main_item_code',50);
            $table->string('sub_item_code',50);
            $table->string('classification1_code',50);
            $table->string('classification2_code',50);
            $table->string('classification3_code',50);
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
        Schema::dropIfExists('r_classification2_classification3');
    }
}
