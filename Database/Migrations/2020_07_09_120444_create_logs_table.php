<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('brcaslog.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('url', 250)->nullable();
            $table->uuid('user_id')->nullable();
            $table->uuid('user_name')->nullable();
            $table->uuid('user_email')->nullable();
            $table->json('request')->nullable();
            $table->json('response')->nullable();
            $table->json('custom')->nullable();
            $table->dateTime('sync')->nullable();
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
        Schema::dropIfExists(config('log.table'));
    }
}
