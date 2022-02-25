<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job__users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('role_id')->constrained();
            $table->double('job_rate',8,1);
            $table->double('p_rate',8,1);
            $table->double('sat_rate',8,1);
            $table->double('sun_rate',8,1);
            $table->double('c_charge_rate',8,1);
            $table->double('c_p_rate',8,1);
            $table->double('c_sat_rate',8,1);
            $table->double('c_sun_rate',8,1);
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
        Schema::dropIfExists('job__users');
    }
}
