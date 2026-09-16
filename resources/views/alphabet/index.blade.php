<x-layouts.app>
    <x-slot:title>Arabic Alphabet & Harakat — Quranic Arabic</x-slot:title>

    <div x-data="{ activeTab: '{{ request('tab', 'letters') }}' }" class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-[#EBE6DE] dark:border-[#212B3E] pb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-[#1A1D20] dark:text-white">
                    {{ __('Arabic Foundations') }}
                </h1>
                <p class="text-sm text-[#687076] dark:text-[#94A3B8] mt-1">
                    {{ app()->getLocale() === 'bn' ? '২৮টি আরবি হরফ, বিশুদ্ধ মাখরাজ এবং হরকতসমূহ শিখুন।' : 'Master the 28 consonants, articulation points, and the vowelling system.' }}
                </p>
            </div>

            <!-- Tab Switcher -->
            <div class="flex items-center p-1 rounded-xl bg-[#EAE5DB]/60 dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] self-start sm:self-auto">
                <button @click="activeTab = 'letters'" :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-semibold': activeTab === 'letters', 'text-[#687076] dark:text-[#94A3B8]': activeTab !== 'letters' }" class="px-4 py-1.5 rounded-lg text-xs transition-all duration-150">
                    {{ app()->getLocale() === 'bn' ? '২৮টি হরফ' : '28 Letters' }}
                </button>
                <button @click="activeTab = 'harakat'" :class="{ 'bg-white dark:bg-[#1B2332] text-[#1A1D20] dark:text-white shadow-xs font-semibold': activeTab === 'harakat', 'text-[#687076] dark:text-[#94A3B8]': activeTab !== 'harakat' }" class="px-4 py-1.5 rounded-lg text-xs transition-all duration-150">
                    {{ app()->getLocale() === 'bn' ? 'হরকত (স্বরচিহ্ন)' : 'Harakat (Vowels)' }}
                </button>
            </div>
        </div>

        <!-- 28 Letters View -->
        <div x-show="activeTab === 'letters'" class="space-y-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3">
                @foreach ($letters as $l)
                    <div class="group relative rounded-2xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-4 flex flex-col items-center justify-between hover:border-[#1B4D3E]/50 dark:hover:border-emerald-500/50 hover:shadow-xs transition-all duration-150">
                        <!-- Order Number -->
                        <span class="self-start text-[10px] font-mono text-[#687076] dark:text-[#94A3B8]">#{{ $l->order }}</span>

                        <!-- Letter Character -->
                        <a href="{{ route('alphabet.show', $l->order) }}" class="my-2 flex flex-col items-center group-hover:scale-110 transition-transform">
                            <span class="font-arabic text-4xl text-[#1A1D20] dark:text-white leading-none">
                                {{ $l->character }}
                            </span>
                        </a>

                        <!-- Names -->
                        <div class="text-center w-full mt-1">
                            <div class="text-xs font-semibold text-[#1A1D20] dark:text-white">
                                {{ app()->getLocale() === 'bn' && $l->name_bn ? $l->name_bn : $l->name_latin }}
                            </div>
                            <div class="text-[11px] font-arabic text-[#687076] dark:text-[#94A3B8]">{{ $l->name_ar }}</div>
                        </div>

                        <!-- Actions: Audio and Details -->
                        <div class="w-full mt-3 pt-2 border-t border-[#EBE6DE]/60 dark:border-[#212B3E]/60 flex items-center justify-between">
                            <button @click="playAudio('{{ $l->audio_url }}')" type="button" title="{{ __('Listen') }}" class="p-1 rounded-md text-[#687076] dark:text-[#94A3B8] hover:text-[#1B4D3E] dark:hover:text-emerald-400 hover:bg-[#FAF8F5] dark:hover:bg-[#0B0F19] transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
                                </svg>
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
                                <!-- Canonical Diacritic Carrier Tile -->
                                <div class="w-16 h-16 rounded-2xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] flex items-center justify-center font-arabic text-4xl text-[#9A722C] dark:text-amber-400 select-none shadow-xs">
                                    <span class="leading-none">&#x25CC;{{ $h->symbol }}</span>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-[#1A1D20] dark:text-white">
                                        {{ app()->getLocale() === 'bn' && $h->name_bn ? $h->name_bn : $h->name }}
                                    </h3>
                                    <div class="text-sm font-arabic text-[#1B4D3E] dark:text-emerald-400">{{ $h->name_ar }}</div>
                                </div>
                            </div>
                            <span class="text-xs px-2.5 py-1 rounded-full bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] text-[#687076] dark:text-[#94A3B8] font-mono">
                                #{{ $h->order }}
                            </span>
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
