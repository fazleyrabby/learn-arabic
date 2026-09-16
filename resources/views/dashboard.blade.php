<x-layouts.app>
    <x-slot:title>The Quranic Arabic Path</x-slot:title>

    <div class="space-y-16">
        <!-- Hero Section: Pure Typographic Statement without Eyebrow/Kicker -->
        <div class="space-y-4 max-w-3xl">
            <h1 class="text-3xl sm:text-5xl font-semibold tracking-tight text-[#181C1E] dark:text-white leading-[1.15]">
                Learn the script. Master the vocabulary. Understand the Quran.
            </h1>
            <p class="text-base sm:text-lg text-[#5C656C] dark:text-[#94A3B8] leading-relaxed">
                A serene, distraction-free environment built upon authoritative corpus linguistics. Move progressively from foundational phonetics to word-by-word grammatical analysis.
            </p>
        </div>

        <!-- Metric Anchors -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 py-6 border-y border-[#E8E2D8] dark:border-[#1E2738]">
            <div class="space-y-1">
                <div class="text-2xl sm:text-3xl font-bold tracking-tight text-[#181C1E] dark:text-white tabular-nums">{{ $letterCount }}</div>
                <div class="text-xs text-[#5C656C] dark:text-[#94A3B8]">Arabic Consonants</div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl sm:text-3xl font-bold tracking-tight text-[#181C1E] dark:text-white tabular-nums">{{ $harakatCount }}</div>
                <div class="text-xs text-[#5C656C] dark:text-[#94A3B8]">Vowelling Rules</div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl sm:text-3xl font-bold tracking-tight text-[#181C1E] dark:text-white tabular-nums">{{ $vocabCount }}+</div>
                <div class="text-xs text-[#5C656C] dark:text-[#94A3B8]">Quranic Words (>50% text)</div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl sm:text-3xl font-bold tracking-tight text-[#1B4D3E] dark:text-emerald-400 tabular-nums">{{ $dueCount }}</div>
                <div class="text-xs text-[#5C656C] dark:text-[#94A3B8]">Spaced Reviews Due</div>
            </div>
        </div>

        <!-- Junior & 5-Year-Old Friendly Learning Hub -->
        <div class="rounded-3xl bg-gradient-to-br from-emerald-50 via-amber-50/40 to-teal-50 dark:from-[#131926] dark:via-[#111723] dark:to-[#0B0F19] border-2 border-emerald-300 dark:border-emerald-700/60 p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-200/60 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300 mb-2">
                        <span>⭐ {{ app()->getLocale() === 'bn' ? '৫ বছর বয়সীদের জন্য সহজ আরবি শিক্ষা' : 'Kids & Little Stars Friendly (Ages 5+)' }}</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#181C1E] dark:text-white">
                        {{ app()->getLocale() === 'bn' ? 'ছোটদের আনন্দময় আরবি শিক্ষা হাব' : 'Joyful Arabic Learning for Children' }}
                    </h2>
                    <p class="text-xs sm:text-sm text-[#5C656C] dark:text-[#94A3B8] mt-1">
                        {{ app()->getLocale() === 'bn' 
                            ? 'বড় বড় বাটন, স্পর্শ করলেই মিষ্টি উচ্চারণ এবং শব্দে শব্দে কুরআন শেখার সহজ পরিবেশ।' 
                            : 'Huge touchable cards, instant clear pronunciation on tap, and word-by-word Quran recitation.' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1: Alphabet Soundboard -->
                <a href="{{ route('alphabet.index', ['tab' => 'kids']) }}" class="group rounded-2xl bg-white dark:bg-[#1B2332] border border-[#E8E2D8] dark:border-[#212B3E] hover:border-amber-400 p-5 space-y-3 shadow-xs hover:shadow-md hover:scale-[1.02] active:scale-95 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 flex items-center justify-center text-2xl font-bold">
                        🎈
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#181C1E] dark:text-white group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400">
                            {{ app()->getLocale() === 'bn' ? 'হরফ সাউন্ডবোর্ড' : 'Letter Soundboard' }}
                        </h3>
                        <p class="text-xs text-[#5C656C] dark:text-[#94A3B8] mt-1">
                            {{ app()->getLocale() === 'bn' ? '২৮টি হরফে স্পর্শ করলেই শুনবে উচ্চারণ ও স্টার পাবে।' : 'Touch any of the 28 letters to hear its sound and collect stars!' }}
                        </p>
                    </div>
                    <div class="text-[11px] font-bold text-amber-600 dark:text-amber-400 flex items-center gap-1">
                        <span>{{ app()->getLocale() === 'bn' ? 'হরফ শুনুন' : 'Tap & Listen' }}</span>
                        <span>&rarr;</span>
                    </div>
                </a>

                <!-- Card 2: Vowel Magic Ba-Bi-Bu -->
                <a href="{{ route('alphabet.index', ['tab' => 'kids']) }}" class="group rounded-2xl bg-white dark:bg-[#1B2332] border border-[#E8E2D8] dark:border-[#212B3E] hover:border-emerald-400 p-5 space-y-3 shadow-xs hover:shadow-md hover:scale-[1.02] active:scale-95 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 flex items-center justify-center text-2xl font-bold">
                        🎵
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#181C1E] dark:text-white group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400">
                            {{ app()->getLocale() === 'bn' ? 'বা - বি - বু ম্যাজিক' : 'Ba - Bi - Bu Sound Machine' }}
                        </h3>
                        <p class="text-xs text-[#5C656C] dark:text-[#94A3B8] mt-1">
                            {{ app()->getLocale() === 'bn' ? 'জবর, জের, পেশ মিলিয়ে হরকত দিয়ে পড়া শিখুন।' : 'Mix letters with Fatḥah, Kasrah & Ḍammah to master phonics.' }}
                        </p>
                    </div>
                    <div class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                        <span>{{ app()->getLocale() === 'bn' ? 'ম্যাজিক শুরু' : 'Try Mixer' }}</span>
                        <span>&rarr;</span>
                    </div>
                </a>

                <!-- Card 3: 4 Quls & Kids Favorites -->
                <a href="{{ route('quran.index', ['tab' => 'kids']) }}" class="group rounded-2xl bg-white dark:bg-[#1B2332] border border-[#E8E2D8] dark:border-[#212B3E] hover:border-blue-400 p-5 space-y-3 shadow-xs hover:shadow-md hover:scale-[1.02] active:scale-95 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 flex items-center justify-center text-2xl font-bold">
                        ⭐
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#181C1E] dark:text-white group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400">
                            {{ app()->getLocale() === 'bn' ? 'ছোটদের প্রিয় সূরা' : 'Kids 4 Quls & Favorites' }}
                        </h3>
                        <p class="text-xs text-[#5C656C] dark:text-[#94A3B8] mt-1">
                            {{ app()->getLocale() === 'bn' ? 'আল-ফাতিহা, ইখলাস, ফালাক, নাস ও কাওসার সহজে শিখুন।' : 'Surah Al-Fatihah, 4 Quls & short Surahs with word tap.' }}
                        </p>
                    </div>
                    <div class="text-[11px] font-bold text-blue-600 dark:text-blue-400 flex items-center gap-1">
                        <span>{{ app()->getLocale() === 'bn' ? 'সূরা শুনুন' : 'Explore Surahs' }}</span>
                        <span>&rarr;</span>
                    </div>
                </a>

                <!-- Card 4: Complete Holy Quran Studio -->
                <a href="{{ route('quran.index', ['tab' => 'all']) }}" class="group rounded-2xl bg-white dark:bg-[#1B2332] border border-[#E8E2D8] dark:border-[#212B3E] hover:border-purple-400 p-5 space-y-3 shadow-xs hover:shadow-md hover:scale-[1.02] active:scale-95 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 flex items-center justify-center text-2xl font-bold">
                        📖
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#181C1E] dark:text-white group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400">
                            {{ app()->getLocale() === 'bn' ? 'সকল ১১৪টি সূরা' : 'Complete 114 Surahs' }}
                        </h3>
                        <p class="text-xs text-[#5C656C] dark:text-[#94A3B8] mt-1">
                            {{ app()->getLocale() === 'bn' ? 'মিশারী রাশেদ আলাফাসীর তেলাওয়াত ও বাংলা অর্থ।' : 'Mishary Rashid Alafasy recitation with English & Bengali meanings.' }}
                        </p>
                    </div>
                    <div class="text-[11px] font-bold text-purple-600 dark:text-purple-400 flex items-center gap-1">
                        <span>{{ app()->getLocale() === 'bn' ? 'স্টুডিও খুলুন' : 'Open Quran' }}</span>
                        <span>&rarr;</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Sequential Curriculum Pathway -->
        <div class="space-y-8">
            <div class="flex items-baseline justify-between border-b border-[#E8E2D8] dark:border-[#1E2738] pb-3">
                <h2 class="text-xl font-semibold text-[#181C1E] dark:text-white tracking-tight">Structured Learning Sequence</h2>
                <span class="text-xs text-[#5C656C] dark:text-[#94A3B8]">Five progressive stages</span>
            </div>

            <div class="relative divide-y divide-[#E8E2D8] dark:divide-[#1E2738]">
                <!-- Stage 1: Alphabet -->
                <a href="{{ route('alphabet.index') }}" class="group py-6 block hover:bg-[#FAF8F5]/60 dark:hover:bg-[#111723]/60 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-baseline gap-4 sm:gap-6">
                            <span class="font-mono text-sm font-semibold text-[#5C656C] dark:text-[#94A3B8] w-6 shrink-0">01</span>
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-[#181C1E] dark:text-white group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400 transition-colors">
                                        Alphabet & Positional Forms
                                    </h3>
                                    <span class="font-arabic text-xl text-[#1B4D3E] dark:text-emerald-400 select-none">ب ت ث</span>
                                </div>
                                <p class="text-sm text-[#5C656C] dark:text-[#94A3B8] max-w-2xl">
                                    Learn all 28 consonants across isolated, initial, medial, and final shapes, paired with anatomical articulatory points (makhārij).
                                </p>
                            </div>
                        </div>
                        <div class="text-xs font-medium text-[#1B4D3E] dark:text-emerald-400 shrink-0 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            <span>Explore 28 letters</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                </a>

                <!-- Stage 2: Harakat -->
                <a href="{{ route('alphabet.index', ['tab' => 'harakat']) }}" class="group py-6 block hover:bg-[#FAF8F5]/60 dark:hover:bg-[#111723]/60 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-baseline gap-4 sm:gap-6">
                            <span class="font-mono text-sm font-semibold text-[#5C656C] dark:text-[#94A3B8] w-6 shrink-0">02</span>
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-[#181C1E] dark:text-white group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400 transition-colors">
                                        Harakat & The Vowelling System
                                    </h3>
                                    <span class="font-arabic text-2xl text-[#9A722C] dark:text-amber-400 select-none">بَ بِ بُ بْ بّ</span>
                                </div>
                                <p class="text-sm text-[#5C656C] dark:text-[#94A3B8] max-w-2xl">
                                    Master short vowels (Fatḥah, Kasrah, Ḍammah), the quiescent stop (Sukūn), consonant doubling (Shaddah), and nunation (Tanwīn).
                                </p>
                            </div>
                        </div>
                        <div class="text-xs font-medium text-[#1B4D3E] dark:text-emerald-400 shrink-0 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            <span>Study vowelling</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                </a>

                <!-- Stage 3: High-Frequency Vocabulary -->
                <a href="{{ route('vocabulary.index') }}" class="group py-6 block hover:bg-[#FAF8F5]/60 dark:hover:bg-[#111723]/60 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-baseline gap-4 sm:gap-6">
                            <span class="font-mono text-sm font-semibold text-[#5C656C] dark:text-[#94A3B8] w-6 shrink-0">03</span>
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-[#181C1E] dark:text-white group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400 transition-colors">
                                        High-Frequency Quranic Words
                                    </h3>
                                    <span class="font-arabic text-xl text-[#1B4D3E] dark:text-emerald-400 select-none">الله • رَبّ • كِتَاب</span>
                                </div>
                                <p class="text-sm text-[#5C656C] dark:text-[#94A3B8] max-w-2xl">
                                    Learn the words that appear hundreds of times across the Quran. Master roots, frequencies, and English & Bangla definitions.
                                </p>
                            </div>
                        </div>
                        <div class="text-xs font-medium text-[#1B4D3E] dark:text-emerald-400 shrink-0 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            <span>Search vocabulary</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                </a>

                <!-- Stage 4: The Holy Quran Studio (114 Surahs) -->
                <a href="{{ route('quran.index') }}" class="group py-6 block hover:bg-[#FAF8F5]/60 dark:hover:bg-[#111723]/60 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-baseline gap-4 sm:gap-6">
                            <span class="font-mono text-sm font-semibold text-[#5C656C] dark:text-[#94A3B8] w-6 shrink-0">04</span>
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-[#181C1E] dark:text-white group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400 transition-colors">
                                        {{ app()->getLocale() === 'bn' ? 'পবিত্র কুরআন স্টুডিও (১১৪টি সূরা)' : 'The Holy Quran Studio (114 Surahs)' }}
                                    </h3>
                                    <span class="font-arabic text-xl text-[#1B4D3E] dark:text-emerald-400 select-none">القرآن الكريم</span>
                                </div>
                                <p class="text-sm text-[#5C656C] dark:text-[#94A3B8] max-w-2xl">
                                    {{ app()->getLocale() === 'bn' 
                                        ? '১১৪টি সূরা বিশুদ্ধ অডিও তেলাওয়াতসহ শুনুন এবং শব্দে শব্দে ইংরেজি ও বাংলা অর্থ শিখুন।' 
                                        : 'Listen to crystal-clear recitations across all 114 Surahs with word-by-word tapping, English & Bengali translations.' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-xs font-medium text-[#1B4D3E] dark:text-emerald-400 shrink-0 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            <span>{{ app()->getLocale() === 'bn' ? 'স্টুডিও খুলুন' : 'Open Quran Studio' }}</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                </a>

                <!-- Stage 5: Spaced Repetition Practice -->
                <a href="{{ route('review.index') }}" class="group py-6 block hover:bg-[#FAF8F5]/60 dark:hover:bg-[#111723]/60 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-baseline gap-4 sm:gap-6">
                            <span class="font-mono text-sm font-semibold text-[#5C656C] dark:text-[#94A3B8] w-6 shrink-0">05</span>
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-[#181C1E] dark:text-white group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400 transition-colors">
                                        Daily Spaced Repetition (SRS)
                                    </h3>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded-full bg-[#1B4D3E]/10 dark:bg-emerald-400/10 text-[#1B4D3E] dark:text-emerald-400">
                                        SM-2 Engine
                                    </span>
                                </div>
                                <p class="text-sm text-[#5C656C] dark:text-[#94A3B8] max-w-2xl">
                                    Solidify vocabulary, letters, and phonetics in long-term memory through adaptive spaced intervals.
                                </p>
                            </div>
                        </div>
                        <div class="text-xs font-medium text-[#1B4D3E] dark:text-emerald-400 shrink-0 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            <span>Begin review</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
