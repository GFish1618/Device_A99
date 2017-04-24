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
            //$table->string('user_name', 100);
            $table->string('device_name', 100);
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



            /*$table->string('mac_adress', 100);
            $table->string('ownership', 100);
            $table->string('unit_sn', 100);
            $table->string('keyboard_sn', 100);
            $table->string('mouse_sn', 100);
            $table->string('charger_sn', 100);
            $table->string('charger_model', 100);
            $table->boolean('external_monitor');
            $table->boolean('external_mon_cable');
            $table->boolean('laptop_sleeve');
            $table->string('installed_memory', 100);
            $table->string('core_speed', 100);
            $table->date('purchased_date');
            $table->string('current_location', 100);
            $table->string('password', 100);
            $table->string('os_version', 100);
            $table->string('department', 100);
            $table->text('remarks', 100);*/

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
