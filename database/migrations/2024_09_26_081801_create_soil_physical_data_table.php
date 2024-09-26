<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoilPhysicalDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soil_physical_data', function (Blueprint $table) {
            $table->id();
            $table->string('division');
            $table->string('district');
            $table->string('upazila');
            $table->integer('year');
            $table->string('land_type');
            $table->string('soil_group');
            $table->string('sg_area');
            $table->string('texture');
            $table->string('consistency');
            $table->string('drainage');
            $table->string('moisture');
            $table->string('recession');
            $table->string('relief');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soil_physical_data');
    }
}
