<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 50);
            $table->string('address')->nullable();
            $table->string('phone', 13)->nullable();
            $table->boolean('marital_status')->nullable();
            $table->integer('number_of_children')->nullable();
            $table->string('profile_pic')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('position_id')->constrained('positions');
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
        Schema::dropIfExists('employees');
    }
}
