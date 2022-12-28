<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gbsignal_notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->longText('title')->nullable();
            $table->longText('content')->nullable();
            $table->dateTime('send_after')->nullable();
            $table->integer('receiver_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gbsignal_notifications');
    }
};
