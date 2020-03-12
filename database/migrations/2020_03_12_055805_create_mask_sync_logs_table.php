<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaskSyncLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mask_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string("target");
            $table->string("request_params")->nullable();
            $table->integer("remote_total_count")->nullable();
            $table->boolean("succeed")->nullable();
            $table->dateTime("sync_started_at")->nullable();
            $table->dateTime("sync_ended_at")->nullable();
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
        Schema::dropIfExists('mask_sync_logs');
    }
}
