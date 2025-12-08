<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('freelancers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('bio')->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->enum('availability', ['available', 'busy', 'unavailable'])->default('available');
            $table->integer('years_experience')->nullable();
            $table->text('portfolio_url')->nullable();
            $table->text('linkedin_url')->nullable();
            $table->text('github_url')->nullable();
            $table->text('facebook_url')->nullable();
            $table->text('twitter_url')->nullable();
            $table->json('languages')->nullable();
            $table->text('response_time')->nullable();
            $table->json('working_hours')->nullable();
            $table->integer('total_projects')->default(0);
            $table->decimal('job_success_rate', 5, 2)->nullable();
            $table->integer('total_hours')->default(0);
            $table->integer('completed_projects')->default(0);
            $table->decimal('total_earned', 12, 2)->default(0);
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('rating_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};
