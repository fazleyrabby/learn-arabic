<?php

namespace Database\Seeders;

use App\Models\QuranSurah;
use App\Models\QuranVerse;
use App\Models\QuranWord;
use App\Models\Root;
use App\Models\WordMorphology;
use Illuminate\Database\Seeder;

class QuranAlFatihahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $surah = QuranSurah::updateOrCreate(
            ['number' => 1],
            [
                'name_ar' => 'الفَاتِحَة',
                'name_latin' => 'Al-Faatiha',
                'name_english' => 'The Opening',
                'revelation_type' => 'Meccan',
                'verse_count' => 7,
            ]
        );

        $rootsData = [
            'س م و' => ['s-m-w', 'To be high, to name, name'],
            'إ ل ه' => ['a-l-h', 'To worship, god, deity, Allah'],
            'ر ح م' => ['r-h-m', 'To have mercy, compassion, womb'],
            'ح م د' => ['h-m-d', 'To praise, thank, commend'],
            'ر ب ب' => ['r-b-b', 'Lord, master, owner, sustainer'],
            'ع ل م' => ['‘-l-m', 'To know, mark, sign, creation, worlds'],
            'م ل ك' => ['m-l-k', 'To possess, rule, king, sovereign'],
            'ي و م' => ['y-w-m', 'Day, period, era'],
            'د ي ن' => ['d-y-n', 'Judgment, recompense, religion, debt'],
            'ع ب د' => ['‘-b-d', 'To serve, worship, slave, servant'],
            'ع و ن' => ['‘-w-n', 'To help, assist, seek aid'],
            'ه د ي' => ['h-d-y', 'To guide, direct, show the way'],
            'ص ر ط' => ['s-r-t', 'Path, way, road'],
            'ق و م' => ['q-w-m', 'To stand, rise, upright, straight'],
            'ن ع م' => ['n-‘-m', 'To bestow favor, delight, blessing'],
            'غ ي ر' => ['gh-y-r', 'Other than, not, change'],
            'غ ض ب' => ['gh-d-b', 'To be angry, wrath'],
            'ض ل ل' => ['d-l-l', 'To go astray, err, lose the way'],
        ];

        $rootModels = [];
        foreach ($rootsData as $rootAr => [$rootLatin, $meaning]) {
            $rootModels[$rootAr] = Root::updateOrCreate(
                ['root_ar' => $rootAr],
                [
                    'root_latin' => $rootLatin,
                    'meaning' => $meaning,
                ]
            );
        }

        $versesData = [
            1 => [
                'text_ar' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ',
                'trans' => 'Bismi Allāhi ar-Raḥmāni ar-Raḥīm',
                'en' => 'In the name of Allah, the Entirely Merciful, the Especially Merciful.',
                'bn' => 'পরম করুণাময় অসীম দয়ালু আল্লাহর নামে শুরু করছি।',
                'audio' => 'https://everyayah.com/data/Alafasy_128kbps/001001.mp3',
                'words' => [
                    [
                        'pos' => 1,
                        'text' => 'بِسْمِ',
                        'norm' => 'بسم',
                        'lemma' => 'اسم',
                        'root' => 'س م و',
                        'en' => 'In the name',
                        'bn' => 'নামে',
                        'trans' => 'Bismi',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_001_001.mp3',
                        'morph' => ['part_of_speech' => 'preposition + noun', 'case' => 'genitive'],
                    ],
                    [
                        'pos' => 2,
                        'text' => 'اللَّهِ',
                        'norm' => 'الله',
                        'lemma' => 'الله',
                        'root' => 'إ ل ه',
                        'en' => 'of Allah',
                        'bn' => 'আল্লাহর',
                        'trans' => 'Allāhi',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_001_002.mp3',
                        'morph' => ['part_of_speech' => 'proper noun', 'case' => 'genitive'],
                    ],
                    [
                        'pos' => 3,
                        'text' => 'الرَّحْمَٰنِ',
                        'norm' => 'الرحمن',
                        'lemma' => 'رحمن',
                        'root' => 'ر ح م',
                        'en' => 'the Entirely Merciful',
                        'bn' => 'পরম করুণাময়',
                        'trans' => 'ar-Raḥmān',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_001_003.mp3',
                        'morph' => ['part_of_speech' => 'adjective', 'pattern' => 'fa‘lān', 'case' => 'genitive'],
                    ],
                    [
                        'pos' => 4,
                        'text' => 'الرَّحِيمِ',
                        'norm' => 'الرحيم',
                        'lemma' => 'رحيم',
                        'root' => 'ر ح م',
                        'en' => 'the Especially Merciful',
                        'bn' => 'অসীম দয়ালু',
                        'trans' => 'ar-Raḥīm',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_001_004.mp3',
                        'morph' => ['part_of_speech' => 'adjective', 'pattern' => 'fa‘īl', 'case' => 'genitive'],
                    ],
                ],
            ],
            2 => [
                'text_ar' => 'الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ',
                'trans' => 'Al-ḥamdu lillāhi Rabbi al-‘ālamīn',
                'en' => '[All] praise is [due] to Allah, Lord of the worlds.',
                'bn' => 'যাবতীয় প্রশংসা জগৎসমূহের প্রতিপালক আল্লাহরই জন্য।',
                'audio' => 'https://everyayah.com/data/Alafasy_128kbps/001002.mp3',
                'words' => [
                    [
                        'pos' => 1,
                        'text' => 'الْحَمْدُ',
                        'norm' => 'الحمد',
                        'lemma' => 'حمد',
                        'root' => 'ح م د',
                        'en' => '[All] praise',
                        'bn' => 'সমস্ত প্রশংসা',
                        'trans' => 'al-Ḥamdu',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_002_001.mp3',
                        'morph' => ['part_of_speech' => 'noun', 'case' => 'nominative'],
                    ],
                    [
                        'pos' => 2,
                        'text' => 'لِلَّهِ',
                        'norm' => 'لله',
                        'lemma' => 'الله',
                        'root' => 'إ ل ه',
                        'en' => 'is to Allah',
                        'bn' => 'আল্লাহর জন্য',
                        'trans' => 'lillāhi',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_002_002.mp3',
                        'morph' => ['part_of_speech' => 'preposition + proper noun', 'case' => 'genitive'],
                    ],
                    [
                        'pos' => 3,
                        'text' => 'رَبِّ',
                        'norm' => 'رب',
                        'lemma' => 'رب',
                        'root' => 'ر ب ب',
                        'en' => 'Lord',
                        'bn' => 'প্রতিপালক',
                        'trans' => 'Rabbi',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_002_003.mp3',
                        'morph' => ['part_of_speech' => 'noun', 'case' => 'genitive'],
                    ],
                    [
                        'pos' => 4,
                        'text' => 'الْعَالَمِينَ',
                        'norm' => 'العالمين',
                        'lemma' => 'عالم',
                        'root' => 'ع ل م',
                        'en' => 'of the worlds',
                        'bn' => 'জগৎসমূহের',
                        'trans' => 'al-‘ālamīn',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_002_004.mp3',
                        'morph' => ['part_of_speech' => 'masculine plural noun', 'case' => 'genitive', 'number' => 'plural'],
                    ],
                ],
            ],
            3 => [
                'text_ar' => 'الرَّحْمَٰنِ الرَّحِيمِ',
                'trans' => 'Ar-Raḥmāni ar-Raḥīm',
                'en' => 'The Entirely Merciful, the Especially Merciful.',
                'bn' => 'যিনি পরম করুণাময়, অসীম দয়ালু।',
                'audio' => 'https://everyayah.com/data/Alafasy_128kbps/001003.mp3',
                'words' => [
                    [
                        'pos' => 1,
                        'text' => 'الرَّحْمَٰنِ',
                        'norm' => 'الرحمن',
                        'lemma' => 'رحمن',
                        'root' => 'ر ح م',
                        'en' => 'The Entirely Merciful',
                        'bn' => 'পরম করুণাময়',
                        'trans' => 'ar-Raḥmān',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_003_001.mp3',
                        'morph' => ['part_of_speech' => 'adjective', 'pattern' => 'fa‘lān', 'case' => 'genitive'],
                    ],
                    [
                        'pos' => 2,
                        'text' => 'الرَّحِيمِ',
                        'norm' => 'الرحيم',
                        'lemma' => 'رحيم',
                        'root' => 'ر ح م',
                        'en' => 'the Especially Merciful',
                        'bn' => 'অসীম দয়ালু',
                        'trans' => 'ar-Raḥīm',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_003_002.mp3',
                        'morph' => ['part_of_speech' => 'adjective', 'pattern' => 'fa‘īl', 'case' => 'genitive'],
                    ],
                ],
            ],
            4 => [
                'text_ar' => 'مَالِكِ يَوْمِ الدِّينِ',
                'trans' => 'Māliki yawmi ad-dīn',
                'en' => 'Sovereign of the Day of Recompense.',
                'bn' => 'যিনি বিচার দিবসের মালিক।',
                'audio' => 'https://everyayah.com/data/Alafasy_128kbps/001004.mp3',
                'words' => [
                    [
                        'pos' => 1,
                        'text' => 'مَالِكِ',
                        'norm' => 'مالك',
                        'lemma' => 'مالك',
                        'root' => 'م ل ك',
                        'en' => 'Sovereign / Master',
                        'bn' => 'মালিক',
                        'trans' => 'Māliki',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_004_001.mp3',
                        'morph' => ['part_of_speech' => 'active participle', 'pattern' => 'fā‘il', 'case' => 'genitive'],
                    ],
                    [
                        'pos' => 2,
                        'text' => 'يَوْمِ',
                        'norm' => 'يوم',
                        'lemma' => 'يوم',
                        'root' => 'ي و م',
                        'en' => 'of the Day',
                        'bn' => 'দিবসের',
                        'trans' => 'yawmi',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_004_002.mp3',
                        'morph' => ['part_of_speech' => 'noun', 'case' => 'genitive'],
                    ],
                    [
                        'pos' => 3,
                        'text' => 'الدِّينِ',
                        'norm' => 'الدين',
                        'lemma' => 'دين',
                        'root' => 'د ي ن',
                        'en' => 'of Recompense / Judgment',
                        'bn' => 'বিচার',
                        'trans' => 'ad-Dīn',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_004_003.mp3',
                        'morph' => ['part_of_speech' => 'noun', 'case' => 'genitive'],
                    ],
                ],
            ],
            5 => [
                'text_ar' => 'إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ',
                'trans' => 'Iyyāka na‘budu wa-iyyāka nasta‘īn',
                'en' => 'It is You we worship and You we ask for help.',
                'bn' => 'আমরা কেবল তোমারই ইবাদত করি এবং কেবলমাত্র তোমারই সাহায্য প্রার্থনা করি।',
                'audio' => 'https://everyayah.com/data/Alafasy_128kbps/001005.mp3',
                'words' => [
                    [
                        'pos' => 1,
                        'text' => 'إِيَّاكَ',
                        'norm' => 'إياك',
                        'lemma' => 'إيا',
                        'root' => null,
                        'en' => 'You alone',
                        'bn' => 'তোমাকেই কেবল',
                        'trans' => 'Iyyāka',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_005_001.mp3',
                        'morph' => ['part_of_speech' => 'personal pronoun', 'case' => 'accusative', 'person' => 'second'],
                    ],
                    [
                        'pos' => 2,
                        'text' => 'نَعْبُدُ',
                        'norm' => 'نعبد',
                        'lemma' => 'عبد',
                        'root' => 'ع ب د',
                        'en' => 'we worship',
                        'bn' => 'আমরা ইবাদত করি',
                        'trans' => 'na‘budu',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_005_002.mp3',
                        'morph' => ['part_of_speech' => 'imperfect verb', 'tense' => 'present', 'person' => 'first', 'number' => 'plural'],
                    ],
                    [
                        'pos' => 3,
                        'text' => 'وَإِيَّاكَ',
                        'norm' => 'وإياك',
                        'lemma' => 'إيا',
                        'root' => null,
                        'en' => 'and You alone',
                        'bn' => 'এবং তোমারই কাছে',
                        'trans' => 'wa-iyyāka',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_005_003.mp3',
                        'morph' => ['part_of_speech' => 'conjunction + pronoun', 'case' => 'accusative'],
                    ],
                    [
                        'pos' => 4,
                        'text' => 'نَسْتَعِينُ',
                        'norm' => 'نستعين',
                        'lemma' => 'استعان',
                        'root' => 'ع و ن',
                        'en' => 'we ask for help',
                        'bn' => 'সাহায্য চাই',
                        'trans' => 'nasta‘īn',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_005_004.mp3',
                        'morph' => ['part_of_speech' => 'verb form X', 'tense' => 'present', 'person' => 'first', 'number' => 'plural'],
                    ],
                ],
            ],
            6 => [
                'text_ar' => 'اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ',
                'trans' => 'Ihdinā aṣ-ṣirāṭa al-mustaqīm',
                'en' => 'Guide us to the straight path -',
                'bn' => 'আমাদেরকে সরল সঠিক পথ দেখাও।',
                'audio' => 'https://everyayah.com/data/Alafasy_128kbps/001006.mp3',
                'words' => [
                    [
                        'pos' => 1,
                        'text' => 'اهْدِنَا',
                        'norm' => 'اهدنا',
                        'lemma' => 'هدى',
                        'root' => 'ه د ي',
                        'en' => 'Guide us',
                        'bn' => 'আমাদের পথ দেখাও',
                        'trans' => 'Ihdinā',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_006_001.mp3',
                        'morph' => ['part_of_speech' => 'imperative verb + suffix pronoun', 'mood' => 'imperative'],
                    ],
                    [
                        'pos' => 2,
                        'text' => 'الصِّرَاطَ',
                        'norm' => 'الصراط',
                        'lemma' => 'صراط',
                        'root' => 'ص ر ط',
                        'en' => 'the path',
                        'bn' => 'পথ',
                        'trans' => 'aṣ-Ṣirāṭ',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_006_002.mp3',
                        'morph' => ['part_of_speech' => 'noun', 'case' => 'accusative'],
                    ],
                    [
                        'pos' => 3,
                        'text' => 'الْمُسْتَقِيمَ',
                        'norm' => 'المستقيم',
                        'lemma' => 'مستقيم',
                        'root' => 'ق و م',
                        'en' => 'the straight',
                        'bn' => 'সরল',
                        'trans' => 'al-Mustaqīm',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_006_003.mp3',
                        'morph' => ['part_of_speech' => 'participle form X', 'case' => 'accusative'],
                    ],
                ],
            ],
            7 => [
                'text_ar' => 'صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ',
                'trans' => 'Ṣirāṭa alladhīna an‘amta ‘alayhim ghayri al-maghḍūbi ‘alayhim wa-lā aḍ-ḍāllīn',
                'en' => 'The path of those upon whom You have bestowed favor, not of those who have evoked [Your] anger or of those who are astray.',
                'bn' => 'তাদের পথ, যাদেরকে তুমি অনুগ্রহ দান করেছ; তাদের পথ নয়, যাদের উপর তোমার গজব আপতিত হয়েছে এবং তাদেরও নয়, যারা পথভ্রষ্ট হয়েছে।',
                'audio' => 'https://everyayah.com/data/Alafasy_128kbps/001007.mp3',
                'words' => [
                    [
                        'pos' => 1,
                        'text' => 'صِرَاطَ',
                        'norm' => 'صراط',
                        'lemma' => 'صراط',
                        'root' => 'ص ر ط',
                        'en' => 'The path of',
                        'bn' => 'পথ',
                        'trans' => 'Ṣirāṭa',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_007_001.mp3',
                        'morph' => ['part_of_speech' => 'noun', 'case' => 'accusative'],
                    ],
                    [
                        'pos' => 2,
                        'text' => 'الَّذِينَ',
                        'norm' => 'الذين',
                        'lemma' => 'الذي',
                        'root' => null,
                        'en' => 'those',
                        'bn' => 'যাদের',
                        'trans' => 'alladhīna',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_007_002.mp3',
                        'morph' => ['part_of_speech' => 'relative pronoun', 'number' => 'plural'],
                    ],
                    [
                        'pos' => 3,
                        'text' => 'أَنْعَمْتَ',
                        'norm' => 'أنعمت',
                        'lemma' => 'أنعم',
                        'root' => 'ن ع م',
                        'en' => 'You have bestowed favor',
                        'bn' => 'তুমি অনুগ্রহ করেছ',
                        'trans' => 'an‘amta',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_007_003.mp3',
                        'morph' => ['part_of_speech' => 'perfect verb form IV', 'tense' => 'past', 'person' => 'second'],
                    ],
                    [
                        'pos' => 4,
                        'text' => 'عَلَيْهِمْ',
                        'norm' => 'عليهم',
                        'lemma' => 'على',
                        'root' => null,
                        'en' => 'upon them',
                        'bn' => 'তাদের ওপর',
                        'trans' => '‘alayhim',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_007_004.mp3',
                        'morph' => ['part_of_speech' => 'preposition + plural pronoun'],
                    ],
                    [
                        'pos' => 5,
                        'text' => 'غَيْرِ',
                        'norm' => 'غير',
                        'lemma' => 'غير',
                        'root' => 'غ ي ر',
                        'en' => 'not of',
                        'bn' => 'নয়',
                        'trans' => 'ghayri',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_007_005.mp3',
                        'morph' => ['part_of_speech' => 'noun', 'case' => 'genitive'],
                    ],
                    [
                        'pos' => 6,
                        'text' => 'الْمَغْضُوبِ',
                        'norm' => 'المغضوب',
                        'lemma' => 'مغضوب',
                        'root' => 'غ ض ب',
                        'en' => 'those who evoked anger',
                        'bn' => 'গযবপ্রাপ্তদের',
                        'trans' => 'al-maghḍūbi',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_007_006.mp3',
                        'morph' => ['part_of_speech' => 'passive participle', 'pattern' => 'maf‘ūl', 'case' => 'genitive'],
                    ],
                    [
                        'pos' => 7,
                        'text' => 'عَلَيْهِمْ',
                        'norm' => 'عليهم',
                        'lemma' => 'على',
                        'root' => null,
                        'en' => 'upon them',
                        'bn' => 'তাদের ওপর',
                        'trans' => '‘alayhim',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_007_007.mp3',
                        'morph' => ['part_of_speech' => 'preposition + pronoun'],
                    ],
                    [
                        'pos' => 8,
                        'text' => 'وَلَا',
                        'norm' => 'ولا',
                        'lemma' => 'لا',
                        'root' => null,
                        'en' => 'and not',
                        'bn' => 'এবং নয়',
                        'trans' => 'wa-lā',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_007_008.mp3',
                        'morph' => ['part_of_speech' => 'conjunction + negative particle'],
                    ],
                    [
                        'pos' => 9,
                        'text' => 'الضَّالِّينَ',
                        'norm' => 'الضالين',
                        'lemma' => 'ضال',
                        'root' => 'ض ل ل',
                        'en' => 'those who are astray',
                        'bn' => 'পথভ্রষ্টদের',
                        'trans' => 'aḍ-Ḍāllīn',
                        'audio' => 'https://audio.qurancdn.com/wbw/001_007_009.mp3',
                        'morph' => ['part_of_speech' => 'active participle', 'case' => 'genitive', 'number' => 'plural'],
                    ],
                ],
            ],
        ];

        foreach ($versesData as $verseNum => $vData) {
            $verse = QuranVerse::updateOrCreate(
                [
                    'quran_surah_id' => $surah->id,
                    'verse_number' => $verseNum,
                ],
                [
                    'text_ar' => $vData['text_ar'],
                    'transliteration' => $vData['trans'],
                    'translation' => $vData['en'],
                    'translation_bn' => $vData['bn'],
                    'audio_url' => $vData['audio'],
                ]
            );

            foreach ($vData['words'] as $w) {
                $rootId = null;
                if (! empty($w['root']) && isset($rootModels[$w['root']])) {
                    $rootId = $rootModels[$w['root']]->id;
                }

                $word = QuranWord::updateOrCreate(
                    [
                        'quran_verse_id' => $verse->id,
                        'position' => $w['pos'],
                    ],
                    [
                        'text_ar' => $w['text'],
                        'normalized_text' => $w['norm'],
                        'lemma' => $w['lemma'],
                        'root_id' => $rootId,
                        'translation' => $w['en'],
                        'translation_bn' => $w['bn'],
                        'transliteration' => $w['trans'],
                        'audio_url' => $w['audio'],
                    ]
                );

                if (! empty($w['morph'])) {
                    WordMorphology::updateOrCreate(
                        ['quran_word_id' => $word->id],
                        [
                            'part_of_speech' => $w['morph']['part_of_speech'],
                            'pattern' => $w['morph']['pattern'] ?? null,
                            'case' => $w['morph']['case'] ?? null,
                            'mood' => $w['morph']['mood'] ?? null,
                            'tense' => $w['morph']['tense'] ?? null,
                            'person' => $w['morph']['person'] ?? null,
                            'number' => $w['morph']['number'] ?? null,
                            'features_json' => $w['morph'],
                            'source' => 'corpus.quran.com',
                        ]
                    );
                }
            }
        }
    }
}
