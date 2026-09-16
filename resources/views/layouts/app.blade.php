<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    arabicFont: localStorage.getItem('arabicFont') || 'amiri',
    fontMenuOpen: false,
    mobileDrawerOpen: false,
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },
    setArabicFont(fontKey) {
        this.arabicFont = fontKey;
        localStorage.setItem('arabicFont', fontKey);
        this.fontMenuOpen = false;
    },
    playAudio(url, fallbackText = null) {
        window.playAudio(url, fallbackText);
    }
}" 
:class="{ 'dark': darkMode }" 
:data-arabic-font="arabicFont"
class="h-full scroll-smooth"
@keydown.window.m.prevent="toggleTheme()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('Quranic Arabic') . ' — ' . __('Direct Path to Understanding the Holy Quran') }}</title>

    <!-- Theme Flash Prevention -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <!-- Dignified Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cinzel:wght@500;600;700&family=Figtree:ital,wght@0,300..800;1,300..800&family=Lateef:wght@400;500;600;700&family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Scheherazade+New:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- High-reliability Audio System -->
    <script>
        window.playAudio = function(url, fallbackText = null) {
            if (!url && !fallbackText) return;

            // Stop any currently playing audio
            if (window._currentAudio) {
                try {
                    window._currentAudio.pause();
                    window._currentAudio.currentTime = 0;
                } catch(e) {}
            }

            if (url) {
                try {
                    const audio = new Audio(url);
                    window._currentAudio = audio;
                    const playPromise = audio.play();
                    if (playPromise !== undefined) {
                        playPromise.catch(err => {
                            console.warn('MP3 playback failed, using Arabic speech synthesis:', err);
                            if (fallbackText) {
                                window.speakArabic(fallbackText);
                            }
                        });
                    }
                    audio.onerror = function() {
                        console.warn('MP3 file error, using Arabic speech synthesis');
                        if (fallbackText) {
                            window.speakArabic(fallbackText);
                        }
                    };
                } catch (e) {
                    if (fallbackText) {
                        window.speakArabic(fallbackText);
                    }
                }
            } else if (fallbackText) {
                window.speakArabic(fallbackText);
            }
        };

        window.speakArabic = function(text, fallback) {
            if (!text) return;
            if (!('speechSynthesis' in window)) return;
            try {
                if (window.speechSynthesis.paused) {
                    window.speechSynthesis.resume();
                }
                window.speechSynthesis.cancel();
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'ar-SA';
                utterance.rate = 0.82;

                const voices = window.speechSynthesis.getVoices();
                const arVoice = voices.find(v => v.lang && (v.lang.startsWith('ar') || v.lang.includes('ar')));
                if (arVoice) {
                    utterance.voice = arVoice;
                }

                utterance.onerror = function() {
                    if (fallback) {
                        const fb = new SpeechSynthesisUtterance(fallback);
                        fb.rate = 0.85;
                        window.speechSynthesis.speak(fb);
                    }
                };

                window.speechSynthesis.speak(utterance);
            } catch(e) {
                console.warn('SpeechSynthesis error:', e);
            }
        };
    </script>
</head>
<body class="min-h-full font-sans antialiased transition-colors duration-200 bg-[#FAF8F5] text-[#181C1E] dark:bg-[#090D16] dark:text-[#F0F4F8] flex flex-col">
    
    <!-- Top Navigation -->
    <header class="sticky top-0 z-40 backdrop-blur-md bg-[#FAF8F5]/85 dark:bg-[#090D16]/85 border-b border-[#E8E2D8] dark:border-[#1E2738]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 sm:gap-3 group shrink-0 min-w-0">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#1B4D3E] text-[#FAF8F5] flex items-center justify-center font-arabic text-lg sm:text-xl font-bold shadow-xs group-hover:scale-105 transition-transform duration-150 shrink-0">
                    ق
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-display font-semibold text-xs sm:text-sm tracking-wide text-[#181C1E] dark:text-white truncate">QURANIC ARABIC</span>
                    <span class="text-[10px] sm:text-[11px] font-arabic text-[#5C656C] dark:text-[#94A3B8] font-normal tracking-wide hidden xs:inline truncate">الْعَرَبِيَّةُ لِلْقُرْآن</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center gap-1 text-xs font-medium">
                <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    {{ __('Path') }}
                </a>
                <a href="{{ route('alphabet.index') }}" class="px-3 py-2 rounded-xl {{ request()->routeIs('alphabet.*') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    {{ __('Alphabet') }}
                </a>
                <a href="{{ route('reading.index') }}" class="px-3 py-2 rounded-xl {{ request()->routeIs('reading.*') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    {{ __('Studio') }}
                </a>
                <a href="{{ route('vocabulary.index') }}" class="px-3 py-2 rounded-xl {{ request()->routeIs('vocabulary.*') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    {{ __('Vocabulary') }}
                </a>
                <a href="{{ route('quran.index') }}" class="px-3 py-2 rounded-xl {{ request()->routeIs('quran.*') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    {{ __('Quran Studio') }}
                </a>
                <a href="{{ route('references') }}" class="px-3 py-2 rounded-xl {{ request()->routeIs('references') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    {{ __('Sources') }}
                </a>
                <a href="{{ route('review.index') }}" class="px-3 py-2 rounded-xl {{ request()->routeIs('review.*') ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 text-[#1B4D3E] dark:text-emerald-400 font-semibold border border-[#1B4D3E]/20 dark:border-emerald-500/30' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors flex items-center gap-1.5">
                    <span>{{ __('Review') }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#1B4D3E] dark:bg-emerald-400"></span>
                </a>
            </nav>

            <!-- Actions: Language Switcher, Arabic Font, Theme, Mobile Hamburger -->
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                <!-- Language Switcher (English / Bengali) -->
                <div class="h-9 inline-flex items-center rounded-xl border border-[#E8E2D8] dark:border-[#1E2738] bg-white/70 dark:bg-[#111723]/70 p-0.5 text-xs font-medium shadow-2xs">
                    <a href="{{ route('locale.switch', 'en') }}" class="h-full px-2 sm:px-2.5 rounded-lg inline-flex items-center justify-center transition-colors {{ app()->getLocale() === 'en' ? 'bg-[#1B4D3E] text-white font-semibold shadow-2xs' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white' }}" title="Switch to English">
                        EN
                    </a>
                    <a href="{{ route('locale.switch', 'bn') }}" class="h-full px-2 sm:px-2.5 rounded-lg inline-flex items-center justify-center transition-colors {{ app()->getLocale() === 'bn' ? 'bg-[#1B4D3E] text-white font-semibold shadow-2xs' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white' }}" title="বাংলা ভাষায় পরিবর্তন করুন">
                        বাং
                    </a>
                </div>

                <!-- Arabic Font Selector Dropdown -->
                <div class="relative" @click.outside="fontMenuOpen = false">
                    <button @click="fontMenuOpen = !fontMenuOpen" type="button" class="h-9 inline-flex items-center gap-1.5 px-2.5 rounded-xl border border-[#E8E2D8] dark:border-[#1E2738] bg-white/70 dark:bg-[#111723]/70 hover:bg-[#EAE4D9]/50 dark:hover:bg-[#141C2B] text-xs font-medium text-[#181C1E] dark:text-white transition-colors cursor-pointer shadow-2xs" title="{{ __('Select Quranic Font') }}">
                        <span class="font-arabic text-sm text-[#1B4D3E] dark:text-emerald-400 leading-none">خط</span>
                        <span class="hidden md:inline text-xs" x-text="arabicFont === 'amiri' ? 'Amiri' : (arabicFont === 'scheherazade' ? 'Scheherazade' : (arabicFont === 'noto' ? 'Noto Naskh' : 'Lateef'))"></span>
                        <svg class="w-3 h-3 text-[#5C656C] dark:text-[#94A3B8]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="fontMenuOpen" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 rounded-2xl bg-white dark:bg-[#111723] border border-[#E8E2D8] dark:border-[#1E2738] shadow-lg p-1.5 z-50 space-y-1"
                         style="display: none;">
                        <div class="px-3 py-1.5 text-[10px] font-semibold uppercase tracking-wider text-[#5C656C] dark:text-[#94A3B8]">
                            {{ __('Select Quranic Font') }}
                        </div>

                        <!-- Option: Amiri -->
                        <button @click="setArabicFont('amiri')" type="button" class="w-full px-3 py-2 rounded-xl flex items-center justify-between text-xs hover:bg-[#FAF8F5] dark:hover:bg-[#182030] transition-colors" :class="{ 'bg-[#FAF8F5] dark:bg-[#182030] font-semibold text-[#1B4D3E] dark:text-emerald-400': arabicFont === 'amiri' }">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full" :class="arabicFont === 'amiri' ? 'bg-[#1B4D3E] dark:bg-emerald-400' : 'bg-transparent'"></span>
                                <span>Amiri (Classical)</span>
                            </div>
                            <span class="text-base text-[#181C1E] dark:text-white" style="font-family: 'Amiri', serif;">بِسْمِ اللَّهِ</span>
                        </button>

                        <!-- Option: Scheherazade New -->
                        <button @click="setArabicFont('scheherazade')" type="button" class="w-full px-3 py-2 rounded-xl flex items-center justify-between text-xs hover:bg-[#FAF8F5] dark:hover:bg-[#182030] transition-colors" :class="{ 'bg-[#FAF8F5] dark:bg-[#182030] font-semibold text-[#1B4D3E] dark:text-emerald-400': arabicFont === 'scheherazade' }">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full" :class="arabicFont === 'scheherazade' ? 'bg-[#1B4D3E] dark:bg-emerald-400' : 'bg-transparent'"></span>
                                <span>Scheherazade (Quranic)</span>
                            </div>
                            <span class="text-base text-[#181C1E] dark:text-white" style="font-family: 'Scheherazade New', serif;">بِسْمِ اللَّهِ</span>
                        </button>

                        <!-- Option: Noto Naskh -->
                        <button @click="setArabicFont('noto')" type="button" class="w-full px-3 py-2 rounded-xl flex items-center justify-between text-xs hover:bg-[#FAF8F5] dark:hover:bg-[#182030] transition-colors" :class="{ 'bg-[#FAF8F5] dark:bg-[#182030] font-semibold text-[#1B4D3E] dark:text-emerald-400': arabicFont === 'noto' }">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full" :class="arabicFont === 'noto' ? 'bg-[#1B4D3E] dark:bg-emerald-400' : 'bg-transparent'"></span>
                                <span>Noto Naskh (Modern)</span>
                            </div>
                            <span class="text-base text-[#181C1E] dark:text-white" style="font-family: 'Noto Naskh Arabic', serif;">بِسْمِ اللَّهِ</span>
                        </button>

                        <!-- Option: Lateef -->
                        <button @click="setArabicFont('lateef')" type="button" class="w-full px-3 py-2 rounded-xl flex items-center justify-between text-xs hover:bg-[#FAF8F5] dark:hover:bg-[#182030] transition-colors" :class="{ 'bg-[#FAF8F5] dark:bg-[#182030] font-semibold text-[#1B4D3E] dark:text-emerald-400': arabicFont === 'lateef' }">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full" :class="arabicFont === 'lateef' ? 'bg-[#1B4D3E] dark:bg-emerald-400' : 'bg-transparent'"></span>
                                <span>Lateef (Calligraphic)</span>
                            </div>
                            <span class="text-base text-[#181C1E] dark:text-white" style="font-family: 'Lateef', serif;">بِسْمِ اللَّهِ</span>
                        </button>
                    </div>
                </div>

                <!-- Theme Toggle -->
                <button @click="toggleTheme()" type="button" title="Toggle Theme (shortcut: 'm')" class="w-9 h-9 flex items-center justify-center rounded-xl border border-[#E8E2D8] dark:border-[#1E2738] bg-white/70 dark:bg-[#111723]/70 text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/50 dark:hover:bg-[#141C2B] transition-colors cursor-pointer shadow-2xs">
                    <svg x-show="darkMode" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                    <svg x-show="!darkMode" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileDrawerOpen = true" type="button" class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl border border-[#E8E2D8] dark:border-[#1E2738] bg-white/70 dark:bg-[#111723]/70 text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/50 dark:hover:bg-[#141C2B] transition-colors cursor-pointer shadow-2xs" title="Open Navigation Drawer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Slide-over Drawer Backdrop -->
    <div x-show="mobileDrawerOpen" 
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 lg:hidden"
         @click="mobileDrawerOpen = false"
         style="display: none;">
    </div>

    <!-- Mobile Slide-over Drawer Panel -->
    <div x-show="mobileDrawerOpen" 
         x-transition:enter="transition ease-out duration-250 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         @keydown.window.escape="mobileDrawerOpen = false"
         class="fixed inset-y-0 right-0 max-w-[300px] sm:max-w-xs w-full bg-[#FAF8F5] dark:bg-[#0E1420] border-l border-[#E8E2D8] dark:border-[#1E2738] shadow-2xl z-50 p-5 sm:p-6 flex flex-col justify-between overflow-y-auto lg:hidden"
         style="display: none;">
        
        <div class="space-y-6">
            <!-- Drawer Header -->
            <div class="flex items-center justify-between pb-4 border-b border-[#E8E2D8] dark:border-[#1E2738]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-[#1B4D3E] text-white flex items-center justify-center font-arabic text-lg font-bold">
                        ق
                    </div>
                    <span class="font-display font-semibold text-sm text-[#181C1E] dark:text-white">{{ __('Quranic Arabic') }}</span>
                </div>
                <button @click="mobileDrawerOpen = false" type="button" class="p-2 rounded-xl text-[#5C656C] dark:text-[#94A3B8] hover:bg-[#EAE4D9]/60 dark:hover:bg-[#141C2B] transition-colors" title="Close Menu">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Language Switcher in Drawer -->
            <div class="space-y-2">
                <div class="text-xs font-semibold uppercase tracking-wider text-[#5C656C] dark:text-[#94A3B8]">
                    {{ __('Language') }}
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('locale.switch', 'en') }}" class="p-2.5 rounded-xl text-center border text-xs font-semibold transition-colors {{ app()->getLocale() === 'en' ? 'bg-[#1B4D3E] text-white border-[#1B4D3E]' : 'border-[#E8E2D8] dark:border-[#1E2738] text-[#181C1E] dark:text-gray-300 hover:bg-[#EAE4D9]/40' }}">
                        English
                    </a>
                    <a href="{{ route('locale.switch', 'bn') }}" class="p-2.5 rounded-xl text-center border text-xs font-semibold transition-colors {{ app()->getLocale() === 'bn' ? 'bg-[#1B4D3E] text-white border-[#1B4D3E]' : 'border-[#E8E2D8] dark:border-[#1E2738] text-[#181C1E] dark:text-gray-300 hover:bg-[#EAE4D9]/40' }}">
                        বাংলা
                    </a>
                </div>
            </div>

            <!-- Drawer Links -->
            <div class="space-y-1 text-sm font-medium">
                <a href="{{ route('dashboard') }}" @click="mobileDrawerOpen = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-200 hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-[#5C656C] dark:text-[#94A3B8]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>{{ __('Learning Path') }}</span>
                    </div>
                    <span class="text-xs text-[#5C656C] dark:text-[#94A3B8]">&rarr;</span>
                </a>

                <a href="{{ route('alphabet.index') }}" @click="mobileDrawerOpen = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ request()->routeIs('alphabet.*') ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-200 hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]' }}">
                    <div class="flex items-center gap-3">
                        <span class="font-arabic font-bold text-sm w-4 text-center text-[#1B4D3E] dark:text-emerald-400">أ</span>
                        <span>{{ __('Alphabet & Harakat') }}</span>
                    </div>
                    <span class="text-xs text-[#5C656C] dark:text-[#94A3B8]">28</span>
                </a>

                <a href="{{ route('reading.index') }}" @click="mobileDrawerOpen = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ request()->routeIs('reading.*') ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-200 hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-[#5C656C] dark:text-[#94A3B8]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        <span>{{ __('Reading Studio') }}</span>
                    </div>
                    <span class="text-xs text-[#5C656C] dark:text-[#94A3B8]">&rarr;</span>
                </a>

                <a href="{{ route('vocabulary.index') }}" @click="mobileDrawerOpen = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ request()->routeIs('vocabulary.*') ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-200 hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-[#5C656C] dark:text-[#94A3B8]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5m0 0-3.75-3.75m3.75 3.75 3.75-3.75M3.75 12h8.25" />
                        </svg>
                        <span>{{ __('Vocabulary') }}</span>
                    </div>
                    <span class="text-xs font-mono text-[#5C656C] dark:text-[#94A3B8]">100</span>
                </a>

                <a href="{{ route('quran.index') }}" @click="mobileDrawerOpen = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ request()->routeIs('quran.*') ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-200 hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]' }}">
                    <div class="flex items-center gap-3">
                        <span class="font-arabic text-sm text-[#9A722C] dark:text-amber-400">القرآن</span>
                        <span>{{ __('Quran Studio') }}</span>
                    </div>
                    <span class="text-xs text-[#5C656C] dark:text-[#94A3B8]">114</span>
                </a>

                <a href="{{ route('review.index') }}" @click="mobileDrawerOpen = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ request()->routeIs('review.*') ? 'bg-[#1B4D3E]/15 dark:bg-emerald-950/60 text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-200 hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-[#1B4D3E] dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                        </svg>
                        <span>{{ __('Daily Review') }}</span>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-[#1B4D3E] dark:bg-emerald-400"></span>
                </a>

                <a href="{{ route('references') }}" @click="mobileDrawerOpen = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ request()->routeIs('references') ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-200 hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-[#5C656C] dark:text-[#94A3B8]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>
                        <span>{{ __('Sources & Verification') }}</span>
                    </div>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Vetted</span>
                </a>
            </div>

            <!-- Calligraphy Font Switcher inside Drawer -->
            <div class="pt-4 border-t border-[#E8E2D8] dark:border-[#1E2738] space-y-2.5">
                <div class="text-xs font-semibold uppercase tracking-wider text-[#5C656C] dark:text-[#94A3B8]">
                    {{ __('Select Quranic Font') }}
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <button @click="setArabicFont('amiri')" type="button" class="p-2.5 rounded-xl text-left border border-[#E8E2D8] dark:border-[#1E2738] transition-colors" :class="arabicFont === 'amiri' ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 border-[#1B4D3E] text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-300 hover:bg-[#EAE4D9]/40'">
                        <div class="text-[11px]">Amiri</div>
                        <div class="font-arabic text-base" style="font-family: 'Amiri', serif;">الرَّحْمَٰنِ</div>
                    </button>
                    <button @click="setArabicFont('scheherazade')" type="button" class="p-2.5 rounded-xl text-left border border-[#E8E2D8] dark:border-[#1E2738] transition-colors" :class="arabicFont === 'scheherazade' ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 border-[#1B4D3E] text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-300 hover:bg-[#EAE4D9]/40'">
                        <div class="text-[11px]">Scheherazade</div>
                        <div class="font-arabic text-base" style="font-family: 'Scheherazade New', serif;">الرَّحْمَٰنِ</div>
                    </button>
                    <button @click="setArabicFont('noto')" type="button" class="p-2.5 rounded-xl text-left border border-[#E8E2D8] dark:border-[#1E2738] transition-colors" :class="arabicFont === 'noto' ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 border-[#1B4D3E] text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-300 hover:bg-[#EAE4D9]/40'">
                        <div class="text-[11px]">Noto Naskh</div>
                        <div class="font-arabic text-base" style="font-family: 'Noto Naskh Arabic', serif;">الرَّحْمَٰنِ</div>
                    </button>
                    <button @click="setArabicFont('lateef')" type="button" class="p-2.5 rounded-xl text-left border border-[#E8E2D8] dark:border-[#1E2738] transition-colors" :class="arabicFont === 'lateef' ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 border-[#1B4D3E] text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-300 hover:bg-[#EAE4D9]/40'">
                        <div class="text-[11px]">Lateef</div>
                        <div class="font-arabic text-base" style="font-family: 'Lateef', serif;">الرَّحْمَٰنِ</div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Drawer Bottom Actions -->
        <div class="pt-6 border-t border-[#E8E2D8] dark:border-[#1E2738] flex items-center justify-between">
            <button @click="toggleTheme()" type="button" class="flex items-center gap-2 text-xs font-medium text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white">
                <span x-show="darkMode">☀️ Light Theme</span>
                <span x-show="!darkMode">🌙 Dark Theme</span>
            </button>
            <span class="text-[11px] text-[#5C656C] dark:text-[#94A3B8]">v1.0 • Open Access</span>
        </div>
    </div>

    <!-- Main Content with Mobile Bottom Padding -->
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 pb-[calc(5.5rem+env(safe-area-inset-bottom,0px))] lg:pb-10">
        {{ $slot }}
    </main>

    <!-- Persistent Mobile Bottom Navigation Bar -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-[#FAF8F5]/95 dark:bg-[#090D16]/95 backdrop-blur-lg border-t border-[#E8E2D8] dark:border-[#1E2738] px-2 py-1.5 flex items-center justify-around shadow-lg" style="padding-bottom: max(0.5rem, env(safe-area-inset-bottom, 0px));">
        <!-- Path -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-0.5 px-2 py-1 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8]' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span class="text-[10px]">{{ __('Path') }}</span>
        </a>

        <!-- Alphabet -->
        <a href="{{ route('alphabet.index') }}" class="flex flex-col items-center gap-0.5 px-2 py-1 rounded-xl transition-colors {{ request()->routeIs('alphabet.*') ? 'text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8]' }}">
            <span class="font-arabic text-base font-bold leading-none h-5 flex items-center">أ</span>
            <span class="text-[10px]">{{ __('Alphabet') }}</span>
        </a>

        <!-- Quran Studio -->
        <a href="{{ route('quran.index') }}" class="flex flex-col items-center gap-0.5 px-2 py-1 rounded-xl transition-colors {{ request()->routeIs('quran.*') ? 'text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8]' }}">
            <span class="font-arabic text-sm font-bold leading-none h-5 flex items-center">القرآن</span>
            <span class="text-[10px]">{{ __('Quran') }}</span>
        </a>

        <!-- Vocabulary -->
        <a href="{{ route('vocabulary.index') }}" class="flex flex-col items-center gap-0.5 px-2 py-1 rounded-xl transition-colors {{ request()->routeIs('vocabulary.*') ? 'text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8]' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
            </svg>
            <span class="text-[10px]">{{ __('Vocab') }}</span>
        </a>

        <!-- More Drawer Trigger -->
        <button @click="mobileDrawerOpen = true" type="button" class="flex flex-col items-center gap-0.5 px-2 py-1 rounded-xl text-[#5C656C] dark:text-[#94A3B8] transition-colors" title="More Options">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <span class="text-[10px]">More</span>
        </button>
    </nav>

    <!-- Reverent Scholarly Footer with Made by Fazley & Support Modal -->
    <footer class="mt-auto border-t border-[#E8E2D8] dark:border-[#1E2738] py-8 pb-24 sm:pb-10 text-xs text-[#5C656C] dark:text-[#94A3B8]" x-data="{ supportModalOpen: false, copiedPayoneer: false }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-5">
            <!-- Brand & Credits -->
            <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 text-center sm:text-left">
                <div class="flex items-center gap-2.5">
                    <span class="font-display font-semibold tracking-wider text-[#181C1E] dark:text-white">QURANIC ARABIC</span>
                    <span>•</span>
                    <a href="{{ route('references') }}" class="hover:text-[#181C1E] dark:hover:text-white transition-colors underline underline-offset-4">
                        {{ __('Sources & Verification') }}
                    </a>
                </div>
                <span class="hidden sm:inline text-[#CCD2D9] dark:text-[#334155]">•</span>
                <div class="flex items-center gap-1.5 flex-wrap justify-center">
                    <span>Made by</span>
                    <a href="https://fazleyrabbi.xyz" target="_blank" rel="noopener noreferrer" class="font-semibold text-[#1B4D3E] dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
                        Fazley
                        <svg class="w-3 h-3 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                    <span class="text-[#7A8692] dark:text-[#64748B]">(<a href="https://fazleyrabbi.xyz" target="_blank" rel="noopener noreferrer" class="hover:underline text-[#5C656C] dark:text-[#94A3B8]">fazleyrabbi.xyz</a>)</span>
                </div>
            </div>

            <!-- Quranic Verse & Support Trigger -->
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-5">
                <div class="font-arabic text-base sm:text-lg text-[#1B4D3E] dark:text-emerald-400 select-none text-center" dir="rtl">
                    وَلَقَدْ يَسَّرْنَا الْقُرْآنَ لِلذِّكْرِ فَهَلْ مِن مُّدَّكِرٍ
                </div>

                <!-- Support Button (Only in footer, not sticky/floating) -->
                <button 
                    type="button"
                    @click="supportModalOpen = true"
                    class="cursor-pointer inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-medium bg-amber-500/10 hover:bg-amber-500/20 text-amber-700 dark:text-amber-300 border border-amber-500/30 hover:border-amber-500/50 shadow-xs hover:shadow-sm transition-all transform active:scale-95 shrink-0"
                    aria-label="Support the project"
                >
                    <svg class="w-3.5 h-3.5 text-amber-600 dark:text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 8h1a4 4 0 1 1 0 8h-1"/>
                        <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/>
                        <line x1="6" x2="6" y1="2" y2="4"/>
                        <line x1="10" x2="10" y1="2" y2="4"/>
                        <line x1="14" x2="14" y1="2" y2="4"/>
                    </svg>
                    <span>{{ __('Support me') }}</span>
                </button>
            </div>
        </div>

        <!-- Support Modal Backdrop & Dialog -->
        <template x-teleport="body">
            <div 
                x-show="supportModalOpen" 
                x-cloak
                @keydown.escape.window="supportModalOpen = false"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs transition-opacity duration-200"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                role="dialog"
                aria-modal="true"
                aria-labelledby="support-modal-title"
            >
                <!-- Modal Card -->
                <div 
                    @click.away="supportModalOpen = false"
                    class="relative w-full max-w-[500px] p-6 sm:p-7 rounded-3xl bg-[#0f0f11] text-white border border-white/10 shadow-2xl flex flex-col gap-5 font-sans max-h-[90vh] overflow-y-auto"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
                    <!-- Close Button -->
                    <button 
                        @click="supportModalOpen = false" 
                        type="button"
                        class="absolute top-5 right-5 p-1.5 rounded-lg text-white/50 hover:text-white hover:bg-white/10 transition-colors cursor-pointer"
                        aria-label="Close modal"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                        </svg>
                    </button>

                    <!-- Header -->
                    <div class="flex items-center gap-3.5 border-b border-white/10 pb-4 pr-6">
                        <div class="w-11 h-11 flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-[#FFDD00] shadow-sm shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 8h1a4 4 0 1 1 0 8h-1"/>
                                <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/>
                                <line x1="6" x2="6" y1="2" y2="4"/>
                                <line x1="10" x2="10" y1="2" y2="4"/>
                                <line x1="14" x2="14" y1="2" y2="4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 id="support-modal-title" class="text-lg font-bold text-white leading-tight">Support the Project</h2>
                            <p class="text-xs text-white/60 mt-0.5">Keep open source Islamic education free and accessible</p>
                        </div>
                    </div>

                    <!-- Support Options -->
                    <div class="flex flex-col gap-3.5">
                        <!-- Buy Me a Coffee (International) -->
                        <div class="rounded-2xl p-4 border border-[#FFDD00]/30 bg-gradient-to-b from-[#FFDD00]/10 to-transparent hover:border-[#FFDD00]/50 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#FFDD00] rounded-xl flex items-center justify-center shadow-md shadow-[#FFDD00]/20 shrink-0 text-black">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 8h1a4 4 0 1 1 0 8h-1"/>
                                            <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/>
                                            <line x1="6" x2="6" y1="2" y2="4"/>
                                            <line x1="10" x2="10" y1="2" y2="4"/>
                                            <line x1="14" x2="14" y1="2" y2="4"/>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-semibold text-sm text-white">Buy Me a Coffee</span>
                                            <span class="text-[10px] font-bold uppercase tracking-wider bg-[#FFDD00]/20 text-[#FFDD00] border border-[#FFDD00]/30 px-1.5 py-0.5 rounded-md">Global / Int'l</span>
                                        </div>
                                        <span class="text-xs text-white/60 mt-0.5">Card, Apple Pay, Google Pay ($)</span>
                                    </div>
                                </div>
                                <a 
                                    href="https://buymeacoffee.com/fazleyrabbi" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="bg-[#FFDD00] hover:bg-[#ffe633] text-black font-semibold text-xs px-3.5 py-2 rounded-xl flex items-center justify-center gap-1.5 transition-colors self-end sm:self-auto shrink-0 shadow-xs"
                                >
                                    Support $
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>

                        <!-- SupportKori (Bangladesh / bKash / Nagad) -->
                        <div class="rounded-2xl p-4 border border-[#10B981]/30 bg-gradient-to-b from-[#10B981]/10 to-transparent hover:border-[#10B981]/50 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#10B981] rounded-xl flex items-center justify-center shadow-md shadow-[#10B981]/20 shrink-0 text-black">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-semibold text-sm text-white">SupportKori</span>
                                            <span class="text-[10px] font-bold uppercase tracking-wider bg-[#10B981]/20 text-[#10B981] border border-[#10B981]/30 px-1.5 py-0.5 rounded-md">🇧🇩 bKash • Nagad</span>
                                        </div>
                                        <span class="text-xs text-white/60 mt-0.5">For Bangladesh users (BDT ৳)</span>
                                    </div>
                                </div>
                                <a 
                                    href="https://www.supportkori.com/fazleyrabbi" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="bg-[#10B981] hover:bg-[#34d399] text-black font-semibold text-xs px-3.5 py-2 rounded-xl flex items-center justify-center gap-1.5 transition-colors self-end sm:self-auto shrink-0 shadow-xs"
                                >
                                    Support ৳
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>

                        <!-- Direct Payoneer ($0 Fee) -->
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 flex flex-col gap-3">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-white/70 font-mono">Payoneer Customer ID:</span>
                                <span class="text-[#10B981] font-semibold text-[11px]">$0 Fee Direct</span>
                            </div>
                            
                            <div class="flex items-center justify-between bg-black/60 border border-white/10 rounded-xl p-1.5 pl-3">
                                <span class="text-[#FFDD00] font-mono font-semibold text-base tracking-wider">24076084</span>
                                <button 
                                    type="button"
                                    @click="navigator.clipboard.writeText('24076084'); copiedPayoneer = true; setTimeout(() => copiedPayoneer = false, 2000)"
                                    class="text-xs font-mono bg-white/10 hover:bg-white/20 text-white/90 px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition-colors cursor-pointer"
                                    :class="copiedPayoneer ? 'text-[#10B981] bg-[#10B981]/20' : ''"
                                >
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                                    <span x-text="copiedPayoneer ? 'Copied!' : 'Copy ID'">Copy ID</span>
                                </button>
                            </div>

                            <div class="text-[11px] text-white/50 leading-relaxed bg-white/5 rounded-lg p-2.5">
                                <span class="text-white/80">💡 In Payoneer App:</span> Go to <strong class="text-white/80 font-medium">Pay → Pay to recipient</strong> → Enter ID <span class="text-[#FFDD00] font-mono">24076084</span>.
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="border-t border-white/10 pt-3 text-center">
                        <p class="text-[11px] text-white/50 m-0">Thank you for your support! ✨ جَزَاكُمُ اللَّهُ خَيْرًا</p>
                    </div>
                </div>
            </div>
        </template>
    </footer>

</body>
</html>
