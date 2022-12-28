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
        Schema::create('gbsignal_notification_jobs', function (Blueprint $t) {
            $t->id();
            $t->timestamps();

            $t->json('body')->nullable();
            $t->boolean('status')->nullable()->default(false);
            $t->enum('job_status', ['pending', 'processing', 'completed', 'failed', 'skipped'])->nullable()->default('pending');
            $t->integer('recipients')->nullable()->default(0);
            $t->string('onesignal_id')->nullable();
            $t->unsignedBigInteger('notification_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gbsignal_notification_jobs');
    }
};
