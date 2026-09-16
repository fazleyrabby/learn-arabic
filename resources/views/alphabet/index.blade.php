<x-layouts.app>
    <x-slot:title>{{ __('Arabic Alphabet & Harakat') }} — {{ __('Quranic Arabic') }}</x-slot:title>

    <div x-data="{ 
        activeTab: '{{ request('tab', 'kids') }}',
        activeAudioUrl: null,
        playedLetters: new Set(),
        selectedLetterChar: 'ب',
        selectedLetterName: 'Baa',
        selectedLetterBn: 'বা',
        selectedLetterAudio: '/audio/letters/2.mp3',
        activeHarakat: null,
        harakatSymbol: '',
        soundLabelEn: 'Baa',
        soundLabelBn: 'বা',

        syllableMap: {
            'ا': { fathah: ['A', 'আ'], kasrah: ['I', 'ই'], dammah: ['U', 'উ'] },
            'ب': { fathah: ['Ba', 'বা'], kasrah: ['Bi', 'বি'], dammah: ['Bu', 'বু'] },
            'ت': { fathah: ['Ta', 'তা'], kasrah: ['Ti', 'তি'], dammah: ['Tu', 'তু'] },
            'ث': { fathah: ['Tha', 'ছা'], kasrah: ['Thi', 'ছি'], dammah: ['Thu', 'ছু'] },
            'ج': { fathah: ['Ja', 'জা'], kasrah: ['Ji', 'জি'], dammah: ['Ju', 'জু'] },
            'ح': { fathah: ['Ḥa', 'হা'], kasrah: ['Ḥi', 'হি'], dammah: ['Ḥu', 'হু'] },
            'خ': { fathah: ['Kha', 'খা'], kasrah: ['Khi', 'খি'], dammah: ['Khu', 'খু'] },
            'د': { fathah: ['Da', 'দা'], kasrah: ['Di', 'দি'], dammah: ['Du', 'দু'] },
            'ذ': { fathah: ['Dha', 'যা'], kasrah: ['Dhi', 'যি'], dammah: ['Dhu', 'যু'] },
            'ر': { fathah: ['Ra', 'রা'], kasrah: ['Ri', 'রি'], dammah: ['Ru', 'রু'] },
            'ز': { fathah: ['Za', 'যা'], kasrah: ['Zi', 'যি'], dammah: ['Zu', 'যু'] },
            'س': { fathah: ['Sa', 'সা'], kasrah: ['Si', 'সি'], dammah: ['Su', 'সু'] },
            'ش': { fathah: ['Sha', 'শা'], kasrah: ['Shi', 'শি'], dammah: ['Shu', 'শু'] },
            'ص': { fathah: ['Ṣa', 'ছা'], kasrah: ['Ṣi', 'ছি'], dammah: ['Ṣu', 'ছু'] },
            'ض': { fathah: ['Ḍa', 'দ্বা'], kasrah: ['Ḍi', 'দ্বি'], dammah: ['Ḍu', 'দ্বু'] },
            'ط': { fathah: ['Ṭa', 'ত্বা'], kasrah: ['Ṭi', 'ত্বি'], dammah: ['Ṭu', 'ত্বু'] },
            'ظ': { fathah: ['Ẓa', 'য্বা'], kasrah: ['Ẓi', 'য্বি'], dammah: ['Ẓu', 'য্বু'] },
            'ع': { fathah: ['‘A', 'আ'], kasrah: ['‘I', 'ই'], dammah: ['‘U', 'উ'] },
            'غ': { fathah: ['Gha', 'গা'], kasrah: ['Ghi', 'গি'], dammah: ['Ghu', 'গু'] },
            'ف': { fathah: ['Fa', 'ফা'], kasrah: ['Fi', 'ফি'], dammah: ['Fu', 'ফু'] },
            'ق': { fathah: ['Qa', 'ক্বা'], kasrah: ['Qi', 'ক্বি'], dammah: ['Qu', 'ক্বু'] },
            'ك': { fathah: ['Ka', 'কা'], kasrah: ['Ki', 'কি'], dammah: ['Ku', 'কু'] },
            'ل': { fathah: ['La', 'লা'], kasrah: ['Li', 'লি'], dammah: ['Lu', 'লু'] },
            'م': { fathah: ['Ma', 'মা'], kasrah: ['Mi', 'মি'], dammah: ['Mu', 'মু'] },
            'ن': { fathah: ['Na', 'না'], kasrah: ['Ni', 'নি'], dammah: ['Nu', 'নু'] },
            'ه': { fathah: ['Ha', 'হা'], kasrah: ['Hi', 'হি'], dammah: ['Hu', 'হু'] },
            'و': { fathah: ['Wa', 'ওয়া'], kasrah: ['Wi', 'উই'], dammah: ['Wu', 'উ'] },
            'ي': { fathah: ['Ya', 'ইয়া'], kasrah: ['Yi', 'ই'], dammah: ['Yu', 'ইউ'] },
        },

        mixHarakat(harakat, type, chimeFreq) {
            this.activeHarakat = type;
            this.harakatSymbol = harakat;
            const letter = this.selectedLetterChar;
            const map = this.syllableMap[letter] || {
                fathah: [this.selectedLetterName + 'a', this.selectedLetterBn + 'া'],
                kasrah: [this.selectedLetterName + 'i', this.selectedLetterBn + 'ি'],
                dammah: [this.selectedLetterName + 'u', this.selectedLetterBn + 'ু']
            };
            const pair = map[type] || ['Sound', 'ধ্বনি'];
            this.soundLabelEn = pair[0];
            this.soundLabelBn = pair[1];

            if (window.playChime) {
                window.playChime(chimeFreq, 'sine', 0.18);
            }

            const combined = letter + harakat;
            window.speakArabic(combined, pair[0]);
        },

        tapLetter(l) {
            this.selectedLetterChar = l.character;
            this.selectedLetterName = l.name_latin;
            this.selectedLetterBn = l.name_bn || l.name_latin;
            this.selectedLetterAudio = l.audio_url;
            this.playedLetters.add(l.order);

            if (this.activeHarakat) {
                const map = this.syllableMap[l.character];
                if (map && map[this.activeHarakat]) {
                    this.soundLabelEn = map[this.activeHarakat][0];
                    this.soundLabelBn = map[this.activeHarakat][1];
                }
                const combined = l.character + this.harakatSymbol;
                window.speakArabic(combined, this.soundLabelEn);
            } else {
                this.soundLabelEn = l.name_latin;
                this.soundLabelBn = l.name_bn || l.name_latin;
                window.playAudio(l.audio_url, l.name_ar);
            }
        },

        resetHarakat() {
            this.activeHarakat = null;
            this.harakatSymbol = '';
            this.soundLabelEn = this.selectedLetterName;
            this.soundLabelBn = this.selectedLetterBn;
            if (this.selectedLetterAudio) {
                window.playAudio(this.selectedLetterAudio, this.selectedLetterName);
            }
        }
    }" class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-[#EBE6DE] dark:border-[#212B3E] pb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-[#1A1D20] dark:text-white flex items-center gap-2">
                    <span>{{ __('Arabic Foundations') }}</span>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 font-bold border border-amber-200 dark:border-amber-800">
                        ⭐ {{ app()->getLocale() === 'bn' ? 'শিশুদের জন্য সহজ' : 'Kids Friendly' }}
                    </span>
                </h1>
                <p class="text-sm text-[#687076] dark:text-[#94A3B8] mt-1">
                    {{ app()->getLocale() === 'bn' ? '২৮টি আরবি হরফ স্পর্শ করে শুনুন এবং স্বরচিহ্নসহ বিশুদ্ধ উচ্চারণ শিখুন।' : 'Touch any letter to hear authentic pronunciation. Master the 28 consonants and vowelling system.' }}
                </p>
            </div>

            <!-- Tab Switcher -->
            <div class="flex items-center p-1 rounded-xl bg-[#EAE5DB]/60 dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] self-start sm:self-auto overflow-x-auto max-w-full">
                <button @click="activeTab = 'kids'" :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-bold': activeTab === 'kids', 'text-[#687076] dark:text-[#94A3B8]': activeTab !== 'kids' }" class="px-3.5 sm:px-4 py-1.5 rounded-lg text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    🎈 {{ app()->getLocale() === 'bn' ? 'শিশুদের সাউন্ডবোর্ড' : 'Kids Soundboard' }}
                </button>
                <button @click="activeTab = 'letters'" :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-semibold': activeTab === 'letters', 'text-[#687076] dark:text-[#94A3B8]': activeTab !== 'letters' }" class="px-3.5 sm:px-4 py-1.5 rounded-lg text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    {{ app()->getLocale() === 'bn' ? '২৮টি হরফ ও মাখরাজ' : '28 Letters Table' }}
                </button>
                <button @click="activeTab = 'harakat'" :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-semibold': activeTab === 'harakat', 'text-[#687076] dark:text-[#94A3B8]': activeTab !== 'harakat' }" class="px-3.5 sm:px-4 py-1.5 rounded-lg text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    {{ app()->getLocale() === 'bn' ? 'হরকত (স্বরচিহ্ন)' : 'Harakat (Vowels)' }}
                </button>
            </div>
        </div>

        <!-- KIDS SOUNDBOARD TAB (Delightful for 5-year-olds!) -->
        <div x-show="activeTab === 'kids'" class="space-y-8">
            <!-- Kids Interactive Harakat Mixer Station (Ba - Bi - Bu) -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-50 via-white to-emerald-50 dark:from-[#131926] dark:via-[#111723] dark:to-[#0B0F19] border-2 border-amber-300 dark:border-amber-700/60 p-4 sm:p-8 shadow-sm">
                <div class="flex flex-col md:flex-row items-center justify-between gap-5 sm:gap-6">
                    <div class="space-y-2 text-center md:text-left">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-200/60 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300">
                            <span>🎵 {{ app()->getLocale() === 'bn' ? 'হরকত ম্যাজিক সাউন্ড (বা - বি - বু)' : 'Vowel Magic (Ba - Bi - Bu Sound Machine)' }}</span>
                        </div>
                        <h2 class="text-lg sm:text-2xl font-bold text-[#181C1E] dark:text-white">
                            {{ app()->getLocale() === 'bn' ? 'হরকতের সাথে হরফ মিলিয়ে শুনুন' : 'Mix Letters with Vowels' }}
                        </h2>
                        <p class="text-xs text-[#5C656C] dark:text-[#94A3B8] max-w-md">
                            {{ app()->getLocale() === 'bn' ? 'যেকোনো হরফ নির্বাচন করে জবর (Fatḥah), জের (Kasrah) বা পেশ (Ḍammah) চাপুন।' : 'Select a letter below, then tap Fatḥah (A), Kasrah (I), or Ḍammah (U) to hear the exact sound!' }}
                        </p>
                    </div>

                    <!-- Active Letter Display + Harakat Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto justify-center">
                        <!-- Big Tactile Selected Letter / Syllable Tile -->
                        <div class="relative group cursor-pointer" @click="activeHarakat ? resetHarakat() : (selectedLetterAudio ? window.playAudio(selectedLetterAudio, selectedLetterName) : window.speakArabic(selectedLetterChar))" title="Tap to replay sound">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl flex flex-col items-center justify-center shadow-lg transition-all transform active:scale-95 select-none shrink-0 border-2"
                                 :class="activeHarakat === 'fathah' 
                                    ? 'bg-red-50 dark:bg-red-950/60 border-red-400 dark:border-red-500 ring-4 ring-red-200/50 dark:ring-red-900/30' 
                                    : (activeHarakat === 'kasrah' 
                                        ? 'bg-blue-50 dark:bg-blue-950/60 border-blue-400 dark:border-blue-500 ring-4 ring-blue-200/50 dark:ring-blue-900/30' 
                                        : (activeHarakat === 'dammah' 
                                            ? 'bg-emerald-50 dark:bg-emerald-950/60 border-emerald-400 dark:border-emerald-500 ring-4 ring-emerald-200/50 dark:ring-emerald-900/30' 
                                            : 'bg-white dark:bg-[#1B2332] border-amber-400 dark:border-amber-500 ring-4 ring-amber-200/40 dark:ring-amber-900/20'))">

                                <span class="font-arabic text-5xl sm:text-6xl leading-none transition-all transform group-hover:scale-105"
                                      :class="activeHarakat === 'fathah' 
                                        ? 'text-red-600 dark:text-red-400' 
                                        : (activeHarakat === 'kasrah' 
                                            ? 'text-blue-600 dark:text-blue-400' 
                                            : (activeHarakat === 'dammah' 
                                                ? 'text-emerald-600 dark:text-emerald-400' 
                                                : 'text-[#181C1E] dark:text-white'))"
                                      x-text="selectedLetterChar + harakatSymbol"></span>

                                <span class="text-xs font-black mt-1.5 tracking-wide transition-colors"
                                      :class="activeHarakat === 'fathah' 
                                        ? 'text-red-700 dark:text-red-300' 
                                        : (activeHarakat === 'kasrah' 
                                            ? 'text-blue-700 dark:text-blue-300' 
                                            : (activeHarakat === 'dammah' 
                                                ? 'text-emerald-700 dark:text-emerald-300' 
                                                : 'text-[#1B4D3E] dark:text-emerald-400'))"
                                      x-text="soundLabelEn + ' (' + soundLabelBn + ')'"></span>
                            </div>

                            <!-- Floating Sound Indicator Pill -->
                            <div class="absolute -top-2.5 left-1/2 -translate-x-1/2 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider text-white shadow-sm flex items-center gap-1 whitespace-nowrap"
                                 :class="activeHarakat === 'fathah' ? 'bg-red-500' : (activeHarakat === 'kasrah' ? 'bg-blue-500' : (activeHarakat === 'dammah' ? 'bg-emerald-500' : 'bg-amber-500'))">
                                <span>🔊</span>
                                <span x-text="activeHarakat ? soundLabelEn : '{{ __('Tap to hear') }}'"></span>
                            </div>
                        </div>

                        <!-- 3 Big Tactile Harakat Buttons -->
                        <div class="grid grid-cols-3 gap-2 sm:gap-2.5 w-full sm:w-auto">
                            <!-- Fathah (A sound) -->
                            <button @click="mixHarakat('َ', 'fathah', 523)" 
                                    type="button" 
                                    class="relative px-3 sm:px-4 py-2.5 sm:py-3 rounded-2xl border-2 transition-all text-center cursor-pointer shadow-xs select-none"
                                    :class="activeHarakat === 'fathah' 
                                        ? 'bg-red-100 dark:bg-red-900/60 border-red-500 dark:border-red-400 ring-3 ring-red-300/60 scale-105 shadow-sm' 
                                        : 'bg-red-50/80 dark:bg-red-950/30 border-red-300 dark:border-red-800/80 hover:bg-red-100 hover:scale-102 active:scale-95'">
                                <div class="font-arabic text-2xl sm:text-3xl text-red-600 dark:text-red-400 leading-none">&#x0640;َ</div>
                                <div class="text-[11px] sm:text-xs font-black text-red-700 dark:text-red-300 mt-1 truncate">{{ app()->getLocale() === 'bn' ? 'জবর (আ)' : 'Fatḥah (A)' }}</div>
                                <div class="text-[9px] font-semibold text-red-600/80 dark:text-red-400/80 mt-0.5">
                                    <span x-text="syllableMap[selectedLetterChar]?.fathah[0] || 'A'"></span> sound
                                </div>
                            </button>

                            <!-- Kasrah (I sound) -->
                            <button @click="mixHarakat('ِ', 'kasrah', 659)" 
                                    type="button" 
                                    class="relative px-3 sm:px-4 py-2.5 sm:py-3 rounded-2xl border-2 transition-all text-center cursor-pointer shadow-xs select-none"
                                    :class="activeHarakat === 'kasrah' 
                                        ? 'bg-blue-100 dark:bg-blue-900/60 border-blue-500 dark:border-blue-400 ring-3 ring-blue-300/60 scale-105 shadow-sm' 
                                        : 'bg-blue-50/80 dark:bg-blue-950/30 border-blue-300 dark:border-blue-800/80 hover:bg-blue-100 hover:scale-102 active:scale-95'">
                                <div class="font-arabic text-2xl sm:text-3xl text-blue-600 dark:text-blue-400 leading-none">&#x0640;ِ</div>
                                <div class="text-[11px] sm:text-xs font-black text-blue-700 dark:text-blue-300 mt-1 truncate">{{ app()->getLocale() === 'bn' ? 'জের (ই)' : 'Kasrah (I)' }}</div>
                                <div class="text-[9px] font-semibold text-blue-600/80 dark:text-blue-400/80 mt-0.5">
                                    <span x-text="syllableMap[selectedLetterChar]?.kasrah[0] || 'I'"></span> sound
                                </div>
                            </button>

                            <!-- Dammah (U sound) -->
                            <button @click="mixHarakat('ُ', 'dammah', 392)" 
                                    type="button" 
                                    class="relative px-3 sm:px-4 py-2.5 sm:py-3 rounded-2xl border-2 transition-all text-center cursor-pointer shadow-xs select-none"
                                    :class="activeHarakat === 'dammah' 
                                        ? 'bg-emerald-100 dark:bg-emerald-900/60 border-emerald-500 dark:border-emerald-400 ring-3 ring-emerald-300/60 scale-105 shadow-sm' 
                                        : 'bg-emerald-50/80 dark:bg-emerald-950/30 border-emerald-300 dark:border-emerald-800/80 hover:bg-emerald-100 hover:scale-102 active:scale-95'">
                                <div class="font-arabic text-2xl sm:text-3xl text-emerald-600 dark:text-emerald-400 leading-none">&#x0640;ُ</div>
                                <div class="text-[11px] sm:text-xs font-black text-emerald-700 dark:text-emerald-300 mt-1 truncate">{{ app()->getLocale() === 'bn' ? 'পেশ (উ)' : 'Ḍammah (U)' }}</div>
                                <div class="text-[9px] font-semibold text-emerald-600/80 dark:text-emerald-400/80 mt-0.5">
                                    <span x-text="syllableMap[selectedLetterChar]?.dammah[0] || 'U'"></span> sound
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Star Progress Counter for Kids -->
                <div class="mt-4 pt-3 border-t border-amber-200/60 dark:border-amber-900/60 flex flex-wrap items-center justify-between gap-2 text-xs">
                    <span class="font-semibold text-amber-800 dark:text-amber-300 flex items-center gap-1">
                        <span>⭐ {{ app()->getLocale() === 'bn' ? 'সংগৃহীত স্টার:' : 'Collected Stars:' }}</span>
                        <span class="font-mono font-bold" x-text="playedLetters.size + ' / 28'"></span>
                    </span>
                    <span class="text-[10px] sm:text-[11px] text-[#5C656C] dark:text-[#94A3B8]">
                        {{ app()->getLocale() === 'bn' ? 'সব হরফ শুনলে ২৮টি স্টার পাবে! 🏆' : 'Listen to all letters to earn 28 stars! 🏆' }}
                    </span>
                </div>
            </div>

            <!-- Big Tactile 28 Alphabet Cards for Kids -->
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2.5 sm:gap-4">
                @foreach ($letters as $l)
                    <button @click="tapLetter({{ json_encode([
                        'order' => $l->order,
                        'character' => $l->character,
                        'name_latin' => $l->name_latin,
                        'name_ar' => $l->name_ar,
                        'name_bn' => $l->name_bn,
                        'audio_url' => $l->audio_url,
                    ]) }})" 
                            type="button" 
                            class="group relative rounded-3xl p-3 sm:p-5 flex flex-col items-center justify-between border-2 transition-all duration-200 cursor-pointer select-none active:scale-90 hover:shadow-md"
                            :class="selectedLetterChar === '{{ $l->character }}' 
                                ? 'bg-amber-50 dark:bg-amber-950/30 border-amber-400 dark:border-amber-500 ring-2 ring-amber-300/40 shadow-sm' 
                                : 'bg-white dark:bg-[#131926] border-[#EBE6DE] dark:border-[#212B3E] hover:border-emerald-400'">
                        
                        <!-- Top Order & Star Badge -->
                        <div class="w-full flex items-center justify-between text-[10px]">
                            <span class="font-mono font-bold text-[#687076] dark:text-[#94A3B8]">#{{ $l->order }}</span>
                            <span x-show="playedLetters.has({{ $l->order }})" class="text-amber-500 text-xs">⭐</span>
                        </div>

                        <!-- Massive Arabic Character -->
                        <div class="my-2 group-hover:scale-110 group-active:scale-95 transition-transform">
                            <span class="font-arabic text-5xl sm:text-6xl text-[#1A1D20] dark:text-white leading-tight">
                                {{ $l->character }}
                            </span>
                        </div>

                        <!-- Names in Bengali & Latin -->
                        <div class="text-center w-full mt-1">
                            <div class="text-xs font-bold text-[#1A1D20] dark:text-white">
                                {{ app()->getLocale() === 'bn' && $l->name_bn ? $l->name_bn : $l->name_latin }}
                            </div>
                            <div class="text-[11px] font-arabic text-[#1B4D3E] dark:text-emerald-400">{{ $l->name_ar }}</div>
                        </div>

                        <!-- Touch to Listen Hint Badge -->
                        <div class="mt-2 text-[10px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                            <span>🔊</span>
                            <span>{{ __('Listen') }}</span>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- 28 Letters View -->
        <div x-show="activeTab === 'letters'" class="space-y-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3">
                @foreach ($letters as $l)
                    <div class="group relative rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-4 flex flex-col items-center justify-between hover:border-[#1B4D3E]/50 dark:hover:border-emerald-500/50 hover:shadow-xs transition-all duration-150 select-none">
                        <!-- Order Number (links to details) -->
                        <div class="w-full flex items-center justify-between">
                            <span class="text-[10px] font-mono text-[#687076] dark:text-[#94A3B8]">#{{ $l->order }}</span>
                            <a href="{{ route('alphabet.show', $l->order) }}" title="{{ __('View Details & Positional Forms') }}" class="text-[10px] text-[#687076] dark:text-[#94A3B8] hover:text-[#1B4D3E] dark:hover:text-emerald-400">
                                ↗
                            </a>
                        </div>

                        <!-- Letter Character (Clicking plays letter pronunciation audio) -->
                        <button @click="playAudio('{{ $l->audio_url }}', '{{ $l->name_ar }}')" type="button" class="my-2 flex flex-col items-center group-hover:scale-110 active:scale-95 transition-transform cursor-pointer focus:outline-hidden" title="{{ __('Click to listen') }}: {{ $l->name_ar }}">
                            <span class="font-arabic text-4xl text-[#1A1D20] dark:text-white leading-none">
                                {{ $l->character }}
                            </span>
                        </button>

                        <!-- Names (Clicking also plays audio) -->
                        <button @click="playAudio('{{ $l->audio_url }}', '{{ $l->name_ar }}')" type="button" class="text-center w-full mt-1 cursor-pointer focus:outline-hidden">
                            <div class="text-xs font-semibold text-[#1A1D20] dark:text-white">
                                {{ app()->getLocale() === 'bn' && $l->name_bn ? $l->name_bn : $l->name_latin }}
                            </div>
                            <div class="text-[11px] font-arabic text-[#687076] dark:text-[#94A3B8]">{{ $l->name_ar }}</div>
                        </button>

                        <!-- Actions: Prominent Audio Button and Details Link -->
                        <div class="w-full mt-3 pt-2 border-t border-[#EBE6DE]/60 dark:border-[#212B3E]/60 flex items-center justify-between">
                            <button @click="playAudio('{{ $l->audio_url }}', '{{ $l->name_ar }}')" type="button" title="{{ __('Listen Pronunciation') }}" class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[#687076] dark:text-[#94A3B8] hover:text-[#1B4D3E] dark:hover:text-emerald-400 hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] active:scale-90 transition-all cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
                                </svg>
                                <span class="text-[10px] font-medium hidden sm:inline">{{ __('Play') }}</span>
                            </button>
                            <a href="{{ route('alphabet.show', $l->order) }}" title="{{ __('Positional Forms') }}" class="text-[10px] font-medium text-[#1B4D3E] dark:text-emerald-400 hover:underline">
                                {{ app()->getLocale() === 'bn' ? '৪টি রূপ' : '4 Forms' }} &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Harakat View -->
        <div x-show="activeTab === 'harakat'" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($harakats as $h)
                    <div class="rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-6 space-y-4 hover:border-[#1B4D3E]/40 dark:hover:border-emerald-500/40 transition-colors shadow-xs">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3.5">
                                <!-- Canonical Diacritic Carrier Tile (Using Tatweel carrier for authentic font rendering) -->
                                <button @click="playAudio('{{ $h->audio_url }}', '{{ $h->name_ar }}')" type="button" class="w-16 h-16 rounded-2xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] flex items-center justify-center font-arabic text-4xl text-[#9A722C] dark:text-amber-400 select-none shadow-xs hover:scale-105 active:scale-95 transition-transform cursor-pointer" title="{{ __('Click to listen') }}: {{ $h->name_ar }}">
                                    <span class="leading-none">&#x0640;{{ $h->symbol }}&#x0640;</span>
                                </button>
                                <div>
                                    <h3 class="text-base font-semibold text-[#1A1D20] dark:text-white">
                                        {{ app()->getLocale() === 'bn' && $h->name_bn ? $h->name_bn : $h->name }}
                                    </h3>
                                    <div class="text-sm font-arabic text-[#1B4D3E] dark:text-emerald-400">{{ $h->name_ar }}</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button @click="playAudio('{{ $h->audio_url }}', '{{ $h->name_ar }}')" type="button" class="p-2 rounded-xl text-[#687076] dark:text-[#94A3B8] hover:text-[#1B4D3E] dark:hover:text-emerald-400 hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] border border-transparent hover:border-[#EBE6DE] dark:hover:border-[#212B3E] transition-colors cursor-pointer" title="{{ __('Listen') }}">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
                                    </svg>
                                </button>
                                <span class="text-xs px-2.5 py-1 rounded-full bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] text-[#687076] dark:text-[#94A3B8] font-mono">
                                    #{{ $h->order }}
                                </span>
                            </div>
                        </div>

                        <p class="text-sm text-[#687076] dark:text-[#94A3B8] leading-relaxed">
                            {{ app()->getLocale() === 'bn' && $h->description_bn ? $h->description_bn : $h->description }}
                        </p>

                        <!-- Pronunciation Sample on Letter Baa -->
                        <div class="p-3.5 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] flex items-center justify-between">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-[11px] text-[#687076] dark:text-[#94A3B8] font-medium uppercase tracking-wider">
                                    {{ app()->getLocale() === 'bn' ? 'ধ্বনি প্রভাব' : 'Sound Effect' }}
                                </span>
                                <span class="text-xs font-semibold text-[#1A1D20] dark:text-white">
                                    {{ app()->getLocale() === 'bn' && $h->sound_bn ? $h->sound_bn : $h->sound }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 pl-3 border-l border-[#EBE6DE] dark:border-[#212B3E]">
                                <span class="text-[10px] text-[#687076] dark:text-[#94A3B8] hidden sm:inline">
                                    {{ app()->getLocale() === 'bn' ? 'বা দিয়ে উদাহরণ:' : 'Example on Bā:' }}
                                </span>
                                <span class="font-arabic text-3xl text-[#1B4D3E] dark:text-emerald-400 font-bold">
                                    ب{{ $h->symbol }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
