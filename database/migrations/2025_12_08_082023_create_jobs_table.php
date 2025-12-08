<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['fixed', 'hourly'])->default('fixed');
            $table->enum('status', ['draft', 'open', 'closed', 'in_progress', 'completed'])
                ->default('open');
            $table->decimal('budget_min', 10, 2)->nullable();            // $5,000
            $table->decimal('budget_max', 10, 2)->nullable();            // $8,000
            $table->enum('duration', ['less_than_1_month', '1_to_3_months', '3_to_6_months', 'more_than_6_months'])
                ->nullable();
            $table->enum('experience_level', ['entry', 'intermediate', 'expert'])->default('intermediate');
            $table->json('skills_required');       // ["React", "TypeScript", "Node.js"]
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->timestamp('posted_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_private')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
