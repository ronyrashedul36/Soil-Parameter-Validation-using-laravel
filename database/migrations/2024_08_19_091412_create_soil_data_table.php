<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoilDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SoilData', function (Blueprint $table) {
            // $table->id();
            $table->string('division');
            $table->string('district');
            $table->string('upazila');
            $table->double('fid')->nullable();
            $table->double('smpl_no')->nullable();
            $table->double('mu')->nullable();
            $table->string('land_type')->nullable();
            $table->string('soil_series')->nullable();
            $table->double('soil_group')->nullable();
            $table->string('texture')->nullable();
            $table->double('ec')->nullable();
            $table->double('ph')->nullable();
            $table->double('ea')->nullable();
            $table->double('om')->nullable();
            $table->double('n')->nullable();
            $table->double('po')->nullable();
            $table->double('pb')->nullable();
            $table->double('k')->nullable();
            $table->double('s')->nullable();
            $table->double('zn')->nullable();
            $table->double('b')->nullable();
            $table->double('ca')->nullable();
            $table->double('mg')->nullable();
            $table->double('cu')->nullable();
            $table->double('fe')->nullable();
            $table->double('mn')->nullable();
            $table->double('upz_code')->nullable();
            $table->timestamps();
            $table->double('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SoilData');
    }
}
