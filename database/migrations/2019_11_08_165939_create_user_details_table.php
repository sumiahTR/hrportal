<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('employee_no');
            $table->string('mobile', 255)->nullable()->default(NULL);
            $table->date('joining_date');
            $table->date('dob');
            $table->string('bank', 255)->nullable();
            $table->string('account_no', 255)->nullable();
            $table->string('pan', 255)->nullable()->default(NULL);
            $table->string('designation', 255)->nullable()->default(NULL);
            $table->string('photo', 255)->nullable()->default(NULL);
            $table->text('salary_details')->nullable()->default(NULL);
            $table->integer('weekend_off')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
