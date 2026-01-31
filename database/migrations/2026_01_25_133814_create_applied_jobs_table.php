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
        Schema::create('applied_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->timestamp('client_viewed_at')->nullable();
            $table->boolean('revision_requested')->default(false);
            $table->text('revision_reason')->nullable();
            $table->timestamp('revision_requested_at')->nullable();
            $table->enum('status', [
                'submitted',     // Proposal sent
                'viewed',        // Client viewed
                'shortlisted',   // Client interested
                'interviewing',  // In discussion
                'revising',      // Freelancer requested changes
                'rejected',      // Not selected
                'accepted',      // Got the job!
                'withdrawn'      // Freelancer withdrew
            ])->default('submitted');
            $table->unique(['user_id', 'job_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applied_jobs');
    }
};
