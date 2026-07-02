<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('designation')->nullable();
            $table->decimal('monthly_salary_package', 12, 2)->default(0);
            $table->decimal('monthly_tax_value', 12, 2)->default(0);
            $table->decimal('yearly_increasing_bonus', 12, 2)->default(0);
            $table->decimal('monthly_net_salary', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
