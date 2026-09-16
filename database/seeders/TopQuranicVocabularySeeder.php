<?php

namespace Database\Seeders;

use App\Models\QuranSurah;
use App\Models\QuranVerse;
use App\Models\Root;
use App\Models\Vocabulary;
use App\Models\VocabularyOccurrence;
use Illuminate\Database\Seeder;

class TopQuranicVocabularySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $words = [
            ['الله', 'الله', 'Allāh', 'Allah (God)', 'আল্লাহ', 'إ ل ه', 'proper noun', 2699, 1],
            ['مِنْ', 'من', 'Min', 'From / Among', 'হতে / থেকে', null, 'preposition', 3226, 1],
            ['فِي', 'في', 'Fī', 'In / Concerning', 'মধ্যে / ভিতরে', null, 'preposition', 1701, 1],
            ['مَا', 'ما', 'Mā', 'What / Not / That which', 'যা / না', null, 'relative pronoun / particle', 2100, 1],
            ['إِنَّ', 'إن', 'Inna', 'Indeed / Truly', 'নিশ্চয়', null, 'particle', 1533, 1],
            ['عَلَى', 'على', '‘Alā', 'Upon / On / Over', 'উপরে', null, 'preposition', 1445, 1],
            ['أَنَّ', 'أن', 'Anna', 'That', 'যে', null, 'particle', 1200, 1],
            ['لَا', 'لا', 'Lā', 'No / Not', 'না', null, 'negative particle', 1726, 1],
            ['إِلَى', 'إلى', 'Ilā', 'To / Towards', 'দিকে / পর্যন্ত', null, 'preposition', 742, 1],
            ['كَانَ', 'كان', 'Kāna', 'He was / Is', 'ছিল / হয়েছে', 'ك و ن', 'verb', 1358, 2],
            ['قَالَ', 'قال', 'Qāla', 'He said', 'সে বলল', 'ق و ل', 'verb', 1618, 1],
            ['الَّذِي', 'الذي', 'Alladhī', 'The one who / Which', 'যিনি / যা', null, 'relative pronoun', 1460, 1],
            ['رَبّ', 'رب', 'Rabb', 'Lord / Sustainer', 'প্রতিপালক / রব', 'ر ب ب', 'noun', 975, 1],
            ['آمَنَ', 'آمن', 'Āmana', 'He believed', 'ঈমান এনেছে', 'أ م ن', 'verb', 537, 2],
            ['عَلِمَ', 'علم', '‘Alima', 'He knew', 'সে জানল', 'ع ل م', 'verb', 518, 2],
            ['يَوْم', 'يوم', 'Yawm', 'Day', 'দিন / দিবস', 'ي و م', 'noun', 393, 1],
            ['آيَة', 'آية', 'Āyah', 'Sign / Verse', 'নিদর্শন / আয়াত', 'أ ي ي', 'noun', 382, 1],
            ['كِتَاب', 'كتاب', 'Kitāb', 'Book / Scripture', 'কিতাব / গ্রন্থ', 'ك ت ب', 'noun', 260, 1],
            ['أَرْض', 'أرض', 'Arḍ', 'Earth / Land', 'পৃথিবী / জমিন', 'أ ر ض', 'noun', 461, 1],
            ['سَمَاء', 'سماء', 'Samā’', 'Sky / Heaven', 'আকাশ', 'س م و', 'noun', 310, 1],
            ['قَوْم', 'قوم', 'Qawm', 'People', 'জাতি / সম্প্রদায়', 'ق و م', 'noun', 383, 1],
            ['نَفْس', 'نفس', 'Nafs', 'Soul / Self', 'আত্মা / প্রাণ', 'ن ف س', 'noun', 295, 2],
            ['رَسُول', 'رسول', 'Rasūl', 'Messenger', 'রাসূল / বার্তাবাহক', 'ر س ل', 'noun', 332, 1],
            ['عَبْد', 'عبد', '‘Abd', 'Servant / Slave', 'বান্দা / দাস', 'ع ب د', 'noun', 275, 1],
            ['حَقّ', 'حق', 'Ḥaqq', 'Truth / Right', 'সত্য / হক', 'ح ق ق', 'noun', 247, 1],
            ['قَلْب', 'قلب', 'Qalb', 'Heart', 'অন্তর / হৃদয়', 'ق ل ب', 'noun', 168, 1],
            ['نُور', 'نور', 'Nūr', 'Light', 'আলো / নূর', 'ن و ر', 'noun', 194, 1],
            ['رَحْمَة', 'رحمة', 'Raḥmah', 'Mercy', 'দয়া / রহমত', 'ر ح م', 'noun', 145, 1],
            ['عَذَاب', 'عذاب', '‘Adhāb', 'Punishment / Torment', 'শাস্তি / আযাব', 'ع ذ ب', 'noun', 322, 1],
            ['جَنَّة', 'جنة', 'Jannah', 'Garden / Paradise', 'জান্নাত / বাগান', 'ج ن ن', 'noun', 147, 1],
            ['نَار', 'نار', 'Nār', 'Fire / Hell', 'আগুন / জাহান্নাম', 'ن و ر', 'noun', 145, 1],
            ['خَيْر', 'خير', 'Khayr', 'Good / Better', 'উত্তম / কল্যাণ', 'خ ي ر', 'noun / adj', 176, 1],
            ['شَرّ', 'شر', 'Sharr', 'Evil / Worse', 'মন্দ / অনিষ্ট', 'ش ر ر', 'noun / adj', 31, 1],
            ['عَمَل', 'عمل', '‘Amal', 'Deed / Action / Work', 'কাজ / আমল', 'ع م ل', 'noun', 360, 1],
            ['صَالِح', 'صالح', 'Ṣāliḥ', 'Righteous / Good', 'সৎকর্মশীল', 'ص ل ح', 'active participle', 136, 1],
            ['صِرَاط', 'صراط', 'Ṣirāṭ', 'Path / Way', 'পথ / রাস্তা', 'ص ر ط', 'noun', 45, 1],
            ['هُدًى', 'هدى', 'Hudan', 'Guidance', 'হেদায়াত / পথনির্দেশ', 'ه د ي', 'noun', 85, 1],
            ['دِين', 'دين', 'Dīn', 'Way of life / Judgment / Religion', 'জীবনবিধান / দ্বীন', 'د ي ن', 'noun', 92, 1],
            ['مَلَك', 'ملك', 'Malak', 'Angel', 'ফেরেশতা', 'م ل ك', 'noun', 88, 1],
            ['نَبِيّ', 'نبي', 'Nabī', 'Prophet', 'নবী', 'ن ب أ', 'noun', 75, 1],
            ['دُنْيَا', 'دنيا', 'Dunyā', 'World / Present life', 'দুনিয়া / পার্থিব জীবন', 'د ن و', 'noun', 115, 1],
            ['آخِرَة', 'آخرة', 'Ākhirah', 'Hereafter', 'আখেরাত / পরকাল', 'أ خ ر', 'noun', 115, 1],
            ['شَيْء', 'شيء', 'Shay’', 'Thing', 'বস্তু / বিষয়', 'ش ي أ', 'noun', 283, 1],
            ['أَهْل', 'أهل', 'Ahl', 'People / Family / Inhabitants', 'পরিবার / অধিবাসী', 'أ ه ل', 'noun', 127, 1],
            ['سَبِيل', 'سبيل', 'Sabīl', 'Way / Path / Cause', 'পথ / উপায়', 'س ب ل', 'noun', 176, 1],
            ['ظُلْم', 'ظلم', 'Ẓulm', 'Wrongdoing / Injustice / Darkness', 'অন্যায় / জুলুম', 'ظ ل م', 'noun', 289, 2],
            ['حِكْمَة', 'حكمة', 'Ḥikmah', 'Wisdom', 'প্রজ্ঞা / হেকমত', 'ح ك م', 'noun', 20, 2],
            ['شُكْر', 'شكر', 'Shukr', 'Gratitude / Thanks', 'কৃতজ্ঞতা', 'ش ك ر', 'noun', 75, 2],
            ['صَبْر', 'صبر', 'Ṣabr', 'Patience / Steadfastness', 'ধৈর্য', 'ص ب ر', 'noun', 103, 2],
            ['تَوْبَة', 'توبة', 'Tawbah', 'Repentance / Turning back', 'তওবা / প্রত্যাবর্তন', 'ت و ب', 'noun', 87, 2],
            ['مَوْت', 'موت', 'Mawt', 'Death', 'মৃত্যু', 'م و ت', 'noun', 165, 1],
            ['حَيَاة', 'حياة', 'Ḥayāh', 'Life', 'জীবন', 'ح ي ي', 'noun', 145, 1],
            ['إِلَٰه', 'إله', 'Ilāh', 'Deity / God', 'ইলাহ / উপাস্য', 'إ ل ه', 'noun', 147, 1],
            ['غَفُور', 'غفور', 'Ghafūr', 'Oft-Forgiving', 'পরম ক্ষমাশীল', 'غ ف ر', 'adjective', 91, 1],
            ['عَزِيز', 'عزيز', '‘Azīz', 'Almighty / Invulnerable', 'মহামরাক্রান্তশালী', 'ع ز ز', 'adjective', 99, 1],
            ['حَكِيم', 'حكيم', 'Ḥakīm', 'All-Wise', 'প্রজ্ঞাময়', 'ح ك م', 'adjective', 97, 1],
            ['سَمِيع', 'سميع', 'Samī‘', 'All-Hearing', 'সর্বশ্রোতা', 'س م ع', 'adjective', 47, 1],
            ['بَصِير', 'بصير', 'Baṣīr', 'All-Seeing', 'সর্বদ্রষ্টা', 'ب ص ر', 'adjective', 51, 1],
            ['خَلَقَ', 'خلق', 'Khalaqa', 'He created', 'তিনি সৃষ্টি করেছেন', 'خ ل ق', 'verb', 261, 1],
            ['جَعَلَ', 'جعل', 'Ja‘ala', 'He made / Appointed', 'তিনি বানিয়েছেন', 'ج ع ل', 'verb', 346, 1],
            ['أَنْزَلَ', 'أنزل', 'Anzala', 'He sent down / Revealed', 'তিনি নাযিল করেছেন', 'ن ز ل', 'verb', 293, 2],
            ['أَرْسَلَ', 'أرسل', 'Arsala', 'He dispatched / Sent', 'তিনি পাঠিয়েছেন', 'ر س ل', 'verb', 170, 2],
            ['جَاءَ', 'جاء', 'Jā’a', 'He came / Arrived', 'সে এলো', 'ج ي أ', 'verb', 278, 1],
            ['أَتَى', 'أتى', 'Atā', 'He brought / Came', 'সে নিয়ে এলো', 'أ ت ي', 'verb', 271, 1],
            ['رَأَى', 'رأى', 'Ra’ā', 'He saw / Considered', 'সে দেখল', 'ر أ ي', 'verb', 271, 1],
            ['ذَهَبَ', 'ذهب', 'Dhahaba', 'He went / Departed', 'সে চলে গেল', 'ذ ه ب', 'verb', 56, 1],
            ['دَخَلَ', 'دخل', 'Dakhala', 'He entered', 'সে প্রবেশ করল', 'د خ ل', 'verb', 123, 1],
            ['خَرَجَ', 'خرج', 'Kharaja', 'He came out / Exited', 'সে বের হয়ে এলো', 'خ ر ج', 'verb', 182, 1],
            ['أَكَلَ', 'أكل', 'Akala', 'He ate / Consumed', 'সে আহার করল', 'أ ك ل', 'verb', 109, 1],
            ['شَرِبَ', 'شرب', 'Shariba', 'He drank', 'সে পান করল', 'ش ر ب', 'verb', 39, 1],
            ['ذَكَرَ', 'ذكر', 'Dhakara', 'He remembered / Mentioned', 'সে স্মরণ করল', 'ذ ك ر', 'verb', 292, 1],
            ['شَهِدَ', 'شهد', 'Shahida', 'He witnessed / Testified', 'সে সাক্ষ্য দিল', 'ش ه د', 'verb', 160, 1],
            ['سَأَلَ', 'سأل', 'Sa’ala', 'He asked / Inquired', 'সে প্রশ্ন করল', 'س أ ل', 'verb', 129, 1],
            ['أَمَرَ', 'أمر', 'Amara', 'He commanded / Ordered', 'তিনি নির্দেশ দিলেন', 'أ م ر', 'verb', 248, 1],
            ['نَهَى', 'نهى', 'Nahā', 'He forbade / Prohibited', 'তিনি নিষেধ করলেন', 'ن ه ي', 'verb', 56, 1],
            ['وَعَدَ', 'وعد', 'Wa‘ada', 'He promised', 'তিনি ওয়াদা করলেন', 'و ع د', 'verb', 151, 1],
            ['خَافَ', 'خاف', 'Khāfa', 'He feared', 'সে ভয় পেল', 'خ و ف', 'verb', 124, 1],
            ['رَجَا', 'رجا', 'Rajā', 'He hoped / Expected', 'সে আশা করল', 'ر ج و', 'verb', 28, 1],
            ['نَصَرَ', 'نصر', 'Naṣara', 'He helped / Gave victory', 'তিনি সাহায্য করলেন', 'ن ص ر', 'verb', 150, 1],
            ['فَتَحَ', 'فتح', 'Fataḥa', 'He opened / Granted victory', 'তিনি উন্মুক্ত করলেন', 'ف ت ح', 'verb', 38, 1],
            ['غَفَرَ', 'غفر', 'Ghafara', 'He forgave', 'তিনি ক্ষমা করলেন', 'غ ف ر', 'verb', 234, 1],
            ['رَحِمَ', 'رحم', 'Raḥima', 'He had mercy', 'তিনি দয়া করলেন', 'ر ح م', 'verb', 339, 1],
            ['هَدَى', 'هدى', 'Hadā', 'He guided', 'তিনি পথ দেখালেন', 'ه د ي', 'verb', 155, 1],
            ['ضَلَّ', 'ضل', 'Ḍalla', 'He strayed / Erred', 'সে পথভ্রষ্ট হলো', 'ض ل ل', 'verb', 191, 1],
            ['كَفَرَ', 'كفر', 'Kafara', 'He disbelieved / Denied', 'সে অস্বীকার করল', 'ك ف ر', 'verb', 525, 1],
            ['أَسْلَمَ', 'أسلم', 'Aslama', 'He submitted in peace', 'সে আত্মসমর্পণ করল', 'س ل م', 'verb', 72, 2],
            ['صَلَاة', 'صلاة', 'Ṣalāh', 'Ritual Prayer', 'নামাজ / সালাত', 'ص ل و', 'noun', 83, 1],
            ['زَكَاة', 'زكاة', 'Zakāh', 'Purifying Alms', 'যাকাত', 'ز ك و', 'noun', 32, 1],
            ['صِيَام', 'صيام', 'Ṣiyām', 'Fasting', 'রোজা / সিয়াম', 'ص و م', 'noun', 8, 2],
            ['حَجّ', 'حج', 'Ḥajj', 'Pilgrimage', 'হজ', 'ح ج ج', 'noun', 12, 2],
            ['جِهَاد', 'جهاد', 'Jihād', 'Striving in the cause of God', 'সংগ্রাম / জিহাদ', 'ج ه د', 'noun', 35, 2],
            ['مَال', 'مال', 'Māl', 'Wealth / Possessions', 'ধনসম্পদ', 'م و ل', 'noun', 86, 1],
            ['وَلَد', 'ولد', 'Walad', 'Child / Son', 'সন্তান', 'و ل د', 'noun', 102, 1],
            ['أَب', 'أب', 'Ab', 'Father', 'পিতা / বাবা', 'أ ب و', 'noun', 117, 1],
            ['أُمّ', 'أم', 'Umm', 'Mother / Source', 'মা / উৎস', 'أ م م', 'noun', 35, 1],
            ['أَخ', 'أخ', 'Akh', 'Brother', 'ভাই', 'أ خ و', 'noun', 96, 1],
            ['شَهْر', 'شهر', 'Shahr', 'Month', 'মাস', 'ش ه ر', 'noun', 21, 1],
            ['سَنَة', 'سنة', 'Sanah', 'Year', 'বছর', 'س ن ه', 'noun', 19, 1],
            ['لَيْل', 'ليل', 'Layl', 'Night', 'রাত / রজনী', 'ل ي ل', 'noun', 92, 1],
            ['نَهَار', 'نهار', 'Nahār', 'Daylight', 'দিন', 'ن ه ر', 'noun', 57, 1],
            ['الرَّحْمَٰن', 'الرحمن', 'Ar-Raḥmān', 'The Most Gracious', 'পরম করুণাময়', 'ر ح م', 'proper noun / adj', 57, 1],
            ['الرَّحِيم', 'الرحيم', 'Ar-Raḥīm', 'The Most Merciful', 'অতি দয়ালু', 'ر ح م', 'proper noun / adj', 115, 1],
            ['قُلْ', 'قل', 'Qul', 'Say! / Proclaim!', 'বলুন', 'ق و ل', 'verb (imperative)', 332, 1],
            ['إِنْسَان', 'إنسان', 'Insān', 'Human being / Mankind', 'মানুষ / মানবজাতি', 'أ ن س', 'noun', 65, 1],
            ['عِلْم', 'علم', '‘Ilm', 'Knowledge', 'জ্ঞান', 'ع ل م', 'noun', 105, 1],
            ['قُرْآن', 'قرآن', 'Qur’ān', 'Quran / Recitation', 'কুরআন / পাঠ', 'ق ر أ', 'proper noun', 70, 1],
            ['شَيْطَان', 'شيطان', 'Shayṭān', 'Satan / Devil', 'শয়তান', 'ش ط ن', 'noun', 88, 1],
            ['شَمْس', 'شمس', 'Shams', 'Sun', 'সূর্য', 'ش م س', 'noun', 33, 1],
            ['قَمَر', 'قمر', 'Qamar', 'Moon', 'চাঁদ', 'ق م ر', 'noun', 27, 1],
            ['بَحْر', 'بحر', 'Baḥr', 'Sea / Ocean', 'সাগর / সমুদ্র', 'ب ح ر', 'noun', 41, 1],
            ['جَبَل', 'جبل', 'Jabal', 'Mountain', 'পাহাড় / পর্বত', 'ج ب ل', 'noun', 39, 1],
            ['شَجَر', 'شجر', 'Shajar', 'Tree / Plant', 'গাছপালা / বৃক্ষ', 'ش ج ر', 'noun', 27, 1],
            ['مَاء', 'ماء', 'Mā’', 'Water', 'পানি', 'م و ه', 'noun', 63, 1],
            ['رِيح', 'ريح', 'Rīḥ', 'Wind / Breeze', 'বাতাস / বায়ু', 'ر ي ح', 'noun', 29, 1],
            ['أَجْر', 'أجر', 'Ajr', 'Reward / Divine wage', 'প্রতিদান / পুরস্কার', 'أ ج ر', 'noun', 108, 1],
            ['فَوْز', 'فوز', 'Fawz', 'Supreme triumph', 'সাফল্য / মুক্তি', 'ف و ز', 'noun', 29, 1],
            ['صِدْق', 'صدق', 'Ṣidq', 'Truthfulness / Sincerity', 'সত্যতা / সত্যবাদিতা', 'ص د ق', 'noun', 155, 1],
            ['كَذِب', 'كذب', 'Kadhib', 'Falsehood / Lie', 'মিথ্যা', 'ك ذ ب', 'noun', 282, 1],
            ['جَهَنَّم', 'جهنم', 'Jahannam', 'Hellfire', 'জাহান্নাম', null, 'proper noun', 77, 1],
            ['بَيْت', 'بيت', 'Bayt', 'House / Sanctuary', 'ঘর / গৃহ', 'ب ي ت', 'noun', 64, 1],
            ['مَسْجِد', 'مسجد', 'Masjid', 'Mosque / Prostration place', 'মসজিদ / সিজদার স্থান', 'س ج د', 'noun', 28, 1],
            ['صَدَقَة', 'صدقة', 'Ṣadaqah', 'Charity / Voluntary alms', 'দান / সদকা', 'ص د ق', 'noun', 13, 1],
            ['قُوَّة', 'قوة', 'Quwwah', 'Power / Might', 'শক্তি / সামর্থ্য', 'ق و ي', 'noun', 28, 1],
            ['مُؤْمِن', 'مؤمن', 'Mu’min', 'Believer', 'মুমিন / বিশ্বাসী', 'أ م ن', 'active participle', 230, 1],
            ['كَافِر', 'كافر', 'Kāfir', 'Disbeliever', 'কাফের / অবিশ্বাসী', 'ك ف ر', 'active participle', 134, 1],
            ['مُنَافِق', 'منافق', 'Munāfiq', 'Hypocrite', 'মুনাফিক / ভণ্ড', 'ن ف ق', 'active participle', 37, 1],
            ['حَمْد', 'حمد', 'Ḥamd', 'All praise and gratitude', 'সকল প্রশংসা', 'ح م د', 'noun', 43, 1],
            ['سَلَام', 'سلام', 'Salām', 'Peace / Safety', 'শান্তি / সালাম', 'س ل م', 'noun', 42, 1],
            ['إِسْلَام', 'إسلام', 'Islām', 'Submission to God', 'ইসলাম / আত্মসমর্পণ', 'س ل م', 'noun', 8, 1],
            ['إِيمَان', 'إيمان', 'Īmān', 'Faith / True conviction', 'ঈমান / বিশ্বাস', 'أ م ن', 'noun', 45, 1],
            ['تَقْوَى', 'تقوى', 'Taqwā', 'God-consciousness / Piety', 'তাকওয়া / খোদাভীতি', 'و ق ي', 'noun', 17, 1],
            ['بَرَكَة', 'بركة', 'Barakah', 'Blessing / Divine grace', 'বরকত / কল্যাণ', 'ب ر ك', 'noun', 32, 1],
            ['حَسَنَة', 'حسنة', 'Ḥasanah', 'Good deed / Merit', 'সৎকর্ম / পুণ্য', 'ح س ن', 'noun', 28, 1],
            ['سَيِّئَة', 'سيئة', 'Sayyi’ah', 'Evil deed / Sin', 'পাপ / অসৎকর্ম', 'س و أ', 'noun', 36, 1],
            ['نِعْمَة', 'نعمة', 'Ni‘mah', 'Favor / Bounty', 'নেয়ামত / অনুগ্রহ', 'ن ع م', 'noun', 75, 1],
            ['قِيَامَة', 'قيامة', 'Qiyāmah', 'Day of Resurrection', 'কিয়ামত / পুনরুত্থান', 'ق ও م', 'noun', 70, 1],
            ['حِسَاب', 'حساب', 'Ḥisāb', 'Account / Reckoning', 'হিসাব', 'ح س ب', 'noun', 39, 1],
            ['مِيزَان', 'ميزان', 'Mīzān', 'Balance / Justice Scale', 'দাঁড়িপাল্লা / তুলাদণ্ড', 'و ز ن', 'noun', 9, 1],
            ['كَوْثَر', 'كوثر', 'Kawthar', 'Abundance / Blessed River', 'কাউসার / প্রাচুর্য', 'ك ث ر', 'proper noun', 1, 1],
            ['فِرْدَوْس', 'فردوس', 'Firdaws', 'Highest Garden of Paradise', 'জান্নাতুল ফেরদৌস', null, 'proper noun', 2, 1],
            ['غَيْب', 'غيب', 'Ghayb', 'The Unseen realm', 'অদৃশ্য / গায়েব', 'غ ي ب', 'noun', 49, 1],
            ['قُدُّوس', 'قدوس', 'Quddūs', 'The Holy and Pure', 'মহা পবিত্র', 'ق د س', 'adjective', 2, 1],
            ['سُبْحَان', 'سبحان', 'Subḥān', 'Glory be to / Exalted is', 'মহাপবিত্রতা', 'س ب ح', 'noun', 41, 1],
            ['كَبِير', 'كبير', 'Kabīr', 'Great / Mighty', 'বড় / মহান', 'ك ب ر', 'adjective', 45, 1],
            ['صَغِير', 'صغير', 'Ṣaghīr', 'Small / Modest', 'ছোট', 'ص غ ر', 'adjective', 6, 1],
            ['قَرِيب', 'قريب', 'Qarīb', 'Near / Close', 'কাছের / নিকটে', 'ق ر ب', 'adjective', 26, 1],
            ['بَعِيد', 'بعيد', 'Ba‘īd', 'Far / Distant', 'দূরবর্তী / দূরে', 'ب ع د', 'adjective', 25, 1],
            ['شَاهِد', 'شاهد', 'Shāhid', 'Witness', 'সাক্ষী', 'ش ه د', 'active participle', 16, 1],
            ['بَشِير', 'بشير', 'Bashīr', 'Bringer of good news', 'সুসংবাদদাতা', 'ب ش ر', 'noun', 16, 1],
            ['نَذِير', 'نذير', 'Nadhīr', 'Warner', 'সতর্ককারী', 'ن ذ ر', 'noun', 44, 1],
            ['أَمِين', 'أمين', 'Amīn', 'Trustworthy / Faithful', 'বিশ্বস্ত', 'أ م ن', 'adjective', 14, 1],
            ['مُسْتَقِيم', 'مستقيم', 'Mustaqīm', 'Straight / Upright', 'সরল / সঠিক', 'ق و م', 'adjective', 37, 1],
            ['فَضْل', 'فضل', 'Faḍl', 'Bounty / Grace', 'অনুগ্রহ / মর্যাদা', 'ف ض ل', 'noun', 84, 1],
            ['عَرْش', 'عرش', '‘Arsh', 'Throne of majesty', 'আরশ / সিংহাসন', 'ع ر ش', 'noun', 26, 1],
            ['كُرْسِيّ', 'كرسي', 'Kursī', 'Footstool of dominion', 'কুরসি', 'ك ر س', 'noun', 2, 1],
            ['قَلَم', 'قلم', 'Qalam', 'The Pen', 'কলম', 'ق ل م', 'noun', 2, 1],
            ['نَجْم', 'نجم', 'Najm', 'Star / Celestial body', 'তারা / নক্ষত্র', 'ن ج ম', 'noun', 13, 1],
            ['حُبّ', 'حب', 'Ḥubb', 'Love / Affection', 'ভালোবাসা / মহব্বত', 'ح ب ب', 'noun', 7, 1],
        ];

        $fatihahSurah = QuranSurah::where('number', 1)->first();
        $fatihahVerse1 = QuranVerse::where('quran_surah_id', $fatihahSurah?->id)->where('verse_number', 1)->first();

        foreach ($words as $w) {
            $rootId = null;
            if (! empty($w[5])) {
                $root = Root::firstOrCreate(
                    ['root_ar' => $w[5]],
                    [
                        'root_latin' => str_replace(' ', '-', $w[5]),
                        'meaning' => $w[3],
                    ]
                );
                $rootId = $root->id;
            }

            $vocab = Vocabulary::updateOrCreate(
                ['arabic' => $w[0]],
                [
                    'normalized_arabic' => $w[1],
                    'transliteration' => $w[2],
                    'meaning_en' => $w[3],
                    'meaning_bn' => $w[4],
                    'root_id' => $rootId,
                    'part_of_speech' => $w[6],
                    'frequency' => $w[7],
                    'difficulty' => $w[8],
                ]
            );

            if ($fatihahSurah && $fatihahVerse1 && in_array($w[0], ['الله', 'رَبّ', 'صِرَاط', 'دِين', 'عَبْد', 'الرَّحْمَٰنِ', 'الرَّحِيمِ'])) {
                VocabularyOccurrence::firstOrCreate([
                    'vocabulary_id' => $vocab->id,
                    'quran_surah_id' => $fatihahSurah->id,
                    'quran_verse_id' => $fatihahVerse1->id,
                ]);
            }
        }
    }
}
