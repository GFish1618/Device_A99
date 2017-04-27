<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function(Blueprint $table) {
            $table->increments('id');
            $table->string('device_name', 100);
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict')->onUpdate('restrict');
            $table->string('department', 100);
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict')->onUpdate('restrict');
            $table->string('field1', 100);
            $table->string('field2', 100);
            $table->string('field3', 100);
            $table->string('field4', 100);
            $table->string('field5', 100);
            $table->string('field6', 100);
            $table->string('field7', 100);
            $table->string('field8', 100);
            $table->string('field9', 100);
            $table->string('field10', 100);
            $table->string('field11', 100);
            $table->string('field12', 100);
            $table->string('field13', 100);
            $table->string('field14', 100);
            $table->string('field15', 100);
            $table->string('field16', 100);
            $table->string('field17', 100);
            $table->string('field18', 100);
            $table->string('field19', 100);
            $table->string('field20', 100);
            $table->string('field21', 100);
            $table->string('field22', 100);
            $table->string('field23', 100);
            $table->string('field24', 100);
            $table->string('field25', 100);
            $table->string('field26', 100);
            $table->string('field27', 100);
            $table->string('field28', 100);
            $table->string('field29', 100);
            $table->string('field30', 100);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('devices');
    }
}
