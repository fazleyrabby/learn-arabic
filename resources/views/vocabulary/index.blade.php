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
            <form action="{{ route('vocabulary.index') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
                <div class="relative w-full">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Search Arabic, English, or root..." class="w-full px-4 py-2 rounded-xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] text-xs focus:outline-none focus:border-[#1B4D3E] dark:focus:border-emerald-400 transition-colors text-[#1A1D20] dark:text-white placeholder-[#687076]">
                </div>
                <button type="submit" class="px-4 py-2 rounded-xl bg-[#1B4D3E] dark:bg-emerald-600 text-white text-xs font-semibold hover:opacity-90 transition-opacity shrink-0">
                    Search
                </button>
            </form>
        </div>

        <!-- Vocabulary Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($vocabularies as $word)
                <div class="group rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-5 flex flex-col justify-between hover:border-[#1B4D3E]/40 dark:hover:border-emerald-500/40 hover:shadow-xs transition-all duration-150">
                    <!-- Top Bar: Part of Speech & Frequency -->
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="px-2 py-0.5 rounded-md bg-[#FAF8F5] dark:bg-[#0B0F19] text-[#687076] dark:text-[#94A3B8] border border-[#EBE6DE] dark:border-[#212B3E] font-medium capitalize">
                            {{ $word->part_of_speech ?? 'word' }}
                        </span>

                        <span class="font-mono text-[10px] text-[#1B4D3E] dark:text-emerald-400 font-semibold bg-[#1B4D3E]/10 dark:bg-emerald-400/10 px-2 py-0.5 rounded-full">
                            {{ number_format($word->frequency) }}x in Quran
                        </span>
                    </div>

                    <!-- Arabic Word & Pronunciation -->
                    <div class="my-4 text-center">
                        <div class="font-arabic text-4xl text-[#1A1D20] dark:text-white leading-relaxed group-hover:scale-105 transition-transform">
                            {{ $word->arabic }}
                        </div>
                        <div class="text-xs font-mono text-[#687076] dark:text-[#94A3B8] mt-1">
                            {{ $word->transliteration }}
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
                            <span class="font-arabic text-sm text-[#9A722C] dark:text-amber-400">
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
        <div class="pt-4">
            {{ $vocabularies->links() }}
        </div>
    </div>
</x-layouts.app>
