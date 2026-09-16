<?php

namespace Database\Seeders;

use App\Models\QuranSurah;
use App\Models\QuranVerse;
use App\Models\QuranWord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShortSurahsWordByWordSeeder extends Seeder
{
    /**
     * Surah numbers to seed full word-by-word data for.
     *
     * @var array<int>
     */
    protected array $surahNumbers = [
        114, // An-Nas
        113, // Al-Falaq
        112, // Al-Ikhlas
        111, // Al-Masad
        110, // An-Nasr
        109, // Al-Kafirun
        108, // Al-Kawthar
        107, // Al-Ma'un
        106, // Quraysh
        105, // Al-Fil
        103, // Al-Asr
        97,  // Al-Qadr
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Word-by-Word data for Short Surahs...');

        foreach ($this->surahNumbers as $surahNum) {
            $this->seedSurahWords($surahNum);
        }

        // Also seed Ayat al-Kursi (2:255)
        $this->seedAyatAlKursi();

        $this->command->info('Word-by-word seeding completed successfully!');
    }

    /**
     * Fetch and seed word-by-word data for a given Surah.
     */
    protected function seedSurahWords(int $surahNum): void
    {
        $surah = QuranSurah::where('number', $surahNum)->first();
        if (! $surah) {
            $this->command->warn("Surah {$surahNum} not found in database.");

            return;
        }

        $this->command->info("Fetching word data for Surah {$surahNum} ({$surah->name_latin})...");

        try {
            $resEn = Http::timeout(15)->get("https://api.quran.com/api/v4/verses/by_chapter/{$surahNum}?language=en&words=true&word_fields=text_uthmani,transliteration,translation")->json();
            $resBn = Http::timeout(15)->get("https://api.quran.com/api/v4/verses/by_chapter/{$surahNum}?language=bn&words=true&word_fields=text_uthmani,transliteration,translation")->json();

            if (empty($resEn['verses'])) {
                $this->command->error("Could not fetch verses for Surah {$surahNum}");

                return;
            }

            foreach ($resEn['verses'] as $idx => $vData) {
                $verseNum = $vData['verse_number'];
                $verse = QuranVerse::where('quran_surah_id', $surah->id)
                    ->where('verse_number', $verseNum)
                    ->first();

                if (! $verse) {
                    continue;
                }

                $bnWords = $resBn['verses'][$idx]['words'] ?? [];

                // Remove existing words for fresh seed
                QuranWord::where('quran_verse_id', $verse->id)->delete();

                foreach ($vData['words'] as $wIdx => $w) {
                    if (($w['char_type_name'] ?? '') !== 'word') {
                        continue;
                    }

                    $bnTrans = $bnWords[$wIdx]['translation']['text'] ?? null;
                    $enTrans = $w['translation']['text'] ?? null;
                    $audioPath = $w['audio_url'] ?? null;
                    $fullAudioUrl = $audioPath ? (str_starts_with($audioPath, 'http') ? $audioPath : "https://audio.qurancdn.com/{$audioPath}") : null;

                    QuranWord::create([
                        'quran_verse_id' => $verse->id,
                        'position' => $w['position'] ?? ($wIdx + 1),
                        'text_ar' => $w['text_uthmani'] ?? $w['text'],
                        'normalized_text' => preg_replace('/[^\p{Arabic}]/u', '', $w['text_uthmani'] ?? $w['text']),
                        'translation' => $enTrans,
                        'translation_bn' => $bnTrans,
                        'transliteration' => $w['transliteration']['text'] ?? null,
                        'audio_url' => $fullAudioUrl,
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->command->error("Failed seeding Surah {$surahNum}: ".$e->getMessage());
            Log::error("ShortSurahsWordByWordSeeder error for Surah {$surahNum}: ".$e->getMessage());
        }
    }

    /**
     * Seed Ayat al-Kursi (Surah 2:255).
     */
    protected function seedAyatAlKursi(): void
    {
        $surah2 = QuranSurah::where('number', 2)->first();
        if (! $surah2) {
            return;
        }

        $verse255 = QuranVerse::where('quran_surah_id', $surah2->id)
            ->where('verse_number', 255)
            ->first();

        if (! $verse255) {
            return;
        }

        $this->command->info('Fetching word data for Ayat al-Kursi (2:255)...');

        try {
            $resEn = Http::timeout(15)->get('https://api.quran.com/api/v4/verses/by_key/2:255?language=en&words=true&word_fields=text_uthmani,transliteration,translation')->json();
            $resBn = Http::timeout(15)->get('https://api.quran.com/api/v4/verses/by_key/2:255?language=bn&words=true&word_fields=text_uthmani,transliteration,translation')->json();

            if (empty($resEn['verse']['words'])) {
                return;
            }

            QuranWord::where('quran_verse_id', $verse255->id)->delete();

            $bnWords = $resBn['verse']['words'] ?? [];

            foreach ($resEn['verse']['words'] as $wIdx => $w) {
                if (($w['char_type_name'] ?? '') !== 'word') {
                    continue;
                }

                $bnTrans = $bnWords[$wIdx]['translation']['text'] ?? null;
                $enTrans = $w['translation']['text'] ?? null;
                $audioPath = $w['audio_url'] ?? null;
                $fullAudioUrl = $audioPath ? (str_starts_with($audioPath, 'http') ? $audioPath : "https://audio.qurancdn.com/{$audioPath}") : null;

                QuranWord::create([
                    'quran_verse_id' => $verse255->id,
                    'position' => $w['position'] ?? ($wIdx + 1),
                    'text_ar' => $w['text_uthmani'] ?? $w['text'],
                    'normalized_text' => preg_replace('/[^\p{Arabic}]/u', '', $w['text_uthmani'] ?? $w['text']),
                    'translation' => $enTrans,
                    'translation_bn' => $bnTrans,
                    'transliteration' => $w['transliteration']['text'] ?? null,
                    'audio_url' => $fullAudioUrl,
                ]);
            }
        } catch (\Exception $e) {
            $this->command->error('Failed seeding Ayat al-Kursi: '.$e->getMessage());
        }
    }
}
