<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->string('asset_id');
            $table->string('asset_name');
            $table->bigInteger('person_in_charge_id');
            $table->bigInteger('deployed_office_id');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('processor')->nullable();
            $table->string('memory')->nullable();
            $table->string('video_card')->nullable();
            $table->string('lan_card')->nullable();
            $table->string('sound_card')->nullable();
            $table->string('hard_drive')->nullable();
            $table->string('optical_drive')->nullable();
            $table->string('monitor')->nullable();
            $table->string('mouse')->nullable();
            $table->string('keyboard')->nullable();
            $table->string('avr')->nullable();
            $table->string('type');
            $table->boolean('serviceable');
            $table->string('asset_image_name');
            $table->date('precurement_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
