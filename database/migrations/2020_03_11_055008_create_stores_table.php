<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->string("name");
            $table->string("addr")->nullable();
            $table->string("type");
            $table->float("lat", 10, 6)->nullable();
            $table->float("lng", 10, 6)->nullable();
            $table->integer('mask_sync_log_id');
            $table->dateTime("stock_at")->nullable();
            $table->string("remain_stat")->nullable();
            $table->dateTime("created_at")->nullable();

            $table->unique("code");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
