<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id'); 
            $table->string('admin_name'); 
            $table->unsignedBigInteger('receiver_id'); // The super admin's ID
            $table->text('message');  // Message content
            $table->timestamps();
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->year('year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
