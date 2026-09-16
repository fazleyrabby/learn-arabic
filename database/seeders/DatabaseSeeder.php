<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'student@quranicarabic.test'],
            [
                'name' => 'Talib al-Ilm',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            ArabicAlphabetSeeder::class,
            QuranAlFatihahSeeder::class,
            FullQuranSeeder::class,
            TopQuranicVocabularySeeder::class,
            ShortSurahsWordByWordSeeder::class,
        ]);

        Lesson::firstOrCreate(
            ['slug' => 'arabic-alphabet-fundamentals'],
            [
                'title' => 'Arabic Alphabet Fundamentals',
                'description' => 'Master the 28 Arabic letters, their phonetic articulatory points (makhārij), and four contextual shapes.',
                'level' => 'beginner',
                'type' => 'alphabet',
                'order' => 1,
                'published' => true,
            ]
        );

        Lesson::firstOrCreate(
            ['slug' => 'harakat-short-vowels'],
            [
                'title' => 'Harakat & Vowelling System',
                'description' => 'Learn short vowels (Fatḥah, Kasrah, Ḍammah), Sukūn, Shaddah, and Tanwīn.',
                'level' => 'beginner',
                'type' => 'harakat',
                'order' => 2,
                'published' => true,
            ]
        );

        Lesson::firstOrCreate(
            ['slug' => 'surah-al-fatihah-word-by-word'],
            [
                'title' => 'Surah Al-Fatihah: Word by Word Analysis',
                'description' => 'Study the opening surah word-by-word with grammatical breakdown, root families, and translation.',
                'level' => 'beginner',
                'type' => 'quran',
                'order' => 3,
                'published' => true,
            ]
        );

        Lesson::firstOrCreate(
            ['slug' => 'essential-quranic-vocabulary'],
            [
                'title' => 'High-Frequency Quranic Words',
                'description' => 'Learn the most frequent Quranic words that cover over 50% of the Holy Quran vocabulary.',
                'level' => 'intermediate',
                'type' => 'vocabulary',
                'order' => 4,
                'published' => true,
            ]
        );
    }
}
