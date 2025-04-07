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
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('name');
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->unique();
            $table->decimal('salary', 10, 2)->default(0.00);
            $table->boolean('status')->default(1);
            $table->timestamp('created')->nullable();
            $table->timestamp('modified')->nullable();
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
