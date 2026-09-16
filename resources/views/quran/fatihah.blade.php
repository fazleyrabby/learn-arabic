<x-layouts.app>
    <x-slot:title>Surah Al-Fatihah — Word by Word Study</x-slot:title>

    <div x-data="{
        selectedWord: null,
        drawerOpen: false,
        activeAyahAudio: null,
        selectWord(word) {
            this.selectedWord = word;
            this.drawerOpen = true;
            if (word.audio_url) {
                playAudio(word.audio_url);
            }
        },
        playAyah(url) {
            if (!url) return;
            if (this.activeAyahAudio) {
                this.activeAyahAudio.pause();
                this.activeAyahAudio.currentTime = 0;
            }
            this.activeAyahAudio = new Audio(url);
            this.activeAyahAudio.play().catch(e => console.log(e));
        }
    }" class="space-y-10 relative">

        <!-- Surah Header Card -->
        <div class="rounded-3xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-5 sm:p-8 text-center relative overflow-hidden shadow-xs">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-[#1B4D3E]/10 text-[#1B4D3E] dark:bg-emerald-400/10 dark:text-emerald-400 border border-[#1B4D3E]/20 dark:border-emerald-400/20 mb-3">
                <span>Surah #{{ $surah->number }}</span>
                <span>•</span>
                <span>{{ $surah->revelation_type }}</span>
                <span>•</span>
                <span>{{ $surah->verse_count }} Verses</span>
            </div>

            <div class="font-arabic text-4xl sm:text-6xl text-[#1A1D20] dark:text-white leading-relaxed my-2">
                {{ $surah->name_ar }}
            </div>

            <h1 class="text-lg sm:text-xl font-bold text-[#1A1D20] dark:text-white tracking-tight">
                {{ $surah->name_latin }} <span class="text-sm font-normal text-[#687076] dark:text-[#94A3B8]">({{ $surah->name_english }})</span>
            </h1>

            <p class="text-xs text-[#687076] dark:text-[#94A3B8] max-w-lg mx-auto mt-2">
                Click any word below to hear authentic pronunciation and open its morphological and grammatical analysis.
            </p>
        </div>

        <!-- Verses & Word-by-Word Grid -->
        <div class="space-y-6">
            @foreach ($surah->verses as $verse)
                <div class="rounded-3xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-4 sm:p-8 space-y-4 sm:space-y-6 shadow-xs">
                    <!-- Verse Meta & Audio Trigger -->
                    <div class="flex items-center justify-between border-b border-[#EBE6DE]/60 dark:border-[#212B3E]/60 pb-3 sm:pb-4">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <span class="w-8 h-8 rounded-full bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] text-xs font-mono font-bold flex items-center justify-center text-[#1B4D3E] dark:text-emerald-400">
                                1:{{ $verse->verse_number }}
                            </span>
                            <span class="text-xs text-[#687076] dark:text-[#94A3B8] hidden sm:inline">
                                {{ $verse->transliteration }}
                            </span>
                        </div>

                        <!-- Reciter Audio Button -->
                        <button @click="playAyah('{{ $verse->audio_url }}')" type="button" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 py-1.5 rounded-xl border border-[#EBE6DE] dark:border-[#212B3E] hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] text-xs font-medium text-[#1A1D20] dark:text-white transition-colors cursor-pointer">
                            <svg class="w-3.5 h-3.5 text-[#1B4D3E] dark:text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            <span>Listen to Ayah</span>
                        </button>
                    </div>

                    <!-- Word Tiles in RTL Flow -->
                    <div class="flex flex-wrap flex-row-reverse gap-1.5 sm:gap-3 items-center justify-start py-2">
                        @foreach ($verse->words as $word)
                            <button @click="selectWord({{ json_encode([
                                'id' => $word->id,
                                'text_ar' => $word->text_ar,
                                'transliteration' => $word->transliteration,
                                'translation' => $word->translation,
                                'translation_bn' => $word->translation_bn,
                                'audio_url' => $word->audio_url,
                                'root' => $word->root ? [
                                    'root_ar' => $word->root->root_ar,
                                    'root_latin' => $word->root->root_latin,
                                    'meaning' => $word->root->meaning,
                                ] : null,
                                'morphology' => $word->morphology ? [
                                    'part_of_speech' => $word->morphology->part_of_speech,
                                    'pattern' => $word->morphology->pattern,
                                    'case' => $word->morphology->case,
                                    'tense' => $word->morphology->tense,
                                    'person' => $word->morphology->person,
                                    'number' => $word->morphology->number,
                                ] : null,
                                'verse_num' => '1:' . $verse->verse_number
                            ]) }})" 
                            type="button" 
                            class="group relative rounded-2xl p-2.5 sm:p-4 bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] hover:border-[#1B4D3E] dark:hover:border-emerald-400 hover:shadow-xs transition-all duration-150 flex flex-col items-center min-w-[58px] sm:min-w-[90px] text-center cursor-pointer">
                                
                                <span class="font-arabic text-2xl sm:text-3xl text-[#1A1D20] dark:text-white leading-relaxed group-hover:scale-105 transition-transform">
                                    {{ $word->text_ar }}
                                </span>

                                <span class="text-[10px] sm:text-xs text-[#687076] dark:text-[#94A3B8] font-medium mt-1">
                                    {{ app()->getLocale() === 'bn' && $word->translation_bn ? $word->translation_bn : $word->translation }}
                                </span>

                                <span class="text-[9px] text-[#687076]/70 dark:text-[#94A3B8]/70 font-mono">
                                    {{ $word->transliteration }}
                                </span>
                            </button>
                        @endforeach

                        <!-- Verse End Symbol -->
                        <div class="font-arabic text-xl sm:text-2xl text-[#1B4D3E] dark:text-emerald-400 px-2 select-none self-center">
                            ۝{{ $verse->verse_number }}
                        </div>
                    </div>

                    <!-- Translations -->
                    <div class="pt-2 space-y-1 text-sm text-[#687076] dark:text-[#94A3B8]">
                        @if (app()->getLocale() === 'bn' && $verse->translation_bn)
                            <p class="text-[#1A1D20] dark:text-white leading-relaxed font-medium">{{ $verse->translation_bn }}</p>
                            <p class="text-xs text-[#687076] dark:text-[#94A3B8]">{{ $verse->translation }}</p>
                        @else
                            <p class="text-[#1A1D20] dark:text-white leading-relaxed">{{ $verse->translation }}</p>
                            @if ($verse->translation_bn)
                                <p class="text-xs text-[#687076] dark:text-[#94A3B8]">{{ $verse->translation_bn }}</p>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Slide-out Morphology & Root Inspection Drawer -->
        <div x-show="drawerOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full"
             class="fixed inset-y-0 right-0 max-w-full sm:max-w-md w-full z-50 bg-white dark:bg-[#131926] border-l border-[#EBE6DE] dark:border-[#212B3E] shadow-2xl p-5 sm:p-8 pb-[calc(1.5rem+env(safe-area-inset-bottom,0px))] sm:pb-8 overflow-y-auto flex flex-col justify-between"
             style="display: none;">
            
            <div class="space-y-6">
                <!-- Drawer Header -->
                <div class="flex items-center justify-between border-b border-[#EBE6DE] dark:border-[#212B3E] pb-4">
                    <span class="text-xs font-mono text-[#687076] dark:text-[#94A3B8]">Word Analysis (Ayah <span x-text="selectedWord?.verse_num"></span>)</span>
                    <button @click="drawerOpen = false" class="p-1 rounded-lg text-[#687076] dark:text-[#94A3B8] hover:text-[#1A1D20] dark:hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Word Presentation -->
                <div class="text-center py-4 bg-[#FAF8F5] dark:bg-[#0B0F19] rounded-2xl border border-[#EBE6DE] dark:border-[#212B3E]">
                    <div class="font-arabic text-5xl text-[#1A1D20] dark:text-white leading-relaxed" x-text="selectedWord?.text_ar"></div>
                    <div class="text-sm font-semibold text-[#1A1D20] dark:text-white mt-2" x-text="selectedWord?.translation"></div>
                    <div class="text-xs text-[#687076] dark:text-[#94A3B8]" x-text="selectedWord?.translation_bn"></div>
                    <div class="text-xs font-mono text-[#687076] dark:text-[#94A3B8] mt-1" x-text="selectedWord?.transliteration"></div>

                    <!-- Audio Trigger -->
                    <button @click="playAudio(selectedWord?.audio_url)" class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-[#1B4D3E] dark:bg-emerald-600 text-white text-xs font-semibold hover:opacity-90 transition-opacity">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
                        </svg>
                        <span>Replay Audio</span>
                    </button>
                </div>

                <!-- Root Family Card -->
                <div x-show="selectedWord?.root" class="rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-5 space-y-2">
                    <div class="text-xs font-bold uppercase tracking-wider text-[#9A722C] dark:text-amber-400">Arabic Root (الجذر)</div>
                    <div class="flex items-center justify-between">
                        <div class="font-arabic text-3xl text-[#1A1D20] dark:text-white" x-text="selectedWord?.root?.root_ar"></div>
                        <div class="text-xs font-mono text-[#687076] dark:text-[#94A3B8]" x-text="selectedWord?.root?.root_latin"></div>
                    </div>
                    <p class="text-xs text-[#687076] dark:text-[#94A3B8] leading-relaxed pt-1" x-text="selectedWord?.root?.meaning"></p>
                </div>

                <!-- Morphological Analysis -->
                <div x-show="selectedWord?.morphology" class="rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-5 space-y-3">
                    <div class="text-xs font-bold uppercase tracking-wider text-[#1B4D3E] dark:text-emerald-400">Linguistic Properties</div>
                    
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="p-2.5 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E]">
                            <div class="text-[10px] text-[#687076] dark:text-[#94A3B8]">Part of Speech</div>
                            <div class="font-medium capitalize text-[#1A1D20] dark:text-white mt-0.5" x-text="selectedWord?.morphology?.part_of_speech"></div>
                        </div>

                        <template x-if="selectedWord?.morphology?.case">
                            <div class="p-2.5 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E]">
                                <div class="text-[10px] text-[#687076] dark:text-[#94A3B8]">Grammatical Case</div>
                                <div class="font-medium capitalize text-[#1A1D20] dark:text-white mt-0.5" x-text="selectedWord?.morphology?.case"></div>
                            </div>
                        </template>

                        <template x-if="selectedWord?.morphology?.pattern">
                            <div class="p-2.5 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E]">
                                <div class="text-[10px] text-[#687076] dark:text-[#94A3B8]">Morphological Form</div>
                                <div class="font-medium text-[#1A1D20] dark:text-white mt-0.5" x-text="selectedWord?.morphology?.pattern"></div>
                            </div>
                        </template>

                        <template x-if="selectedWord?.morphology?.tense">
                            <div class="p-2.5 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E]">
                                <div class="text-[10px] text-[#687076] dark:text-[#94A3B8]">Tense / Aspect</div>
                                <div class="font-medium capitalize text-[#1A1D20] dark:text-white mt-0.5" x-text="selectedWord?.morphology?.tense"></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-[#EBE6DE] dark:border-[#212B3E]">
                <button @click="drawerOpen = false" class="w-full py-2.5 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] text-xs font-semibold text-[#1A1D20] dark:text-white hover:bg-[#EAE5DB]/50 transition-colors">
                    Close Analysis
                </button>
            </div>
        </div>

        <!-- Backdrop -->
        <div x-show="drawerOpen" @click="drawerOpen = false" class="fixed inset-0 bg-black/25 dark:bg-black/50 z-40 backdrop-blur-xs" style="display: none;"></div>
    </div>
</x-layouts.app>
