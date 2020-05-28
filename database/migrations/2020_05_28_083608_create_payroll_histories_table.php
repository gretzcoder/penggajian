<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('allowance_id')->constrained('allowances');
            $table->integer('gaji_pokok');
            $table->integer('insentif_kehadiran');
            $table->integer('tunjangan_jabatan');
            $table->integer('tunjangan_makan');
            $table->integer('tunjangan_transportasi');
            $table->integer('tunjangan_istri');
            $table->integer('tunjangan_anak');
            $table->integer('pph21');
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
        Schema::dropIfExists('payroll_histories');
    }
}
