<?php

namespace Database\Seeders;

use App\Models\QuranSurah;
use App\Models\QuranVerse;
use Illuminate\Database\Seeder;

class FullQuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataFile = database_path('data/quran_data.json.gz');
        if (! file_exists($dataFile)) {
            $this->command?->error("Quran data file not found: {$dataFile}");

            return;
        }

        $rawJson = gzdecode(file_get_contents($dataFile));
        if ($rawJson === false) {
            $this->command?->error('Failed to decompress Quran data file.');

            return;
        }

        $data = json_decode($rawJson, true);
        if (! isset($data['surahs'], $data['verses'])) {
            $this->command?->error('Invalid Quran data format.');

            return;
        }

        $this->command?->info('Seeding 114 Surahs...');

        $surahIdMap = [];
        foreach ($data['surahs'] as $s) {
            $surah = QuranSurah::updateOrCreate(
                ['number' => $s['number']],
                [
                    'name_ar' => $s['name_ar'],
                    'name_latin' => $s['name_latin'],
                    'name_english' => $s['name_english'] ?? null,
                    'name_bn' => $s['name_bn'] ?? null,
                    'revelation_type' => $s['revelation_type'] ?? 'Meccan',
                    'verse_count' => $s['verse_count'],
                ]
            );
            $surahIdMap[$s['number']] = $surah->id;
        }

        $this->command?->info('Seeding 6,236 Verses...');

        $batch = [];
        $batchSize = 250;
        $now = now();

        foreach ($data['verses'] as $v) {
            $surahId = $surahIdMap[$v['surah']] ?? null;
            if (! $surahId) {
                continue;
            }

            $batch[] = [
                'quran_surah_id' => $surahId,
                'verse_number' => $v['ayah'],
                'text_ar' => $v['text_ar'],
                'translation' => $v['translation'],
                'translation_bn' => $v['translation_bn'],
                'audio_url' => $v['audio_url'],
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($batch) >= $batchSize) {
                QuranVerse::upsert(
                    $batch,
                    ['quran_surah_id', 'verse_number'],
                    ['text_ar', 'translation', 'translation_bn', 'audio_url', 'updated_at']
                );
                $batch = [];
            }
        }

        if (! empty($batch)) {
            QuranVerse::upsert(
                $batch,
                ['quran_surah_id', 'verse_number'],
                ['text_ar', 'translation', 'translation_bn', 'audio_url', 'updated_at']
            );
        }

        $this->command?->info('Full Quran seeded successfully: 114 Surahs, 6,236 Verses.');
    }
}
