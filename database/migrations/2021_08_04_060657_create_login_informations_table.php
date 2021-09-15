<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_informations', function (Blueprint $table) {
            $table->bigIncrements('login_information_id');
            $table->bigInteger('user_id');
            $table->text('remember_token');
            $table->string('ip_address');
            $table->string('device');
            $table->string('browser');
            $table->dateTime('last_active_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_informations');
    }
}
