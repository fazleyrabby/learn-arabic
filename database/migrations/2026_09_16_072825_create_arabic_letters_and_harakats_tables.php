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
        Schema::create('arabic_letters', function (Blueprint $table): void {
            $table->id();
            $table->string('character', 10);
            $table->string('name_ar', 50);
            $table->string('name_latin', 50);
            $table->string('transliteration', 20);
            $table->unsignedSmallInteger('order')->unique();
            $table->text('description')->nullable();
            $table->string('makhraj', 100)->nullable();
            $table->string('audio_url')->nullable();
            $table->timestamps();
        });

        Schema::create('arabic_letter_forms', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('arabic_letter_id')->constrained('arabic_letters')->cascadeOnDelete();
            $table->string('position', 20); // isolated, initial, medial, final
            $table->string('form', 20);
            $table->string('example', 100)->nullable();
            $table->string('example_transliteration', 100)->nullable();
            $table->string('example_meaning', 100)->nullable();
            $table->timestamps();

            $table->unique(['arabic_letter_id', 'position']);
        });

        Schema::create('harakats', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 50);
            $table->string('name_ar', 50);
            $table->string('symbol', 10);
            $table->string('sound', 100);
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('order')->unique();
            $table->string('audio_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harakats');
        Schema::dropIfExists('arabic_letter_forms');
        Schema::dropIfExists('arabic_letters');
    }
};
