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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Application Preferences
            $table->string('language', 10)->default('en');
            $table->string('timezone', 50)->default('UTC');
            $table->string('currency', 3)->default('USD');
            $table->boolean('dark_mode')->default(false);

            // Email Notifications
            $table->boolean('email_project_updates')->default(true);
            $table->boolean('email_new_messages')->default(true);
            $table->boolean('email_payments')->default(true);
            $table->boolean('email_marketing')->default(false);

            // Privacy & Security
            $table->enum('profile_visibility', ['public', 'clients_only', 'freelancers_only', 'private'])->default('public');
            $table->boolean('show_online_status')->default(true);
            $table->boolean('show_earnings')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Ensure one settings record per user
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
