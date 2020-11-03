<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('brcaslog.table', 'brcaslog_table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('url', 191)->nullable();
            $table->uuid('user_id')->nullable();
            $table->uuid('user_name')->nullable();
            $table->uuid('user_email')->nullable();
            $table->text('status')->nullable();
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->text('custom')->nullable();
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
        Schema::dropIfExists(config('log.table', 'brcaslog_table'));
    }
}
