<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpazilaNirdesikasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upazila_nirdesikas', function (Blueprint $table) {
            $table->id();
            $table->string("Division");
            $table->string("District");
            $table->string("Upazila");
            $table->string("FilePath");
            $table->integer("Year");
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
        Schema::dropIfExists('upazila_nirdesikas');
    }
}
