<x-layouts.app>
    <x-slot:title>{{ $word->arabic }} ({{ $word->transliteration }}) — Quranic Vocabulary</x-slot:title>

    <div class="space-y-8 max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-[#687076] dark:text-[#94A3B8]">
            <a href="{{ route('vocabulary.index') }}" class="hover:text-[#1A1D20] dark:hover:text-white transition-colors">&larr; {{ __('Vocabulary') }}</a>
            <span>/</span>
            <span class="text-[#1A1D20] dark:text-white font-medium">{{ $word->transliteration }}</span>
        </div>

        <!-- Word Hero Card -->
        <div x-data="{ 
            isPlaying: false,
            speed: 0.85,
            playAudio() {
                this.isPlaying = true;
                const audioUrl = '{{ $word->audio_url ?? '' }}';
                const arabic = '{{ $word->arabic }}';
                const translit = '{{ $word->transliteration }}';
                if (audioUrl) {
                    window.playAudio(audioUrl, arabic);
                } else {
                    window.speakArabic(arabic, translit);
                }
                setTimeout(() => {
                    this.isPlaying = false;
                }, 1800);
            }
        }" class="rounded-3xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-6 sm:p-10 shadow-xs flex flex-col items-center text-center relative overflow-hidden">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-semibold bg-[#1B4D3E]/10 text-[#1B4D3E] dark:bg-emerald-400/10 dark:text-emerald-400 border border-[#1B4D3E]/20 dark:border-emerald-400/20 mb-2">
                <span>Occurs {{ number_format($word->frequency) }} times in the Quran</span>
            </span>

            <!-- Massive Clickable Arabic Script -->
            <div @click="playAudio()" class="my-2 sm:my-3 font-arabic text-6xl sm:text-8xl text-[#1A1D20] dark:text-white leading-relaxed cursor-pointer hover:scale-105 active:scale-95 transition-all select-none group/hero" title="{{ __('Click to hear pronunciation') }}">
                <span :class="isPlaying ? 'text-[#1B4D3E] dark:text-emerald-400 drop-shadow-sm' : ''">{{ $word->arabic }}</span>
            </div>

            <!-- Tactile Audio Play Bar -->
            <div class="my-3 flex items-center justify-center gap-3">
                <button @click="playAudio()" 
                        type="button" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-[#1B4D3E] dark:bg-emerald-600 hover:bg-[#143B2F] dark:hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm shadow-sm hover:shadow-md transition-all cursor-pointer active:scale-95"
                        :class="isPlaying ? 'ring-4 ring-emerald-300/50 scale-102' : ''">
                    <span x-show="!isPlaying" class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.757 3.63 8.25 4.51 8.25H6.75Z" />
                        </svg>
                        <span>{{ app()->getLocale() === 'bn' ? 'উচ্চারণ শুনুন' : 'Listen Pronunciation' }}</span>
                    </span>
                    <span x-show="isPlaying" class="flex items-center gap-1.5" style="display: none;">
                        <span class="flex items-center gap-0.5 mr-1">
                            <span class="w-1 h-3 bg-white rounded-full animate-pulse"></span>
                            <span class="w-1 h-4 bg-white rounded-full animate-pulse delay-75"></span>
                            <span class="w-1 h-2.5 bg-white rounded-full animate-pulse delay-150"></span>
                        </span>
                        <span>{{ app()->getLocale() === 'bn' ? 'বাজছে...' : 'Playing...' }}</span>
                    </span>
                </button>
            </div>

            <h1 class="text-xl sm:text-2xl font-bold text-[#1A1D20] dark:text-white tracking-tight mt-1">
                {{ $word->meaning_en }}
            </h1>

            @if ($word->meaning_bn)
                <p class="text-xs sm:text-sm font-semibold text-[#1B4D3E] dark:text-emerald-400 mt-1">
                    {{ $word->meaning_bn }}
                </p>
            @endif

            <div class="text-xs font-mono text-[#687076] dark:text-[#94A3B8] mt-3 flex flex-wrap items-center justify-center gap-2">
                <span>Transliteration: <span class="font-bold text-[#1A1D20] dark:text-white">{{ $word->transliteration }}</span></span>
                <span>•</span>
                <span>Part of speech: <span class="capitalize text-[#1A1D20] dark:text-white">{{ $word->part_of_speech }}</span></span>
            </div>
        </div>

        <!-- Root Connection -->
        @if ($word->root)
            <div class="rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#9A722C] dark:text-amber-400">Word Root (الجذر)</span>
                        <h2 class="text-lg font-semibold text-[#1A1D20] dark:text-white mt-1">Root Family</h2>
                    </div>
                    <div class="font-arabic text-3xl text-[#1A1D20] dark:text-white">
                        {{ $word->root->root_ar }}
                    </div>
                </div>

                <p class="text-sm text-[#687076] dark:text-[#94A3B8]">
                    Base semantic root: <span class="font-medium text-[#1A1D20] dark:text-white">{{ $word->root->meaning }}</span> ({{ $word->root->root_latin }}).
                </p>

                @if ($word->root->vocabularies->count() > 1)
                    <div class="pt-2 border-t border-[#EBE6DE]/60 dark:border-[#212B3E]/60">
                        <div class="text-xs text-[#687076] dark:text-[#94A3B8] mb-2 font-medium">Other Quranic words from this root:</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($word->root->vocabularies as $otherWord)
                                @if ($otherWord->id !== $word->id)
                                    <a href="{{ route('vocabulary.show', $otherWord->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] hover:border-[#1B4D3E] dark:hover:border-emerald-400 text-xs text-[#1A1D20] dark:text-white transition-colors">
                                        <span class="font-arabic text-base">{{ $otherWord->arabic }}</span>
                                        <span class="text-[11px] text-[#687076] dark:text-[#94A3B8]">({{ $otherWord->meaning_en }})</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Quran Occurrences -->
        @if ($word->occurrences->isNotEmpty())
            <div class="rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-6 space-y-4">
                <h2 class="text-base font-semibold text-[#1A1D20] dark:text-white">Key Occurrences in the Quran</h2>
                <div class="space-y-3">
                    @foreach ($word->occurrences as $occ)
                        <div class="p-4 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-semibold text-[#1B4D3E] dark:text-emerald-400">
                                    {{ $occ->surah->name_latin }} ({{ $occ->surah->number }}:{{ $occ->verse->verse_number }})
                                </span>
                                <span class="font-arabic text-sm text-[#687076] dark:text-[#94A3B8]">{{ $occ->surah->name_ar }}</span>
                            </div>
                            <div class="font-arabic text-2xl text-[#1A1D20] dark:text-white text-right leading-relaxed">
                                {{ $occ->verse->text_ar }}
                            </div>
                            <div class="text-xs text-[#687076] dark:text-[#94A3B8] leading-relaxed">
                                {{ $occ->verse->translation }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
