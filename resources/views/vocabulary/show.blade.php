<x-layouts.app>
    <x-slot:title>{{ $word->arabic }} ({{ $word->transliteration }}) — Quranic Vocabulary</x-slot:title>

    <div class="space-y-8 max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-[#687076] dark:text-[#94A3B8]">
            <a href="{{ route('vocabulary.index') }}" class="hover:text-[#1A1D20] dark:hover:text-white transition-colors">&larr; Back to Vocabulary</a>
            <span>/</span>
            <span class="text-[#1A1D20] dark:text-white font-medium">{{ $word->transliteration }}</span>
        </div>

        <!-- Word Hero Card -->
        <div class="rounded-3xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-8 sm:p-10 shadow-xs flex flex-col items-center text-center relative overflow-hidden">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-semibold bg-[#1B4D3E]/10 text-[#1B4D3E] dark:bg-emerald-400/10 dark:text-emerald-400 border border-[#1B4D3E]/20 dark:border-emerald-400/20 mb-2">
                <span>Occurs {{ number_format($word->frequency) }} times in the Quran</span>
            </span>

            <div class="my-4 font-arabic text-7xl sm:text-8xl text-[#1A1D20] dark:text-white leading-relaxed">
                {{ $word->arabic }}
            </div>

            <h1 class="text-2xl font-bold text-[#1A1D20] dark:text-white tracking-tight">
                {{ $word->meaning_en }}
            </h1>

            @if ($word->meaning_bn)
                <p class="text-sm text-[#687076] dark:text-[#94A3B8] mt-1">
                    {{ $word->meaning_bn }}
                </p>
            @endif

            <p class="text-xs font-mono text-[#687076] dark:text-[#94A3B8] mt-2">
                Transliteration: <span class="font-bold text-[#1A1D20] dark:text-white">{{ $word->transliteration }}</span> • Part of speech: <span class="capitalize text-[#1A1D20] dark:text-white">{{ $word->part_of_speech }}</span>
            </p>
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
