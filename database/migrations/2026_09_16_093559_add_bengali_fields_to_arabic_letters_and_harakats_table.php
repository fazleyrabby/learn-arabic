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
        Schema::table('arabic_letters', function (Blueprint $table): void {
            $table->string('name_bn')->nullable()->after('name_latin');
            $table->string('transliteration_bn')->nullable()->after('transliteration');
            $table->text('makhraj_bn')->nullable()->after('makhraj');
            $table->text('description_bn')->nullable()->after('description');
        });

        Schema::table('harakats', function (Blueprint $table): void {
            $table->string('name_bn')->nullable()->after('name_ar');
            $table->string('sound_bn')->nullable()->after('sound');
            $table->text('description_bn')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arabic_letters', function (Blueprint $table): void {
            $table->dropColumn(['name_bn', 'transliteration_bn', 'makhraj_bn', 'description_bn']);
        });

        Schema::table('harakats', function (Blueprint $table): void {
            $table->dropColumn(['name_bn', 'sound_bn', 'description_bn']);
        });
    }
};
