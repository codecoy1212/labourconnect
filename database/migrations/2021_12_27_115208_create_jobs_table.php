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
            $table->id();
            $table->string('j_date');
            $table->string('j_location');
            // $table->string('charge_rate');
            // $table->string('charge_rate_ot');
            $table->string('j_status');
            // $table->string('p_start');
            // $table->string('p_end');
            // $table->double('p_rate',8,1);
            // $table->double('sat_rate',8,1);
            // $table->double('sun_rate',8,1);
            $table->foreignId('company_id')->constrained();
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
        Schema::dropIfExists('jobs');
    }
}
