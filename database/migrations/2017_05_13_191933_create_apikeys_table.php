<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApikeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service', 255)->nullable();;
            $table->string('api_key', 255)->nullable();;
            $table->string('username', 255)->nullable();;
            $table->string('password', 255)->nullable();;
            $table->string('url', 255)->nullable();;
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
        Schema::dropIfExists('api_keys');
    }
}
