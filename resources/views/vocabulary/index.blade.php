<x-layouts.app>
    <x-slot:title>High-Frequency Quranic Vocabulary — Quranic Arabic</x-slot:title>

    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-[#EBE6DE] dark:border-[#212B3E] pb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-[#1A1D20] dark:text-white">
                    Quranic Vocabulary
                </h1>
                <p class="text-sm text-[#687076] dark:text-[#94A3B8] mt-1">
                    Words that appear dozens or hundreds of times across the Quranic text.
                </p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('vocabulary.index') }}" method="GET" class="flex items-center gap-2 w-full md:max-w-md">
                <div class="relative w-full">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Search Arabic, English, or root..." class="w-full px-4 py-2 rounded-xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] text-xs focus:outline-none focus:border-[#1B4D3E] dark:focus:border-emerald-400 transition-colors text-[#1A1D20] dark:text-white placeholder-[#687076]">
                </div>
                <button type="submit" class="px-4 py-2 rounded-xl bg-[#1B4D3E] dark:bg-emerald-600 text-white text-xs font-semibold hover:opacity-90 transition-opacity shrink-0 cursor-pointer">
                    Search
                </button>
            </form>
        </div>

        <!-- Vocabulary Cards Grid -->
        <div x-data="{ 
            playingId: null,
            playWord(id, audioUrl, arabic, translit) {
                this.playingId = id;
                const finalUrl = audioUrl || `/audio/vocabulary/${id}.mp3`;
                window.playAudio(finalUrl, arabic);
                setTimeout(() => {
                    if (this.playingId === id) this.playingId = null;
                }, 1600);
            }
        }" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
            @forelse ($vocabularies as $word)
                <div class="group rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-4 sm:p-5 flex flex-col justify-between hover:border-[#1B4D3E]/40 dark:hover:border-emerald-500/40 hover:shadow-xs transition-all duration-150">
                    <!-- Top Bar: Part of Speech, Audio Speaker & Frequency -->
                    <div class="flex items-center justify-between gap-2 min-w-0">
                        <span class="truncate px-2 py-0.5 rounded-md bg-[#FAF8F5] dark:bg-[#0B0F19] text-[#687076] dark:text-[#94A3B8] border border-[#EBE6DE] dark:border-[#212B3E] font-medium text-[10px] capitalize" title="{{ $word->part_of_speech }}">
                            {{ $word->part_of_speech == 'relative pronoun / particle' ? 'Rel. Pronoun / Particle' : ($word->part_of_speech ?? 'word') }}
                        </span>

                        <div class="flex items-center gap-1.5 shrink-0">
                            <!-- Audio Play Button -->
                            <button @click.stop="playWord({{ $word->id }}, '{{ $word->audio_url ?? '' }}', '{{ $word->arabic }}', '{{ $word->transliteration }}')"
                                    type="button"
                                    class="w-7 h-7 rounded-lg flex items-center justify-center border transition-all cursor-pointer shadow-2xs active:scale-90"
                                    :class="playingId === {{ $word->id }} ? 'bg-[#1B4D3E] text-white border-[#1B4D3E] scale-105 ring-2 ring-emerald-400/40' : 'bg-[#FAF8F5] dark:bg-[#0B0F19] text-[#1B4D3E] dark:text-emerald-400 border-[#EBE6DE] dark:border-[#212B3E] hover:bg-[#1B4D3E] hover:text-white dark:hover:bg-emerald-500 dark:hover:text-white'"
                                    title="{{ __('Listen pronunciation') }}">
                                <span x-show="playingId === {{ $word->id }}" class="flex items-center gap-0.5" style="display: none;">
                                    <span class="w-0.5 h-2.5 bg-white rounded-full animate-pulse"></span>
                                    <span class="w-0.5 h-3.5 bg-white rounded-full animate-pulse delay-75"></span>
                                    <span class="w-0.5 h-2 bg-white rounded-full animate-pulse delay-150"></span>
                                </span>
                                <svg x-show="playingId !== {{ $word->id }}" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.757 3.63 8.25 4.51 8.25H6.75Z" />
                                </svg>
                            </button>

                            <!-- Frequency Badge -->
                            <span class="font-mono text-[10px] text-[#1B4D3E] dark:text-emerald-400 font-semibold bg-[#1B4D3E]/10 dark:bg-emerald-400/10 px-2 py-0.5 rounded-full whitespace-nowrap" title="{{ number_format($word->frequency) }} times in Quran">
                                {{ number_format($word->frequency) }}x
                            </span>
                        </div>
                    </div>

                    <!-- Arabic Word & Pronunciation (Clickable to play) -->
                    <div class="my-4 text-center cursor-pointer group/word" @click="playWord({{ $word->id }}, '{{ $word->audio_url ?? '' }}', '{{ $word->arabic }}', '{{ $word->transliteration }}')" title="{{ __('Click to listen') }}">
                        <div class="font-arabic text-4xl text-[#1A1D20] dark:text-white leading-relaxed group-hover/word:text-[#1B4D3E] dark:group-hover/word:text-emerald-400 group-hover:scale-105 transition-all">
                            {{ $word->arabic }}
                        </div>
                        <div class="text-xs font-mono text-[#687076] dark:text-[#94A3B8] mt-1 flex items-center justify-center gap-1">
                            <span>{{ $word->transliteration }}</span>
                            <span class="text-[10px] text-[#1B4D3E] dark:text-emerald-400 opacity-0 group-hover/word:opacity-100 transition-opacity">🔊</span>
                        </div>
                    </div>

                    <!-- English & Bangla Meanings -->
                    <div class="space-y-1 text-center border-t border-[#EBE6DE]/60 dark:border-[#212B3E]/60 pt-3">
                        @if (app()->getLocale() === 'bn' && $word->meaning_bn)
                            <div class="text-xs font-semibold text-[#1A1D20] dark:text-white line-clamp-1">
                                {{ $word->meaning_bn }}
                            </div>
                            <div class="text-[11px] text-[#687076] dark:text-[#94A3B8] line-clamp-1">
                                {{ $word->meaning_en }}
                            </div>
                        @else
                            <div class="text-xs font-semibold text-[#1A1D20] dark:text-white line-clamp-1">
                                {{ $word->meaning_en }}
                            </div>
                            @if ($word->meaning_bn)
                                <div class="text-[11px] text-[#687076] dark:text-[#94A3B8] line-clamp-1">
                                    {{ $word->meaning_bn }}
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Footer: Root & Detail Link -->
                    <div class="mt-4 pt-2 flex items-center justify-between text-[11px] border-t border-[#EBE6DE]/40 dark:border-[#212B3E]/40">
                        @if ($word->root)
                            <span class="font-arabic text-sm text-[#9A722C] dark:text-amber-400" title="Root: {{ $word->root->root_ar }}">
                                {{ $word->root->root_ar }}
                            </span>
                        @else
                            <span></span>
                        @endif

                        <a href="{{ route('vocabulary.show', $word->id) }}" class="text-[#1B4D3E] dark:text-emerald-400 font-medium hover:underline">
                            View details &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-[#687076] dark:text-[#94A3B8] text-sm">
                    No vocabulary found matching your query.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pt-4 overflow-x-auto max-w-full">
            {{ $vocabularies->links() }}
        </div>
    </div>
</x-layouts.app>
