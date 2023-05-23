<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMClassification3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_classification3', function (Blueprint $table) {
            $table->id();
            $table->string('category',10);
            $table->string('main_item_code',10);
            $table->string('sub_item_code',10);
            $table->string('code',10);
            $table->string('classification_name',50);
            $table->string('image_path',225)->nullable();
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
        Schema::dropIfExists('m_classification3');
    }
}
