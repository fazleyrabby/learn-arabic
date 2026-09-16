<x-layouts.app>
    <x-slot:title>{{ $surah->name_latin }} ({{ $surah->name_ar }}) — {{ __('Quran Studio') }}</x-slot:title>

    <div x-data="{
        currentAyahIndex: 0,
        isPlayingAll: false,
        activeAyahAudio: null,
        repeatMode: '1x', // '1x', '3x', 'loop'
        repeatCount: 0,
        playbackRate: 1.0,
        fontSize: 'xl', // 'md', 'lg', 'xl', '2xl'
        translationMode: 'both', // 'both', 'en', 'bn', 'none'
        selectedWord: null,
        showWordDrawer: false,
        showCelebration: false,
        verses: {{ json_encode($surah->verses->map(function($v, $idx) use ($surah) {
            $sPad = str_pad($surah->number, 3, '0', STR_PAD_LEFT);
            $aPad = str_pad($v->verse_number, 3, '0', STR_PAD_LEFT);
            
            // Build words array
            $words = [];
            if ($v->words->isNotEmpty()) {
                foreach ($v->words as $w) {
                    $words[] = [
                        'id' => $w->id,
                        'pos' => $w->position,
                        'text_ar' => $w->text_ar,
                        'translation' => $w->translation,
                        'translation_bn' => $w->translation_bn,
                        'transliteration' => $w->transliteration,
                        'audio_url' => $w->audio_url ?: 'https://audio.qurancdn.com/wbw/' . $sPad . '_' . $aPad . '_' . str_pad($w->position, 3, '0', STR_PAD_LEFT) . '.mp3',
                        'root' => $w->root ? [
                            'root_ar' => $w->root->root_ar,
                            'meaning' => $w->root->meaning,
                        ] : null,
                        'morphology' => $w->morphology ? [
                            'part_of_speech' => $w->morphology->part_of_speech,
                            'pattern' => $w->morphology->pattern,
                        ] : null,
                    ];
                }
            } else {
                // Tokenize verse text
                $tokens = preg_split('/\s+/u', trim($v->text_ar), -1, PREG_SPLIT_NO_EMPTY);
                foreach ($tokens as $pos => $tok) {
                    $wPad = str_pad($pos + 1, 3, '0', STR_PAD_LEFT);
                    $words[] = [
                        'id' => $pos + 1,
                        'pos' => $pos + 1,
                        'text_ar' => $tok,
                        'translation' => null,
                        'translation_bn' => null,
                        'transliteration' => null,
                        'audio_url' => 'https://audio.qurancdn.com/wbw/' . $sPad . '_' . $aPad . '_' . $wPad . '.mp3',
                        'root' => null,
                        'morphology' => null,
                    ];
                }
            }

            return [
                'index' => $idx,
                'number' => $v->verse_number,
                'text_ar' => $v->text_ar,
                'translation' => $v->translation,
                'translation_bn' => $v->translation_bn,
                'transliteration' => $v->transliteration,
                'audio_url' => $v->audio_url,
                'words' => $words,
            ];
        }), JSON_UNESCAPED_UNICODE) }},

        playAyahByIndex(index) {
            if (index < 0 || index >= this.verses.length) return;
            this.currentAyahIndex = index;
            this.stopAudio();

            const v = this.verses[index];
            if (!v.audio_url) return;

            this.activeAyahAudio = new Audio(v.audio_url);
            this.activeAyahAudio.playbackRate = this.playbackRate;
            this.isPlayingAll = true;

            // Scroll verse into view smoothly
            const el = document.getElementById('ayah-' + v.number);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            this.activeAyahAudio.onended = () => {
                if (this.repeatMode === 'loop') {
                    this.playAyahByIndex(this.currentAyahIndex);
                } else if (this.repeatMode === '3x') {
                    this.repeatCount++;
                    if (this.repeatCount < 3) {
                        this.playAyahByIndex(this.currentAyahIndex);
                    } else {
                        this.repeatCount = 0;
                        this.nextAyah();
                    }
                } else {
                    this.nextAyah();
                }
            };

            this.activeAyahAudio.play().catch(e => {
                console.warn('Audio play error, falling back:', e);
                this.isPlayingAll = false;
            });
        },

        togglePlayAll() {
            if (this.isPlayingAll) {
                this.stopAudio();
            } else {
                this.playAyahByIndex(this.currentAyahIndex);
            }
        },

        nextAyah() {
            if (this.currentAyahIndex < this.verses.length - 1) {
                this.playAyahByIndex(this.currentAyahIndex + 1);
            } else {
                this.stopAudio();
                this.showCelebration = true;
            }
        },

        prevAyah() {
            if (this.currentAyahIndex > 0) {
                this.playAyahByIndex(this.currentAyahIndex - 1);
            }
        },

        stopAudio() {
            if (this.activeAyahAudio) {
                this.activeAyahAudio.pause();
                this.activeAyahAudio.currentTime = 0;
                this.activeAyahAudio = null;
            }
            this.isPlayingAll = false;
        },

        selectWord(w, ayahNumber) {
            this.selectedWord = { ...w, ayah_number: ayahNumber };
            this.showWordDrawer = true;
            if (w.audio_url) {
                window.playAudio(w.audio_url, w.text_ar);
            } else {
                window.speakArabic(w.text_ar);
            }
        },

        cycleSpeed() {
            if (this.playbackRate === 1.0) {
                this.playbackRate = 0.8;
            } else if (this.playbackRate === 0.8) {
                this.playbackRate = 0.65;
            } else {
                this.playbackRate = 1.0;
            }
            if (this.activeAyahAudio) {
                this.activeAyahAudio.playbackRate = this.playbackRate;
            }
        },

        cycleRepeat() {
            if (this.repeatMode === '1x') this.repeatMode = '3x';
            else if (this.repeatMode === '3x') this.repeatMode = 'loop';
            else this.repeatMode = '1x';
            this.repeatCount = 0;
        }
    }" class="space-y-8 relative pb-24">

        <!-- Top Navigation Bar (Back, Prev Surah, Next Surah) -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-[#E8E2D8] dark:border-[#1E2738] pb-4">
            <a href="{{ route('quran.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#1B4D3E] dark:text-emerald-400 hover:underline">
                <span>&larr;</span>
                <span>{{ app()->getLocale() === 'bn' ? 'সকল সূরা সূচি' : 'All 114 Surahs' }}</span>
            </a>

            <div class="flex items-center gap-2">
                @if ($prevSurah)
                    <a href="{{ route('quran.show', $prevSurah->number) }}" class="px-3 py-1.5 rounded-xl bg-white dark:bg-[#131926] border border-[#E8E2D8] dark:border-[#212B3E] text-xs font-medium text-[#181C1E] dark:text-white hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] transition-all shadow-xs flex items-center gap-1.5">
                        <span>&larr;</span>
                        <span class="hidden sm:inline">{{ $prevSurah->name_latin }}</span>
                        <span class="sm:hidden">#{{ $prevSurah->number }}</span>
                    </a>
                @endif

                <span class="text-xs font-mono font-bold px-3 py-1.5 rounded-xl bg-[#1B4D3E]/10 dark:bg-emerald-950/40 text-[#1B4D3E] dark:text-emerald-400 border border-[#1B4D3E]/20 dark:border-emerald-500/30">
                    {{ $surah->number }} / 114
                </span>

                @if ($nextSurah)
                    <a href="{{ route('quran.show', $nextSurah->number) }}" class="px-3 py-1.5 rounded-xl bg-white dark:bg-[#131926] border border-[#E8E2D8] dark:border-[#212B3E] text-xs font-medium text-[#181C1E] dark:text-white hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] transition-all shadow-xs flex items-center gap-1.5">
                        <span class="hidden sm:inline">{{ $nextSurah->name_latin }}</span>
                        <span class="sm:hidden">#{{ $nextSurah->number }}</span>
                        <span>&rarr;</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Surah Header Card -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-white via-[#FAF8F5] to-[#F2EDE4] dark:from-[#131926] dark:via-[#111723] dark:to-[#0B0F19] border border-[#E8E2D8] dark:border-[#212B3E] p-6 sm:p-8 text-center shadow-xs">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-semibold bg-[#1B4D3E]/10 text-[#1B4D3E] dark:bg-emerald-400/10 dark:text-emerald-400 border border-[#1B4D3E]/20 dark:border-emerald-400/20 mb-2">
                <span>{{ __('Surah') }} #{{ $surah->number }}</span>
                <span>•</span>
                <span>{{ $surah->revelation_type }}</span>
                <span>•</span>
                <span>{{ $surah->verse_count }} {{ app()->getLocale() === 'bn' ? 'আয়াত' : 'Verses' }}</span>
            </div>

            <!-- Big Calligraphic Arabic Surah Name -->
            <div class="font-arabic text-5xl sm:text-6xl text-[#181C1E] dark:text-white leading-relaxed my-1 select-none">
                {{ $surah->name_ar }}
            </div>

            <!-- Latin and English / Bengali Titles -->
            <h1 class="text-xl sm:text-2xl font-bold text-[#181C1E] dark:text-white tracking-tight">
                {{ $surah->name_latin }}
                @if ($surah->name_english)
                    <span class="text-sm font-normal text-[#5C656C] dark:text-[#94A3B8]">({{ $surah->name_english }})</span>
                @endif
            </h1>

            @if ($surah->name_bn)
                <div class="text-sm sm:text-base font-semibold text-[#1B4D3E] dark:text-emerald-400 mt-1">
                    {{ $surah->name_bn }}
                </div>
            @endif

            <p class="text-xs text-[#5C656C] dark:text-[#94A3B8] max-w-md mx-auto mt-2">
                {{ app()->getLocale() === 'bn' 
                    ? 'যেকোনো শব্দে চাপ দিয়ে বিশুদ্ধ উচ্চারণ শুনুন। শিশুদের জন্য সহজ পাঠ্য।' 
                    : 'Tap any word to hear crystal-clear pronunciation. Perfect for children & new learners.' }}
            </p>
        </div>

        <!-- Sticky Player & Study Control Bar -->
        <div class="sticky top-16 z-30 rounded-2xl bg-white/95 dark:bg-[#131926]/95 backdrop-blur-md border border-[#E8E2D8] dark:border-[#212B3E] p-2.5 sm:p-4 shadow-md flex flex-wrap items-center justify-between gap-2 sm:gap-3">
            <!-- Audio Playback Controls -->
            <div class="flex items-center gap-1.5 sm:gap-2">
                <!-- Master Play / Pause Button -->
                <button @click="togglePlayAll()" 
                        type="button" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs font-bold text-white shadow-sm transition-all duration-150 active:scale-95 cursor-pointer"
                        :class="isPlayingAll ? 'bg-amber-600 hover:bg-amber-700' : 'bg-[#1B4D3E] hover:bg-[#153e32] dark:bg-emerald-600 dark:hover:bg-emerald-700'">
                    <template x-if="!isPlayingAll">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <span>{{ app()->getLocale() === 'bn' ? 'শুনুন' : 'Play' }}</span>
                        </span>
                    </template>
                    <template x-if="isPlayingAll">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 fill-current" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            <span>{{ app()->getLocale() === 'bn' ? 'বিরতি' : 'Pause' }}</span>
                        </span>
                    </template>
                </button>

                <!-- Prev / Next Ayah -->
                <button @click="prevAyah()" type="button" class="p-1.5 sm:p-2 rounded-xl border border-[#E8E2D8] dark:border-[#212B3E] hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] text-[#5C656C] dark:text-[#94A3B8] transition-colors cursor-pointer" title="{{ __('Previous Ayah') }}">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                </button>
                <button @click="nextAyah()" type="button" class="p-1.5 sm:p-2 rounded-xl border border-[#E8E2D8] dark:border-[#212B3E] hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] text-[#5C656C] dark:text-[#94A3B8] transition-colors cursor-pointer" title="{{ __('Next Ayah') }}">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                </button>

                <!-- Repeat Mode Pill (Crucial for Kids Memorization!) -->
                <button @click="cycleRepeat()" type="button" class="px-2 py-1 sm:px-2.5 sm:py-1.5 rounded-xl border border-[#E8E2D8] dark:border-[#212B3E] text-xs font-semibold hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] transition-colors cursor-pointer flex items-center gap-1" :class="repeatMode !== '1x' ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 border-amber-300' : 'text-[#5C656C] dark:text-[#94A3B8]'">
                    <span>🔁</span>
                    <span x-text="repeatMode === '1x' ? '1x' : (repeatMode === '3x' ? '3x' : 'Loop')"></span>
                </button>

                <!-- Speed Control Pill -->
                <button @click="cycleSpeed()" type="button" class="px-2 py-1 sm:px-2.5 sm:py-1.5 rounded-xl border border-[#E8E2D8] dark:border-[#212B3E] text-xs font-semibold hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] transition-colors cursor-pointer flex items-center gap-0.5 text-[#5C656C] dark:text-[#94A3B8]">
                    <span>⚡</span>
                    <span x-text="playbackRate + 'x'"></span>
                </button>
            </div>

            <!-- Visual Options (Font Size & Translation Filter) -->
            <div class="flex items-center gap-1.5 sm:gap-2">
                <!-- Font Size Selector -->
                <div class="flex items-center rounded-xl border border-[#E8E2D8] dark:border-[#1E2738] bg-[#FAF8F5] dark:bg-[#0B0F19] p-0.5 text-xs font-bold">
                    <button @click="fontSize = 'md'" :class="{ 'bg-white dark:bg-[#1E2738] text-[#181C1E] dark:text-white shadow-xs': fontSize === 'md', 'text-[#5C656C] dark:text-[#94A3B8]': fontSize !== 'md' }" class="px-1.5 sm:px-2 py-1 rounded-lg cursor-pointer">A</button>
                    <button @click="fontSize = 'xl'" :class="{ 'bg-white dark:bg-[#1E2738] text-[#181C1E] dark:text-white shadow-xs': fontSize === 'xl', 'text-[#5C656C] dark:text-[#94A3B8]': fontSize !== 'xl' }" class="px-1.5 sm:px-2 py-1 rounded-lg cursor-pointer">A+</button>
                    <button @click="fontSize = '2xl'" :class="{ 'bg-white dark:bg-[#1E2738] text-[#181C1E] dark:text-white shadow-xs': fontSize === '2xl', 'text-[#5C656C] dark:text-[#94A3B8]': fontSize !== '2xl' }" class="px-2 sm:px-2.5 py-1 rounded-lg cursor-pointer">👶 Kids</button>
                </div>

                <!-- Translation Filter Dropdown / Pill -->
                <select x-model="translationMode" class="px-2 py-1.5 rounded-xl border border-[#E8E2D8] dark:border-[#212B3E] bg-[#FAF8F5] dark:bg-[#0B0F19] text-xs font-medium text-[#181C1E] dark:text-white focus:outline-hidden cursor-pointer max-w-[130px] sm:max-w-none">
                    <option value="both">{{ app()->getLocale() === 'bn' ? 'বাংলা ও ইংরেজি' : 'English & Bengali' }}</option>
                    <option value="bn">বাংলা অনুবাদ</option>
                    <option value="en">English Only</option>
                    <option value="none">{{ app()->getLocale() === 'bn' ? 'শুধু আরবি (হিফজ)' : 'Arabic Only' }}</option>
                </select>
            </div>
        </div>

        <!-- Bismillah Header for Surahs other than 1 and 9 -->
        @if ($surah->number != 1 && $surah->number != 9)
            <div class="rounded-3xl bg-white dark:bg-[#131926] border border-[#E8E2D8] dark:border-[#212B3E] p-6 text-center space-y-3 shadow-xs">
                <div class="font-arabic text-3xl sm:text-4xl text-[#181C1E] dark:text-white leading-relaxed select-none">
                    بِسْمِ ٱللَّهِ ٱلرَّحْمَـٰنِ ٱلرَّحِيمِ
                </div>
                <div class="text-xs text-[#5C656C] dark:text-[#94A3B8]">
                    {{ app()->getLocale() === 'bn' ? 'শুরু করছি আল্লাহর নামে যিনি পরম করুণাময়, অতি দয়ালু।' : 'In the name of Allah, the Entirely Merciful, the Especially Merciful.' }}
                </div>
                <div>
                    <button @click="playAudio('https://everyayah.com/data/Alafasy_128kbps/{{ str_pad($surah->number, 3, '0', STR_PAD_LEFT) }}000.mp3')" 
                            type="button" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#E8E2D8] dark:border-[#212B3E] text-xs font-semibold text-[#1B4D3E] dark:text-emerald-400 hover:bg-[#1B4D3E] hover:text-white transition-all cursor-pointer">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <span>{{ __('Listen to Bismillah') }}</span>
                    </button>
                </div>
            </div>
        @endif

        <!-- Verses Stream -->
        <div class="space-y-6">
            <template x-for="(verse, index) in verses" :key="verse.number">
                <div :id="'ayah-' + verse.number" 
                     class="group rounded-3xl bg-white dark:bg-[#131926] border p-5 sm:p-7 space-y-5 transition-all duration-200 shadow-xs"
                     :class="currentAyahIndex === index && isPlayingAll ? 'border-[#1B4D3E] dark:border-emerald-500 ring-2 ring-[#1B4D3E]/20 dark:ring-emerald-500/20 bg-emerald-50/20 dark:bg-emerald-950/20' : 'border-[#E8E2D8] dark:border-[#212B3E] hover:border-[#1B4D3E]/40 dark:hover:border-emerald-500/40'">

                    <!-- Verse Metadata Bar -->
                    <div class="flex items-center justify-between border-b border-[#E8E2D8]/60 dark:border-[#212B3E]/60 pb-3">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-full bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#E8E2D8] dark:border-[#212B3E] text-xs font-mono font-bold flex items-center justify-center text-[#1B4D3E] dark:text-emerald-400 shadow-xs"
                                  x-text="'{{ $surah->number }}:' + verse.number">
                            </span>
                            <template x-if="verse.transliteration">
                                <span class="text-xs text-[#5C656C] dark:text-[#94A3B8] hidden sm:inline" x-text="verse.transliteration"></span>
                            </template>
                        </div>

                        <!-- Single Ayah Audio Button -->
                        <div class="flex items-center gap-2">
                            <button @click="playAyahByIndex(index)" 
                                    type="button" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-xs font-medium transition-all active:scale-95 cursor-pointer"
                                    :class="currentAyahIndex === index && isPlayingAll ? 'bg-[#1B4D3E] text-white border-transparent' : 'border-[#E8E2D8] dark:border-[#212B3E] bg-[#FAF8F5] dark:bg-[#0B0F19] text-[#181C1E] dark:text-white hover:border-[#1B4D3E]'">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                <span>{{ app()->getLocale() === 'bn' ? 'আয়াত শুনুন' : 'Listen Ayah' }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Interactive Word-by-Word Chips (RTL Flow) -->
                    <div class="flex flex-wrap flex-row-reverse gap-2 sm:gap-3 items-center justify-start py-2">
                        <template x-for="word in verse.words" :key="word.pos">
                            <button @click="selectWord(word, verse.number)"
                                    type="button"
                                    class="group/word relative rounded-2xl p-2.5 sm:p-3.5 bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#E8E2D8] dark:border-[#212B3E] hover:border-[#1B4D3E] dark:hover:border-emerald-400 hover:shadow-sm active:scale-90 transition-all duration-150 flex flex-col items-center min-w-[65px] sm:min-w-[85px] text-center cursor-pointer select-none">
                                
                                <!-- Word Arabic Text (Scalable size) -->
                                <span class="font-arabic leading-relaxed text-[#181C1E] dark:text-white group-hover/word:text-[#1B4D3E] dark:group-hover/word:text-emerald-400 transition-colors"
                                      :class="{
                                          'text-2xl sm:text-3xl': fontSize === 'md',
                                          'text-3xl sm:text-4xl': fontSize === 'xl',
                                          'text-4xl sm:text-5xl': fontSize === '2xl'
                                      }"
                                      x-text="word.text_ar">
                                </span>

                                <!-- Word Bengali/English Translation subtitle if available -->
                                <template x-if="word.translation_bn || word.translation">
                                    <span class="text-[10px] font-medium text-[#5C656C] dark:text-[#94A3B8] mt-1 line-clamp-1"
                                          x-text="word.translation_bn || word.translation">
                                    </span>
                                </template>

                                <!-- Play Sound Hint Dot -->
                                <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 rounded-full bg-emerald-500/40 group-hover/word:bg-emerald-500 transition-colors"></span>
                            </button>
                        </template>

                        <!-- End of Ayah Quranic Marker -->
                        <span class="inline-flex items-center justify-center font-arabic text-xl sm:text-2xl text-[#9A722C] dark:text-amber-400 select-none px-1"
                              x-text="' ۝ ' + verse.number">
                        </span>
                    </div>

                    <!-- Translations Area -->
                    <div class="space-y-2 pt-2 border-t border-[#E8E2D8]/50 dark:border-[#212B3E]/50">
                        <!-- Bengali Translation -->
                        <template x-if="translationMode === 'both' || translationMode === 'bn'">
                            <p class="text-sm sm:text-base text-[#181C1E] dark:text-gray-200 leading-relaxed font-normal">
                                <span class="text-xs font-semibold text-[#1B4D3E] dark:text-emerald-400 mr-1.5">বাং:</span>
                                <span x-text="verse.translation_bn || 'অনুবাদ প্রস্তুত হচ্ছে...'"></span>
                            </p>
                        </template>

                        <!-- English Translation -->
                        <template x-if="translationMode === 'both' || translationMode === 'en'">
                            <p class="text-xs sm:text-sm text-[#5C656C] dark:text-[#94A3B8] leading-relaxed">
                                <span class="text-[11px] font-semibold text-gray-500 mr-1">EN:</span>
                                <span x-text="verse.translation"></span>
                            </p>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- Word Detail Slide-Over Modal / Bottom Sheet -->
        <div x-show="showWordDrawer" 
             class="fixed inset-0 z-50 overflow-hidden flex items-end sm:items-center justify-center p-0 sm:p-4 bg-black/60 backdrop-blur-xs"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.self="showWordDrawer = false"
             style="display: none;">

            <div class="w-full max-w-lg bg-white dark:bg-[#131926] rounded-t-3xl sm:rounded-3xl border border-[#E8E2D8] dark:border-[#212B3E] p-6 sm:p-8 space-y-6 shadow-2xl relative max-h-[85vh] overflow-y-auto"
                 x-transition:enter="transition ease-out duration-200 transform"
                 x-transition:enter-start="translate-y-full sm:scale-95"
                 x-transition:enter-end="translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-150 transform"
                 x-transition:leave-start="translate-y-0 sm:scale-100"
                 x-transition:leave-end="translate-y-full sm:scale-95">

                <!-- Close Button -->
                <button @click="showWordDrawer = false" class="absolute top-4 right-4 p-2 rounded-xl text-[#5C656C] dark:text-[#94A3B8] hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>

                <!-- Word Card -->
                <div class="text-center space-y-2 pt-2">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#1B4D3E]/10 text-[#1B4D3E] dark:bg-emerald-400/10 dark:text-emerald-400">
                        <span>{{ __('Ayah') }}</span>
                        <span x-text="'{{ $surah->number }}:' + (selectedWord?.ayah_number || 1)"></span>
                        <span>•</span>
                        <span>{{ __('Word') }} #<span x-text="selectedWord?.pos"></span></span>
                    </div>

                    <!-- Huge Arabic Word (Tap to replay) -->
                    <div class="font-arabic text-6xl sm:text-7xl text-[#181C1E] dark:text-white my-3 select-none cursor-pointer hover:scale-105 active:scale-95 transition-transform"
                         @click="selectedWord?.audio_url ? window.playAudio(selectedWord.audio_url, selectedWord.text_ar) : window.speakArabic(selectedWord?.text_ar)"
                         title="{{ __('Click to replay sound') }}">
                        <span x-text="selectedWord?.text_ar"></span>
                    </div>

                    <!-- Big Play Audio Button -->
                    <button @click="selectedWord?.audio_url ? window.playAudio(selectedWord.audio_url, selectedWord.text_ar) : window.speakArabic(selectedWord?.text_ar)"
                            type="button" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-[#1B4D3E] hover:bg-[#153e32] dark:bg-emerald-600 text-white text-xs font-bold shadow-md hover:scale-105 active:scale-95 transition-all cursor-pointer">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <span>{{ __('Replay Pronunciation') }}</span>
                    </button>
                </div>

                <!-- Meanings & Breakdown -->
                <div class="space-y-4 border-t border-[#E8E2D8] dark:border-[#1E2738] pt-4">
                    <!-- Bengali Meaning -->
                    <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#E8E2D8] dark:border-[#212B3E] space-y-1">
                        <div class="text-[11px] font-semibold text-[#1B4D3E] dark:text-emerald-400 uppercase tracking-wider">
                            {{ __('বাংলা অর্থ') }}
                        </div>
                        <div class="text-base font-semibold text-[#181C1E] dark:text-white"
                             x-text="selectedWord?.translation_bn || '{{ app()->getLocale() === 'bn' ? 'বিশুদ্ধ কুরআন শব্দার্থ' : 'Quranic Word Meaning' }}'">
                        </div>
                    </div>

                    <!-- English Meaning -->
                    <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#E8E2D8] dark:border-[#212B3E] space-y-1">
                        <div class="text-[11px] font-semibold text-[#5C656C] dark:text-[#94A3B8] uppercase tracking-wider">
                            English Meaning
                        </div>
                        <div class="text-sm font-semibold text-[#181C1E] dark:text-white"
                             x-text="selectedWord?.translation || 'Authentic Quranic Meaning'">
                        </div>
                    </div>

                    <!-- Morphology & Root if present -->
                    <template x-if="selectedWord?.root || selectedWord?.morphology">
                        <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#E8E2D8] dark:border-[#212B3E] space-y-2 text-xs">
                            <template x-if="selectedWord?.root">
                                <div class="flex items-center justify-between">
                                    <span class="text-[#5C656C] dark:text-[#94A3B8]">{{ __('Arabic Root') }}:</span>
                                    <span class="font-arabic font-bold text-sm text-[#9A722C] dark:text-amber-400" x-text="selectedWord.root.root_ar"></span>
                                </div>
                            </template>
                            <template x-if="selectedWord?.morphology?.part_of_speech">
                                <div class="flex items-center justify-between">
                                    <span class="text-[#5C656C] dark:text-[#94A3B8]">{{ __('Grammar Part') }}:</span>
                                    <span class="font-semibold text-[#181C1E] dark:text-white" x-text="selectedWord.morphology.part_of_speech"></span>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Completion Celebration Modal (Delightful for 5-Year-Olds!) -->
        <div x-show="showCelebration" 
             class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
             style="display: none;">
            <div class="w-full max-w-sm bg-white dark:bg-[#131926] rounded-3xl border border-amber-300 dark:border-amber-600 p-8 text-center space-y-4 shadow-2xl relative">
                <div class="text-6xl animate-bounce">
                    🎉 ⭐ 🌸
                </div>
                <h3 class="text-2xl font-bold text-[#181C1E] dark:text-white">
                    {{ app()->getLocale() === 'bn' ? 'মাশাআল্লাহ! চমৎকার!' : 'MashaAllah! Great Job!' }}
                </h3>
                <p class="text-sm text-[#5C656C] dark:text-[#94A3B8]">
                    {{ app()->getLocale() === 'bn' 
                        ? 'তুমি সম্পূর্ণ সূরাটি শুনেছ এবং পড়েছ!' 
                        : 'You completed listening and reading this Surah!' }}
                </p>

                <div class="pt-2 flex flex-col gap-2">
                    @if ($nextSurah)
                        <a href="{{ route('quran.show', $nextSurah->number) }}" class="w-full py-3 rounded-2xl bg-[#1B4D3E] hover:bg-[#153e32] dark:bg-emerald-600 text-white text-xs font-bold shadow-md transition-all">
                            {{ app()->getLocale() === 'bn' ? 'পরবর্তী সূরা শুনুন' : 'Next Surah: ' . $nextSurah->name_latin }} &rarr;
                        </a>
                    @endif
                    <button @click="showCelebration = false; playAyahByIndex(0)" type="button" class="w-full py-3 rounded-2xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#E8E2D8] dark:border-[#212B3E] text-xs font-semibold text-[#181C1E] dark:text-white hover:bg-[#EAE4D9]/40 transition-colors">
                        {{ app()->getLocale() === 'bn' ? 'আবার শুনুন' : 'Listen Again' }} 🔁
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
