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
        Schema::table('quran_surahs', function (Blueprint $table): void {
            $table->string('name_bn', 100)->nullable()->after('name_english');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quran_surahs', function (Blueprint $table): void {
            $table->dropColumn('name_bn');
        });
    }
};
