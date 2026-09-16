<x-layouts.app>
    <x-slot:title>Letter {{ $letter->name_latin }} ({{ $letter->character }}) — Quranic Arabic</x-slot:title>

    <div class="space-y-8 max-w-4xl mx-auto">
        <!-- Breadcrumb & Nav -->
        <div class="flex items-center justify-between text-xs text-[#687076] dark:text-[#94A3B8]">
            <div class="flex items-center gap-2">
                <a href="{{ route('alphabet.index') }}" class="hover:text-[#1A1D20] dark:hover:text-white transition-colors">&larr; Back to Alphabet</a>
                <span>/</span>
                <span class="text-[#1A1D20] dark:text-white font-medium">Letter {{ $letter->name_latin }} (#{{ $letter->order }})</span>
            </div>

            <div class="flex items-center gap-2">
                @if ($prevLetter)
                    <a href="{{ route('alphabet.show', $prevLetter->order) }}" class="px-2.5 py-1 rounded-lg border border-[#EBE6DE] dark:border-[#212B3E] hover:bg-white dark:hover:bg-[#131926] transition-colors">
                        &larr; {{ $prevLetter->name_latin }}
                    </a>
                @endif
                @if ($nextLetter)
                    <a href="{{ route('alphabet.show', $nextLetter->order) }}" class="px-2.5 py-1 rounded-lg border border-[#EBE6DE] dark:border-[#212B3E] hover:bg-white dark:hover:bg-[#131926] transition-colors">
                        {{ $nextLetter->name_latin }} &rarr;
                    </a>
                @endif
            </div>
        </div>

        <!-- Main Letter Card -->
        <div class="rounded-3xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-8 sm:p-10 shadow-xs flex flex-col items-center text-center relative overflow-hidden">
            <!-- Order Badge -->
            <span class="absolute top-6 left-6 text-xs font-mono font-medium px-2.5 py-1 rounded-full bg-[#FAF8F5] dark:bg-[#0B0F19] text-[#687076] dark:text-[#94A3B8] border border-[#EBE6DE] dark:border-[#212B3E]">
                Letter {{ $letter->order }} of 28
            </span>

            <!-- Huge Arabic Glyph (Clicking plays audio) -->
            <button @click="playAudio('{{ $letter->audio_url }}', '{{ $letter->name_ar }}')" type="button" class="my-4 font-arabic text-8xl sm:text-9xl text-[#1A1D20] dark:text-white leading-tight selection:bg-transparent hover:scale-105 active:scale-95 transition-transform cursor-pointer focus:outline-hidden" title="{{ __('Click to listen') }}: {{ $letter->name_ar }}">
                {{ $letter->character }}
            </button>

            <h1 class="text-2xl font-bold text-[#1A1D20] dark:text-white tracking-tight flex items-center gap-3">
                <span>{{ app()->getLocale() === 'bn' && $letter->name_bn ? $letter->name_bn : $letter->name_latin }}</span>
                <span class="font-arabic text-2xl text-[#1B4D3E] dark:text-emerald-400 font-normal">({{ $letter->name_ar }})</span>
            </h1>

            <p class="text-sm font-medium text-[#687076] dark:text-[#94A3B8] mt-1">
                {{ app()->getLocale() === 'bn' ? 'উচ্চারণ (লিপ্যন্তর):' : 'Phonetic Transliteration:' }}
                <span class="text-[#1A1D20] dark:text-white font-mono font-bold">
                    {{ app()->getLocale() === 'bn' && $letter->transliteration_bn ? $letter->transliteration_bn : $letter->transliteration }}
                </span>
            </p>

            <!-- Audio Trigger -->
            <button @click="playAudio('{{ $letter->audio_url }}', '{{ $letter->name_ar }}')" type="button" class="mt-5 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#1B4D3E] dark:bg-emerald-600 text-white text-xs font-semibold hover:bg-[#153e32] dark:hover:bg-emerald-500 shadow-xs hover:scale-105 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
                </svg>
                <span>{{ __('Listen') }}</span>
            </button>
        </div>

        <!-- Makhraj & Linguistic Notes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-6 space-y-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#1B4D3E] dark:text-emerald-400">
                    {{ app()->getLocale() === 'bn' ? 'মাখরাজ (বিশুদ্ধ উচ্চারণস্থল)' : 'Articulation Point (Makhraj)' }}
                </h3>
                <p class="text-sm text-[#1A1D20] dark:text-white font-medium leading-relaxed">
                    {{ app()->getLocale() === 'bn' && $letter->makhraj_bn ? $letter->makhraj_bn : $letter->makhraj }}
                </p>
            </div>

            <div class="rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-6 space-y-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#9A722C] dark:text-amber-400">
                    {{ app()->getLocale() === 'bn' ? 'ধ্বনি বৈশিষ্ট্য ও নিয়ম' : 'Phonetic Characteristics' }}
                </h3>
                <p class="text-sm text-[#687076] dark:text-[#94A3B8] leading-relaxed">
                    {{ app()->getLocale() === 'bn' && $letter->description_bn ? $letter->description_bn : $letter->description }}
                </p>
            </div>
        </div>

        <!-- The 4 Contextual Positional Forms -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-[#1A1D20] dark:text-white">Positional Shapes & Examples</h2>
                <span class="text-xs text-[#687076] dark:text-[#94A3B8]">Changes based on connection in words</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($letter->forms as $f)
                    <div class="rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-5 flex flex-col justify-between space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold capitalize text-[#687076] dark:text-[#94A3B8]">{{ $f->position }}</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-md bg-[#FAF8F5] dark:bg-[#0B0F19] text-[#687076] dark:text-[#94A3B8] border border-[#EBE6DE] dark:border-[#212B3E]">Form</span>
                        </div>

                        <!-- Form Glyph -->
                        <div class="py-2 font-arabic text-5xl text-center text-[#1B4D3E] dark:text-emerald-400">
                            {{ $f->form }}
                        </div>

                        <!-- Quranic Example -->
                        <div class="pt-3 border-t border-[#EBE6DE]/60 dark:border-[#212B3E]/60 space-y-1">
                            <div class="font-arabic text-xl text-[#1A1D20] dark:text-white text-right">
                                {{ $f->example }}
                            </div>
                            <div class="text-xs font-medium text-[#1A1D20] dark:text-white">
                                {{ $f->example_transliteration }}
                            </div>
                            <div class="text-[11px] text-[#687076] dark:text-[#94A3B8]">
                                {{ $f->example_meaning }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
