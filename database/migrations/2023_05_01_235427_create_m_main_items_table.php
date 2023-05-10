<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMMainItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_main_items', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('category_code', 10);
            $table->string('item_name', 50);
            $table->dateTime('Created_at');
            $table->dateTime('Update_Date');
            $table->dateTime('Deleted_Date');
            $table->string('Updated_by', 50);
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
        Schema::dropIfExists('m_main_items');
    }
}
