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
        Schema::create('lessons', function (Blueprint $table): void {
            $table->id();
            $table->string('title', 150);
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->string('level', 50)->default('beginner');
            $table->string('type', 50); // alphabet, harakat, reading, vocabulary, quran
            $table->unsignedSmallInteger('order')->default(1);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('lesson_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->string('content_type', 50); // arabic_letter, harakat, vocabulary, quran_verse
            $table->unsignedBigInteger('content_id');
            $table->unsignedSmallInteger('order')->default(1);
            $table->json('metadata_json')->nullable();
            $table->timestamps();
        });

        Schema::create('user_progress', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('session_id', 100)->nullable(); // support guest practice tracking
            $table->string('content_type', 50); // letter, harakat, vocabulary, verse
            $table->unsignedBigInteger('content_id');
            $table->string('status', 30)->default('learning'); // not_started, learning, mastered
            $table->unsignedInteger('attempts')->default(0);
            $table->unsignedInteger('correct_attempts')->default(0);
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamp('next_review_at')->nullable();
            $table->json('metadata_json')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'content_type', 'content_id']);
            $table->index(['session_id', 'content_type', 'content_id']);
        });

        Schema::create('review_cards', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('session_id', 100)->nullable();
            $table->string('card_type', 50); // letter, harakat, word
            $table->unsignedBigInteger('card_id');
            $table->unsignedSmallInteger('repetitions')->default(0);
            $table->unsignedSmallInteger('interval_days')->default(1);
            $table->decimal('ease_factor', 4, 2)->default(2.50);
            $table->timestamp('due_at')->nullable();
            $table->timestamp('last_reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'due_at']);
            $table->index(['session_id', 'due_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_cards');
        Schema::dropIfExists('user_progress');
        Schema::dropIfExists('lesson_items');
        Schema::dropIfExists('lessons');
    }
};
