<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('job_id');
            $table->string('job_no');
            $table->string('serviceable_asset_id');
            $table->bigInteger('client_id');
            $table->string('service_type');
            $table->date('request_date');
            $table->time('request_time');
            $table->bigInteger('client_contact_no');
            $table->text('client_request_problem')->nullable();
            $table->bigInteger('attending_mis_personnel_id')->nullable();
            $table->date('start_service_date')->nullable();
            $table->time('start_service_time')->nullable();
            $table->date('pause_service_date')->nullable();
            $table->time('pause_service_time')->nullable();
            $table->date('continue_service_date')->nullable();
            $table->time('continue_service_time')->nullable();
            $table->text('problems_found')->nullable();
            $table->text('solution_applied')->nullable();
            $table->text('recommendation')->nullable();
            $table->date('end_service_date')->nullable();
            $table->time('end_service_time')->nullable();
            $table->date('verified_by_client_date')->nullable();
            $table->time('verified_by_client_time')->nullable();
            $table->string('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
