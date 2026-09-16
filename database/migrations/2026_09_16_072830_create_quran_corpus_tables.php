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
        Schema::create('quran_surahs', function (Blueprint $table): void {
            $table->id();
            $table->unsignedSmallInteger('number')->unique();
            $table->string('name_ar', 50);
            $table->string('name_latin', 100);
            $table->string('name_english', 100)->nullable();
            $table->string('revelation_type', 20)->default('Meccan');
            $table->unsignedSmallInteger('verse_count');
            $table->timestamps();
        });

        Schema::create('quran_verses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('quran_surah_id')->constrained('quran_surahs')->cascadeOnDelete();
            $table->unsignedSmallInteger('verse_number');
            $table->text('text_ar');
            $table->text('translation');
            $table->text('translation_bn')->nullable();
            $table->text('transliteration')->nullable();
            $table->string('audio_url')->nullable();
            $table->timestamps();

            $table->unique(['quran_surah_id', 'verse_number']);
        });

        Schema::create('roots', function (Blueprint $table): void {
            $table->id();
            $table->string('root_ar', 20)->unique();
            $table->string('root_latin', 50);
            $table->text('meaning');
            $table->timestamps();
        });

        Schema::create('quran_words', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('quran_verse_id')->constrained('quran_verses')->cascadeOnDelete();
            $table->unsignedSmallInteger('position');
            $table->string('text_ar', 100);
            $table->string('normalized_text', 100);
            $table->string('lemma', 100)->nullable();
            $table->foreignId('root_id')->nullable()->constrained('roots')->nullOnDelete();
            $table->string('translation', 255)->nullable();
            $table->string('translation_bn', 255)->nullable();
            $table->string('transliteration', 255)->nullable();
            $table->string('audio_url')->nullable();
            $table->timestamps();

            $table->unique(['quran_verse_id', 'position']);
        });

        Schema::create('word_morphologies', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('quran_word_id')->constrained('quran_words')->cascadeOnDelete();
            $table->string('part_of_speech', 50);
            $table->string('pattern', 50)->nullable();
            $table->string('form', 50)->nullable();
            $table->string('case', 50)->nullable();
            $table->string('mood', 50)->nullable();
            $table->string('tense', 50)->nullable();
            $table->string('voice', 50)->nullable();
            $table->string('person', 20)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('number', 20)->nullable();
            $table->json('features_json')->nullable();
            $table->string('source', 50)->default('corpus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_morphologies');
        Schema::dropIfExists('quran_words');
        Schema::dropIfExists('roots');
        Schema::dropIfExists('quran_verses');
        Schema::dropIfExists('quran_surahs');
    }
};
