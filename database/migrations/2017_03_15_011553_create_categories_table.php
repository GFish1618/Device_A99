<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name', 100);
            $table->string('parents', 100);
            $table->integer('number_of_fields');
            $table->string('field1_name', 100);
            $table->string('field2_name', 100);
            $table->string('field3_name', 100);
            $table->string('field4_name', 100);
            $table->string('field5_name', 100);
            $table->string('field6_name', 100);
            $table->string('field7_name', 100);
            $table->string('field8_name', 100);
            $table->string('field9_name', 100);
            $table->string('field10_name', 100);
            $table->string('field11_name', 100);
            $table->string('field12_name', 100);
            $table->string('field13_name', 100);
            $table->string('field14_name', 100);
            $table->string('field15_name', 100);
            $table->string('field16_name', 100);
            $table->string('field17_name', 100);
            $table->string('field18_name', 100);
            $table->string('field19_name', 100);
            $table->string('field20_name', 100);
            $table->string('field21_name', 100);
            $table->string('field22_name', 100);
            $table->string('field23_name', 100);
            $table->string('field24_name', 100);
            $table->string('field25_name', 100);
            $table->string('field26_name', 100);
            $table->string('field27_name', 100);
            $table->string('field28_name', 100);
            $table->string('field29_name', 100);
            $table->string('field30_name', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
