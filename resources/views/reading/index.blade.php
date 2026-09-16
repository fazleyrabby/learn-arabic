<x-layouts.app>
    <x-slot:title>Reading Practice — Quranic Arabic</x-slot:title>

    <div x-data="{
        levels: {{ json_encode($levels) }},
        activeTab: 'syllables',
        currentIndex: 0,
        revealed: false,
        get currentList() {
            return this.levels[this.activeTab].items;
        },
        get currentItem() {
            return this.currentList[this.currentIndex] || this.currentList[0];
        },
        nextItem() {
            this.revealed = false;
            this.currentIndex = (this.currentIndex + 1) % this.currentList.length;
        },
        prevItem() {
            this.revealed = false;
            this.currentIndex = (this.currentIndex - 1 + this.currentList.length) % this.currentList.length;
        },
        switchTab(tab) {
            this.activeTab = tab;
            this.currentIndex = 0;
            this.revealed = false;
        }
    }" class="space-y-10 max-w-3xl mx-auto">

        <!-- Header -->
        <div class="space-y-3 text-center">
            <h1 class="text-3xl font-semibold tracking-tight text-[#181C1E] dark:text-white">
                Reading Practice Studio
            </h1>
            <p class="text-sm text-[#5C656C] dark:text-[#94A3B8] max-w-lg mx-auto">
                Train your eye and ear to instantly blend Arabic letters with vowels and quiescent stops.
            </p>

            <!-- Level Selector -->
            <div class="inline-flex items-center p-1 rounded-2xl bg-[#EAE4D9]/60 dark:bg-[#111723] border border-[#E8E2D8] dark:border-[#1E2738] mt-3 max-w-full overflow-x-auto">
                <button @click="switchTab('syllables')" :class="{ 'bg-white dark:bg-[#182030] text-[#181C1E] dark:text-white shadow-xs font-semibold': activeTab === 'syllables', 'text-[#5C656C] dark:text-[#94A3B8]': activeTab !== 'syllables' }" class="px-3 sm:px-4 py-1.5 rounded-xl text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    1. Syllables
                </button>
                <button @click="switchTab('two_letters')" :class="{ 'bg-white dark:bg-[#182030] text-[#181C1E] dark:text-white shadow-xs font-semibold': activeTab === 'two_letters', 'text-[#5C656C] dark:text-[#94A3B8]': activeTab !== 'two_letters' }" class="px-3 sm:px-4 py-1.5 rounded-xl text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    2. Two-Letter Blends
                </button>
                <button @click="switchTab('three_letters')" :class="{ 'bg-white dark:bg-[#182030] text-[#181C1E] dark:text-white shadow-xs font-semibold': activeTab === 'three_letters', 'text-[#5C656C] dark:text-[#94A3B8]': activeTab !== 'three_letters' }" class="px-3 sm:px-4 py-1.5 rounded-xl text-xs whitespace-nowrap transition-all duration-150 cursor-pointer">
                    3. Trilateral Words
                </button>
            </div>
        </div>

        <!-- Interactive Practice Card -->
        <div class="rounded-3xl bg-white dark:bg-[#111723] border border-[#E8E2D8] dark:border-[#1E2738] p-5 sm:p-12 flex flex-col items-center justify-between min-h-[380px] sm:min-h-[420px] shadow-xs text-center relative overflow-hidden">
            <!-- Top Progress Indicator -->
            <div class="w-full flex items-center justify-between text-xs font-mono text-[#5C656C] dark:text-[#94A3B8]">
                <span x-text="levels[activeTab].title"></span>
                <span class="tabular-nums"><span x-text="currentIndex + 1"></span> / <span x-text="currentList.length"></span></span>
            </div>

            <!-- Target Arabic Word -->
            <div class="my-6 sm:my-8">
                <div class="font-arabic text-6xl sm:text-8xl md:text-9xl text-[#181C1E] dark:text-white leading-relaxed select-none transition-all duration-200" x-text="currentItem.text"></div>
            </div>

            <!-- Syllable Decomposition & Transliteration Reveal -->
            <div class="w-full max-w-md space-y-4">
                <div x-show="!revealed">
                    <button @click="revealed = true" type="button" class="w-full py-3 rounded-2xl bg-[#FAF8F5] dark:bg-[#090D16] border border-[#E8E2D8] dark:border-[#1E2738] text-xs font-semibold text-[#181C1E] dark:text-white hover:border-[#1B4D3E] dark:hover:border-emerald-500 transition-colors cursor-pointer">
                        Sound It Out (Check Pronunciation)
                    </button>
                </div>

                <div x-show="revealed" x-transition class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#090D16] border border-[#E8E2D8] dark:border-[#1E2738] space-y-2">
                    <template x-if="currentItem.breakdown">
                        <div class="flex items-center justify-center gap-2 text-sm font-arabic text-[#1B4D3E] dark:text-emerald-400 font-semibold">
                            <span>Syllable Breakdown:</span>
                            <span class="text-xl" x-text="currentItem.breakdown"></span>
                        </div>
                    </template>
                    <div class="text-sm sm:text-base font-semibold text-[#181C1E] dark:text-white tracking-wide">
                        Phonetic: <span class="font-mono text-[#1B4D3E] dark:text-emerald-400" x-text="currentItem.trans"></span>
                    </div>
                    <template x-if="currentItem.meaning">
                        <div class="text-xs text-[#5C656C] dark:text-[#94A3B8]">
                            Meaning: <span class="font-medium text-[#181C1E] dark:text-white" x-text="currentItem.meaning"></span>
                        </div>
                    </template>
                    <template x-if="currentItem.sound">
                        <div class="text-xs text-[#5C656C] dark:text-[#94A3B8]" x-text="currentItem.sound"></div>
                    </template>
                </div>
            </div>

            <!-- Navigation Controls -->
            <div class="w-full pt-6 mt-4 border-t border-[#E8E2D8]/60 dark:border-[#1E2738]/60 flex items-center justify-between gap-2">
                <button @click="prevItem()" type="button" class="px-3 sm:px-4 py-2 rounded-xl text-xs font-medium text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#FAF8F5] dark:hover:bg-[#090D16] transition-colors cursor-pointer">
                    &larr; Previous
                </button>
                <button @click="nextItem()" type="button" class="px-3.5 sm:px-5 py-2 rounded-xl bg-[#1B4D3E] dark:bg-emerald-600 text-white text-xs font-semibold hover:opacity-90 transition-opacity cursor-pointer">
                    Next Exercise &rarr;
                </button>
            </div>
        </div>
    </div>
</x-layouts.app>
