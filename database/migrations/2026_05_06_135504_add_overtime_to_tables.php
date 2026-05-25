<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // Attendance → store hours
    Schema::table('attendances', function (Blueprint $table) {
        $table->integer('overtime_hours')->default(0);
    });

    // Payroll → store computed pay
    Schema::table('payrolls', function (Blueprint $table) {
        $table->decimal('overtime_pay', 10, 2)->default(0);
    });
}

public function down()
{
    Schema::table('attendances', function (Blueprint $table) {
        $table->dropColumn('overtime_hours');
    });

    Schema::table('payrolls', function (Blueprint $table) {
        $table->dropColumn('overtime_pay');
    });
}
};
