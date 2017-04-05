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
            $table->boolean('user_name');
            $table->boolean('device_name');
            $table->boolean('category');
            $table->boolean('mac_adress');
            $table->boolean('ownership');
            $table->boolean('unit_sn');
            $table->boolean('keyboard_sn');
            $table->boolean('mouse_sn');
            $table->boolean('charger_sn');
            $table->boolean('charger_model');
            $table->boolean('external_monitor');
            $table->boolean('external_mon_cable');
            $table->boolean('laptop_sleeve');
            $table->boolean('installed_memory');
            $table->boolean('core_speed');
            $table->boolean('purchased_date');
            $table->boolean('current_location');
            $table->boolean('password');
            $table->boolean('os_version');
            $table->boolean('department');
            $table->boolean('remarks');

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
