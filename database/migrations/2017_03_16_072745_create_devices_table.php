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
            $table->string('user_name', 100);
            $table->string('device_name', 100);
            $table->string('category', 100);
            $table->string('mac_adress', 100);
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
            $table->text('remarks', 100);

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
