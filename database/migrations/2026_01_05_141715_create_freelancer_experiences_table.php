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
        Schema::create('freelancer_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('freelancer_id')->constrained('freelancers')->cascadeOnDelete();
            $table->foreignId('job_role_id')->constrained('job_roles')->cascadeOnDelete();
            $table->string('company');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_current')->default(false);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('employment_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancer_experiences');
    }
};
