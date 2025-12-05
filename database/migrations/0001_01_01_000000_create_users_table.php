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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('user_type', ['client', 'freelancer'])->default('client');
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('bio')->nullable();
            $table->string('location', 100)->nullable();
            $table->json('skills')->nullable(); // For freelancers
            $table->decimal('hourly_rate', 10, 2)->nullable(); // For freelancers
            $table->string('company', 100)->nullable(); // For clients
            $table->string('website', 255)->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');

            // ADD THESE NEW COLUMNS FOR THE FREELANCER CARD:
            $table->string('job_title', 100)->nullable(); // e.g., "Senior React Developer"
            $table->enum('availability', ['available', 'busy', 'unavailable'])->default('available');
            $table->integer('years_experience')->nullable(); // e.g., 7
            $table->integer('total_projects')->default(0); // e.g., 48
            $table->decimal('job_success_rate', 5, 2)->nullable(); // e.g., 97.00
            $table->integer('total_hours')->default(0); // e.g., 2100

            $table->integer('completed_projects')->default(0);
            $table->decimal('total_earned', 12, 2)->default(0); // For freelancers
            $table->decimal('total_spent', 12, 2)->default(0); // For clients
            $table->decimal('rating', 3, 2)->nullable(); // Average rating
            $table->integer('rating_count')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
