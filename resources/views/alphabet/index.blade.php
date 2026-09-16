<x-layouts.app>
    <x-slot:title>{{ __('Arabic Alphabet & Harakat') }} — {{ __('Quranic Arabic') }}</x-slot:title>

    <div x-data="{ 
        activeTab: '{{ request('tab', 'kids') }}',
        activeAudioUrl: null,
        playedLetters: new Set(),
        selectedLetterChar: 'ب',
        selectedLetterName: 'Bā’',
        selectedLetterBn: 'বা',
        selectedLetterAudio: null,
        mixHarakat(harakat, harakatName, soundEn, soundBn) {
            const letter = this.selectedLetterChar;
            const combined = letter + harakat;
            // Speak combined sound using Arabic speech synthesis
            window.speakArabic(combined);
        },
        tapLetter(l) {
            this.selectedLetterChar = l.character;
            this.selectedLetterName = l.name_latin;
            this.selectedLetterBn = l.name_bn || l.name_latin;
            this.selectedLetterAudio = l.audio_url;
            this.playedLetters.add(l.order);
            window.playAudio(l.audio_url, l.name_ar);
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
            <div class="flex items-center p-1 rounded-xl bg-[#EAE5DB]/60 dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] self-start sm:self-auto overflow-x-auto">
                <button @click="activeTab = 'kids'" :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-bold': activeTab === 'kids', 'text-[#687076] dark:text-[#94A3B8]': activeTab !== 'kids' }" class="px-4 py-1.5 rounded-lg text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    🎈 {{ app()->getLocale() === 'bn' ? 'শিশুদের সাউন্ডবোর্ড' : 'Kids Soundboard' }}
                </button>
                <button @click="activeTab = 'letters'" :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-semibold': activeTab === 'letters', 'text-[#687076] dark:text-[#94A3B8]': activeTab !== 'letters' }" class="px-4 py-1.5 rounded-lg text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    {{ app()->getLocale() === 'bn' ? '২৮টি হরফ ও মাখরাজ' : '28 Letters Table' }}
                </button>
                <button @click="activeTab = 'harakat'" :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-semibold': activeTab === 'harakat', 'text-[#687076] dark:text-[#94A3B8]': activeTab !== 'harakat' }" class="px-4 py-1.5 rounded-lg text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    {{ app()->getLocale() === 'bn' ? 'হরকত (স্বরচিহ্ন)' : 'Harakat (Vowels)' }}
                </button>
            </div>
        </div>

        <!-- KIDS SOUNDBOARD TAB (Delightful for 5-year-olds!) -->
        <div x-show="activeTab === 'kids'" class="space-y-8">
            <!-- Kids Interactive Harakat Mixer Station (Ba - Bi - Bu) -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-50 via-white to-emerald-50 dark:from-[#131926] dark:via-[#111723] dark:to-[#0B0F19] border-2 border-amber-300 dark:border-amber-700/60 p-6 sm:p-8 shadow-sm">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-2 text-center md:text-left">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-200/60 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300">
                            <span>🎵 {{ app()->getLocale() === 'bn' ? 'হরকত ম্যাজিক সাউন্ড (বা - বি - বু)' : 'Vowel Magic (Ba - Bi - Bu Sound Machine)' }}</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-[#181C1E] dark:text-white">
                            {{ app()->getLocale() === 'bn' ? 'হরকতের সাথে হরফ মিলিয়ে শুনুন' : 'Mix Letters with Vowels' }}
                        </h2>
                        <p class="text-xs text-[#5C656C] dark:text-[#94A3B8] max-w-md">
                            {{ app()->getLocale() === 'bn' ? 'যেকোনো হরফ নির্বাচন করে জবর (Fatḥah), জের (Kasrah) বা পেশ (Ḍammah) চাপুন।' : 'Select a letter below, then tap Fatḥah (A), Kasrah (I), or Ḍammah (U) to hear the exact sound!' }}
                        </p>
                    </div>

                    <!-- Active Letter Display + Harakat Action Buttons -->
                    <div class="flex items-center gap-3">
                        <!-- Big Selected Letter Tile -->
                        <div class="w-24 h-24 rounded-3xl bg-white dark:bg-[#1B2332] border-2 border-amber-400 dark:border-amber-500 flex flex-col items-center justify-center shadow-md select-none">
                            <span class="font-arabic text-5xl text-[#181C1E] dark:text-white leading-none" x-text="selectedLetterChar"></span>
                            <span class="text-[11px] font-bold text-[#1B4D3E] dark:text-emerald-400 mt-1" x-text="selectedLetterBn"></span>
                        </div>

                        <!-- 3 Big Tactile Harakat Buttons -->
                        <div class="flex flex-col sm:flex-row gap-2">
                            <!-- Fathah (A sound) -->
                            <button @click="mixHarakat('َ', 'Fatḥah', 'a', 'আ')" 
                                    type="button" 
                                    class="px-4 py-2.5 rounded-2xl bg-red-50 dark:bg-red-950/40 border-2 border-red-300 dark:border-red-700 hover:bg-red-100 hover:scale-105 active:scale-95 transition-all text-center cursor-pointer shadow-xs">
                                <div class="font-arabic text-2xl text-red-600 dark:text-red-400 leading-none">&#x0640;َ</div>
                                <div class="text-[11px] font-bold text-red-700 dark:text-red-300 mt-0.5">{{ app()->getLocale() === 'bn' ? 'জবর (আ)' : 'Fatḥah (A)' }}</div>
                            </button>

                            <!-- Kasrah (I sound) -->
                            <button @click="mixHarakat('ِ', 'Kasrah', 'i', 'ই')" 
                                    type="button" 
                                    class="px-4 py-2.5 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border-2 border-blue-300 dark:border-blue-700 hover:bg-blue-100 hover:scale-105 active:scale-95 transition-all text-center cursor-pointer shadow-xs">
                                <div class="font-arabic text-2xl text-blue-600 dark:text-blue-400 leading-none">&#x0640;ِ</div>
                                <div class="text-[11px] font-bold text-blue-700 dark:text-blue-300 mt-0.5">{{ app()->getLocale() === 'bn' ? 'জের (ই)' : 'Kasrah (I)' }}</div>
                            </button>

                            <!-- Dammah (U sound) -->
                            <button @click="mixHarakat('ُ', 'Ḍammah', 'u', 'উ')" 
                                    type="button" 
                                    class="px-4 py-2.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border-2 border-emerald-300 dark:border-emerald-700 hover:bg-emerald-100 hover:scale-105 active:scale-95 transition-all text-center cursor-pointer shadow-xs">
                                <div class="font-arabic text-2xl text-emerald-600 dark:text-emerald-400 leading-none">&#x0640;ُ</div>
                                <div class="text-[11px] font-bold text-emerald-700 dark:text-emerald-300 mt-0.5">{{ app()->getLocale() === 'bn' ? 'পেশ (উ)' : 'Ḍammah (U)' }}</div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Star Progress Counter for Kids -->
                <div class="mt-4 pt-3 border-t border-amber-200/60 dark:border-amber-900/60 flex items-center justify-between text-xs">
                    <span class="font-semibold text-amber-800 dark:text-amber-300 flex items-center gap-1">
                        <span>⭐ {{ app()->getLocale() === 'bn' ? 'তোমার সংগৃহীত স্টার:' : 'Your Collected Stars:' }}</span>
                        <span class="font-mono font-bold" x-text="playedLetters.size + ' / 28'"></span>
                    </span>
                    <span class="text-[11px] text-[#5C656C] dark:text-[#94A3B8]">
                        {{ app()->getLocale() === 'bn' ? 'সব হরফ শুনলে ২৮টি স্টার পাবে! 🏆' : 'Listen to all letters to earn 28 stars! 🏆' }}
                    </span>
                </div>
            </div>

            <!-- Big Tactile 28 Alphabet Cards for Kids -->
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3 sm:gap-4">
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
                            class="group relative rounded-3xl p-4 sm:p-5 flex flex-col items-center justify-between border-2 transition-all duration-200 cursor-pointer select-none active:scale-90 hover:shadow-md"
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
