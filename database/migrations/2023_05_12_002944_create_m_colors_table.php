<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_colors', function (Blueprint $table) {
            $table->id();
            $table->string('color_code',10);
            $table->string('color_name',50);
            $table->string('image_path',225)->nullable();
            $table->dateTime('Created_at')->useCurrent();
            $table->dateTime('Updated_Date')->nullable();
            $table->dateTime('Deleted_Date')->nullable();
            $table->string('Updated_by',50)->nullable();
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
        Schema::dropIfExists('m_colors');
    }
}
