<x-layouts.app>
    <x-slot:title>{{ __('Holy Quran Studio') }} — {{ __('Word by Word & Recitation') }}</x-slot:title>

    <div x-data="{
        activeTab: '{{ $activeTab }}',
        search: '{{ $searchQuery }}',
        kidsList: {{ json_encode($kidsSurahNumbers) }},
        matches(surah) {
            if (this.activeTab === 'kids' && !this.kidsList.includes(surah.number)) {
                return false;
            }
            if (this.activeTab === 'juz_amma' && surah.number < 78) {
                return false;
            }
            if (!this.search.trim()) return true;
            const q = this.search.toLowerCase().trim();
            return surah.number.toString().includes(q) ||
                   (surah.name_latin && surah.name_latin.toLowerCase().includes(q)) ||
                   (surah.name_english && surah.name_english.toLowerCase().includes(q)) ||
                   (surah.name_bn && surah.name_bn.toLowerCase().includes(q)) ||
                   (surah.name_ar && surah.name_ar.includes(q));
        }
    }" class="space-y-8">

        <!-- Kid-Friendly Welcoming Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1B4D3E] via-[#164033] to-[#0E2921] p-5 sm:p-10 text-white shadow-lg">
            <div class="absolute -right-8 -bottom-10 opacity-10 text-8xl sm:text-9xl font-arabic pointer-events-none select-none">
                القرآن
            </div>
            
            <div class="max-w-2xl space-y-3 relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                    <span>⭐ {{ __('Fun & Easy for All Ages') }}</span>
                    <span>•</span>
                    <span>{{ app()->getLocale() === 'bn' ? '৫ বছর বয়সীদের জন্যও সহজ' : 'Kids Friendly & Accessible' }}</span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-bold tracking-tight text-white">
                    {{ app()->getLocale() === 'bn' ? 'পবিত্র কুরআন স্টুডিও' : 'The Holy Quran Studio' }}
                </h1>

                <p class="text-xs sm:text-base text-emerald-100/85 leading-relaxed">
                    {{ app()->getLocale() === 'bn' 
                        ? '১১৪টি সূরা বিশুদ্ধ তেলাওয়াতসহ শুনুন এবং প্রতিটি শব্দে স্পর্শ করে উচ্চারণ ও বাংলা অর্থ শিখুন।' 
                        : 'Explore all 114 Surahs with crystal-clear recitation. Tap any word to hear exact pronunciation and learn its meaning.' }}
                </p>

                <!-- Quick Action Buttons -->
                <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3">
                    <a href="{{ route('quran.show', 1) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-white text-[#1B4D3E] text-xs font-bold shadow-md hover:bg-emerald-50 active:scale-95 transition-all text-center">
                        <span>▶</span>
                        <span>{{ app()->getLocale() === 'bn' ? 'সূরা আল-ফাতিহা শুরু করুন' : 'Start with Surah Al-Fatihah' }}</span>
                    </a>
                    <a href="{{ route('quran.show', 112) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-950/60 border border-emerald-400/30 text-emerald-200 text-xs font-semibold hover:bg-emerald-900/60 active:scale-95 transition-all text-center">
                        <span>⭐</span>
                        <span>{{ app()->getLocale() === 'bn' ? 'সূরা আল-ইখলাস (৪ কুল)' : 'Surah Al-Ikhlas (4 Quls)' }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs & Search Controls -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 sm:gap-4 border-b border-[#E8E2D8] dark:border-[#1E2738] pb-4">
            <!-- Filter Pills -->
            <div class="flex items-center gap-1.5 p-1 rounded-2xl bg-[#EAE5DB]/70 dark:bg-[#131926] border border-[#E8E2D8] dark:border-[#212B3E] overflow-x-auto max-w-full">
                <button @click="activeTab = 'kids'" 
                        :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-bold': activeTab === 'kids', 'text-[#5C656C] dark:text-[#94A3B8]': activeTab !== 'kids' }"
                        class="px-3 sm:px-4 py-2 rounded-xl text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    ⭐ {{ app()->getLocale() === 'bn' ? 'ছোটদের প্রিয় সূরা (১১টি)' : 'Kids Favorites (11 Surahs)' }}
                </button>
                <button @click="activeTab = 'juz_amma'" 
                        :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-bold': activeTab === 'juz_amma', 'text-[#5C656C] dark:text-[#94A3B8]': activeTab !== 'juz_amma' }"
                        class="px-3 sm:px-4 py-2 rounded-xl text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    🌙 {{ app()->getLocale() === 'bn' ? 'পারা ৩০' : "Juz 'Amma (78-114)" }}
                </button>
                <button @click="activeTab = 'all'" 
                        :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-bold': activeTab === 'all', 'text-[#5C656C] dark:text-[#94A3B8]': activeTab !== 'all' }"
                        class="px-3 sm:px-4 py-2 rounded-xl text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    📖 {{ app()->getLocale() === 'bn' ? 'সকল ১১৪টি সূরা' : 'All 114 Surahs' }}
                </button>
            </div>

            <!-- Search Input -->
            <div class="relative w-full md:w-auto md:min-w-[300px]">
                <input type="text" 
                       x-model="search"
                       placeholder="{{ app()->getLocale() === 'bn' ? 'সূরার নাম বা নম্বর দিয়ে খুঁজুন...' : 'Search Surah by name or number...' }}"
                       class="w-full px-4 py-2.5 pl-10 rounded-2xl bg-white dark:bg-[#131926] border border-[#E8E2D8] dark:border-[#212B3E] text-xs text-[#181C1E] dark:text-white placeholder-[#5C656C] dark:placeholder-[#94A3B8] focus:outline-hidden focus:border-[#1B4D3E] dark:focus:border-emerald-500 shadow-xs">
                <svg class="w-4 h-4 text-[#5C656C] dark:text-[#94A3B8] absolute left-3.5 top-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
        </div>

        <!-- Surahs Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            @foreach ($surahs as $surah)
                <div x-show="matches({{ json_encode([
                    'number' => $surah->number,
                    'name_latin' => $surah->name_latin,
                    'name_english' => $surah->name_english,
                    'name_bn' => $surah->name_bn,
                    'name_ar' => $surah->name_ar,
                ]) }})"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="group relative rounded-3xl bg-white dark:bg-[#131926] border border-[#E8E2D8] dark:border-[#212B3E] p-4 sm:p-6 flex flex-col justify-between hover:border-[#1B4D3E]/50 dark:hover:border-emerald-500/50 hover:shadow-md transition-all duration-200">
                    
                    <div>
                        <!-- Header Row: Number Badge, Revelation, Arabic Calligraphy -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <span class="w-9 h-9 rounded-2xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#E8E2D8] dark:border-[#212B3E] text-xs font-mono font-bold flex items-center justify-center text-[#1B4D3E] dark:text-emerald-400 shadow-xs">
                                    {{ $surah->number }}
                                </span>
                                @if (in_array($surah->number, $kidsSurahNumbers, true))
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                        ⭐ {{ __('Kids Pick') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Arabic Surah Name -->
                            <div class="text-right">
                                <span class="font-arabic text-2xl sm:text-3xl text-[#181C1E] dark:text-white leading-tight block group-hover:text-[#1B4D3E] dark:group-hover:text-emerald-400 transition-colors">
                                    {{ $surah->name_ar }}
                                </span>
                            </div>
                        </div>

                        <!-- English & Bengali Names -->
                        <div class="mt-4 space-y-1">
                            <h2 class="text-base font-bold text-[#181C1E] dark:text-white tracking-tight flex items-center gap-1.5">
                                <span>{{ $surah->name_latin }}</span>
                                @if ($surah->name_english)
                                    <span class="text-xs font-normal text-[#5C656C] dark:text-[#94A3B8]">({{ $surah->name_english }})</span>
                                @endif
                            </h2>

                            @if ($surah->name_bn)
                                <div class="text-sm font-medium text-[#1B4D3E] dark:text-emerald-400">
                                    {{ $surah->name_bn }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Details & Action -->
                    <div class="mt-5 pt-3 border-t border-[#E8E2D8]/60 dark:border-[#212B3E]/60 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-[11px] text-[#5C656C] dark:text-[#94A3B8]">
                            <span>{{ $surah->revelation_type }}</span>
                            <span>•</span>
                            <span>{{ $surah->verse_count }} {{ app()->getLocale() === 'bn' ? 'আয়াত' : 'Verses' }}</span>
                        </div>

                        <a href="{{ route('quran.show', $surah->number) }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] hover:bg-[#1B4D3E] dark:hover:bg-emerald-600 text-[#1B4D3E] dark:text-emerald-400 hover:text-white dark:hover:text-white border border-[#E8E2D8] dark:border-[#212B3E] hover:border-transparent text-xs font-bold transition-all duration-150 active:scale-95 shadow-xs">
                            <span>{{ app()->getLocale() === 'bn' ? 'পড়ুন ও শুনুন' : 'Study & Listen' }}</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>
