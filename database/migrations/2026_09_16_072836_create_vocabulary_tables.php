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
        Schema::create('vocabularies', function (Blueprint $table): void {
            $table->id();
            $table->string('arabic', 100);
            $table->string('normalized_arabic', 100);
            $table->string('lemma', 100)->nullable();
            $table->foreignId('root_id')->nullable()->constrained('roots')->nullOnDelete();
            $table->string('transliteration', 100)->nullable();
            $table->string('meaning_en', 255);
            $table->string('meaning_bn', 255)->nullable();
            $table->string('part_of_speech', 50)->nullable();
            $table->unsignedInteger('frequency')->default(1);
            $table->unsignedSmallInteger('difficulty')->default(1);
            $table->string('audio_url')->nullable();
            $table->timestamps();
        });

        Schema::create('vocabulary_occurrences', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->cascadeOnDelete();
            $table->foreignId('quran_surah_id')->constrained('quran_surahs')->cascadeOnDelete();
            $table->foreignId('quran_verse_id')->constrained('quran_verses')->cascadeOnDelete();
            $table->foreignId('quran_word_id')->nullable()->constrained('quran_words')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabulary_occurrences');
        Schema::dropIfExists('vocabularies');
    }
};
