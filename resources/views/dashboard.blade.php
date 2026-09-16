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

                <!-- Stage 4: Surah Al-Fatihah -->
                <a href="{{ route('quran.fatihah') }}" class="group py-6 block hover:bg-[#FAF8F5]/60 dark:hover:bg-[#111723]/60 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-baseline gap-4 sm:gap-6">
                            <span class="font-mono text-sm font-semibold text-[#5C656C] dark:text-[#94A3B8] w-6 shrink-0">04</span>
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-[#181C1E] dark:text-white group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400 transition-colors">
                                        Surah Al-Fatihah: Word-by-Word Analysis
                                    </h3>
                                    <span class="font-arabic text-xl text-[#1B4D3E] dark:text-emerald-400 select-none">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</span>
                                </div>
                                <p class="text-sm text-[#5C656C] dark:text-[#94A3B8] max-w-2xl">
                                    Deconstruct every word of the Opening Surah with interactive recitation audio, root mapping, and morphological breakdown.
                                </p>
                            </div>
                        </div>
                        <div class="text-xs font-medium text-[#1B4D3E] dark:text-emerald-400 shrink-0 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            <span>Open reader</span>
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
