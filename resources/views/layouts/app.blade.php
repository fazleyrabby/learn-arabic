<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark',
    arabicFont: localStorage.getItem('arabicFont') || 'amiri',
    fontMenuOpen: false,
    mobileDrawerOpen: false,
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
    },
    setArabicFont(fontKey) {
        this.arabicFont = fontKey;
        localStorage.setItem('arabicFont', fontKey);
        this.fontMenuOpen = false;
    },
    audioPlayer: null,
    playingUrl: null,
    isPlaying: false,
    playAudio(url, fallbackText = null) {
        if (!url && !fallbackText) return;
        if (this.audioPlayer) {
            this.audioPlayer.pause();
            this.audioPlayer.currentTime = 0;
            if (this.playingUrl === url && this.isPlaying) {
                this.isPlaying = false;
                this.playingUrl = null;
                return;
            }
        }
        if (url) {
            this.playingUrl = url;
            this.isPlaying = true;
            this.audioPlayer = new Audio(url);
            this.audioPlayer.play().catch(e => {
                console.log('Audio file failed, falling back to speech synthesis', e);
                this.isPlaying = false;
                this.playingUrl = null;
                if (fallbackText && 'speechSynthesis' in window) {
                    const u = new SpeechSynthesisUtterance(fallbackText);
                    u.lang = 'ar-SA';
                    window.speechSynthesis.speak(u);
                }
            });
            this.audioPlayer.onended = () => {
                this.isPlaying = false;
                this.playingUrl = null;
            };
            this.audioPlayer.onerror = () => {
                this.isPlaying = false;
                this.playingUrl = null;
                if (fallbackText && 'speechSynthesis' in window) {
                    const u = new SpeechSynthesisUtterance(fallbackText);
                    u.lang = 'ar-SA';
                    window.speechSynthesis.speak(u);
                }
            };
        } else if (fallbackText && 'speechSynthesis' in window) {
            const u = new SpeechSynthesisUtterance(fallbackText);
            u.lang = 'ar-SA';
            window.speechSynthesis.speak(u);
        }
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
    
    <!-- Dignified Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cinzel:wght@500;600;700&family=Figtree:ital,wght@0,300..800;1,300..800&family=Lateef:wght@400;500;600;700&family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Scheherazade+New:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-full font-sans antialiased transition-colors duration-200 bg-[#FAF8F5] text-[#181C1E] dark:bg-[#090D16] dark:text-[#F0F4F8] flex flex-col">
    
    <!-- Top Navigation -->
    <header class="sticky top-0 z-40 backdrop-blur-md bg-[#FAF8F5]/85 dark:bg-[#090D16]/85 border-b border-[#E8E2D8] dark:border-[#1E2738]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-[#1B4D3E] text-[#FAF8F5] flex items-center justify-center font-arabic text-xl font-bold shadow-xs group-hover:scale-105 transition-transform duration-150">
                    ق
                </div>
                <div class="flex flex-col">
                    <span class="font-display font-semibold text-sm tracking-wide text-[#181C1E] dark:text-white">QURANIC ARABIC</span>
                    <span class="text-[11px] font-arabic text-[#5C656C] dark:text-[#94A3B8] font-normal tracking-wide">الْعَرَبِيَّةُ لِلْقُرْآن</span>
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
                <a href="{{ route('quran.fatihah') }}" class="px-3 py-2 rounded-xl {{ request()->routeIs('quran.*') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    {{ __('Al-Fatihah') }}
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
            <div class="flex items-center gap-2">
                <!-- Language Switcher (English / Bengali) -->
                <div class="flex items-center rounded-xl border border-[#E8E2D8] dark:border-[#1E2738] bg-white/70 dark:bg-[#111723]/70 p-0.5 text-xs font-medium">
                    <a href="{{ route('locale.switch', 'en') }}" class="px-2 py-1 rounded-lg transition-colors {{ app()->getLocale() === 'en' ? 'bg-[#1B4D3E] text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white' }}" title="Switch to English">
                        EN
                    </a>
                    <a href="{{ route('locale.switch', 'bn') }}" class="px-2 py-1 rounded-lg transition-colors {{ app()->getLocale() === 'bn' ? 'bg-[#1B4D3E] text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white' }}" title="বাংলা ভাষায় পরিবর্তন করুন">
                        বাং
                    </a>
                </div>

                <!-- Arabic Font Selector Dropdown -->
                <div class="relative" @click.outside="fontMenuOpen = false">
                    <button @click="fontMenuOpen = !fontMenuOpen" type="button" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl border border-[#E8E2D8] dark:border-[#1E2738] bg-white/70 dark:bg-[#111723]/70 hover:bg-[#EAE4D9]/50 dark:hover:bg-[#141C2B] text-xs font-medium text-[#181C1E] dark:text-white transition-colors" title="{{ __('Select Quranic Font') }}">
                        <span class="font-arabic text-sm text-[#1B4D3E] dark:text-emerald-400">خط</span>
                        <span class="hidden sm:inline text-xs" x-text="arabicFont === 'amiri' ? 'Amiri' : (arabicFont === 'scheherazade' ? 'Scheherazade' : (arabicFont === 'noto' ? 'Noto Naskh' : 'Lateef'))"></span>
                        <svg class="w-3.5 h-3.5 text-[#5C656C] dark:text-[#94A3B8]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
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
                <button @click="toggleTheme()" type="button" title="Toggle Theme (shortcut: 'm')" class="p-2 rounded-xl text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/60 dark:hover:bg-[#141C2B] transition-colors border border-transparent hover:border-[#E8E2D8] dark:hover:border-[#1E2738]">
                    <svg x-show="darkMode" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                    <svg x-show="!darkMode" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileDrawerOpen = true" type="button" class="lg:hidden p-2 rounded-xl text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/60 dark:hover:bg-[#141C2B] transition-colors" title="Open Navigation Drawer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
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
         class="fixed inset-y-0 right-0 max-w-xs w-full bg-[#FAF8F5] dark:bg-[#0E1420] border-l border-[#E8E2D8] dark:border-[#1E2738] shadow-2xl z-50 p-6 flex flex-col justify-between overflow-y-auto lg:hidden"
         style="display: none;">
        
        <div class="space-y-6">
            <!-- Drawer Header -->
            <div class="flex items-center justify-between pb-4 border-b border-[#E8E2D8] dark:border-[#1E2738]">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-[#1B4D3E] text-white flex items-center justify-center font-arabic text-lg font-bold">
                        ق
                    </div>
                    <span class="font-display font-semibold text-sm text-[#181C1E] dark:text-white">{{ __('Quranic Arabic') }}</span>
                </div>
                <button @click="mobileDrawerOpen = false" type="button" class="p-2 rounded-xl text-[#5C656C] dark:text-[#94A3B8] hover:bg-[#EAE4D9]/60 dark:hover:bg-[#141C2B] transition-colors">
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

                <a href="{{ route('quran.fatihah') }}" @click="mobileDrawerOpen = false" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ request()->routeIs('quran.*') ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#181C1E] dark:text-gray-200 hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]' }}">
                    <div class="flex items-center gap-3">
                        <span class="font-arabic text-sm text-[#9A722C] dark:text-amber-400">الفاتحة</span>
                        <span>{{ __('Surah Al-Fatihah') }}</span>
                    </div>
                    <span class="text-xs text-[#5C656C] dark:text-[#94A3B8]">7</span>
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
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 pb-24 lg:pb-10">
        {{ $slot }}
    </main>

    <!-- Persistent Mobile Bottom Navigation Bar -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-[#FAF8F5]/95 dark:bg-[#090D16]/95 backdrop-blur-lg border-t border-[#E8E2D8] dark:border-[#1E2738] px-2 py-2 flex items-center justify-around shadow-lg">
        <!-- Path -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 px-2 py-1 rounded-xl {{ request()->routeIs('dashboard') ? 'text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8]' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span class="text-[10px]">{{ __('Path') }}</span>
        </a>

        <!-- Alphabet -->
        <a href="{{ route('alphabet.index') }}" class="flex flex-col items-center gap-1 px-2 py-1 rounded-xl {{ request()->routeIs('alphabet.*') ? 'text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8]' }}">
            <span class="font-arabic text-base font-bold leading-none h-5 flex items-center">أ</span>
            <span class="text-[10px]">{{ __('Alphabet') }}</span>
        </a>

        <!-- Reading Studio -->
        <a href="{{ route('reading.index') }}" class="flex flex-col items-center gap-1 px-2 py-1 rounded-xl {{ request()->routeIs('reading.*') ? 'text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8]' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
            <span class="text-[10px]">{{ __('Studio') }}</span>
        </a>

        <!-- Vocabulary -->
        <a href="{{ route('vocabulary.index') }}" class="flex flex-col items-center gap-1 px-2 py-1 rounded-xl {{ request()->routeIs('vocabulary.*') ? 'text-[#1B4D3E] dark:text-emerald-400 font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8]' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
            </svg>
            <span class="text-[10px]">{{ __('Vocab') }}</span>
        </a>

        <!-- More Drawer Trigger -->
        <button @click="mobileDrawerOpen = true" type="button" class="flex flex-col items-center gap-1 px-2 py-1 rounded-xl text-[#5C656C] dark:text-[#94A3B8]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <span class="text-[10px]">More</span>
        </button>
    </nav>

    <!-- Reverent Scholarly Footer (Hidden on mobile to keep clean thumb area) -->
    <footer class="mt-auto border-t border-[#E8E2D8] dark:border-[#1E2738] py-10 text-xs text-[#5C656C] dark:text-[#94A3B8] hidden sm:block">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="font-display font-semibold tracking-wider text-[#181C1E] dark:text-white">QURANIC ARABIC</span>
                <span>•</span>
                <a href="{{ route('references') }}" class="hover:text-[#181C1E] dark:hover:text-white transition-colors underline underline-offset-4">
                    {{ __('Sources & Verification') }}
                </a>
            </div>
            <div class="font-arabic text-base text-[#1B4D3E] dark:text-emerald-400 select-none">
                وَلَقَدْ يَسَّرْنَا الْقُرْآنَ لِلذِّكْرِ فَهَلْ مِن مُّدَّكِرٍ
            </div>
        </div>
    </footer>

</body>
</html>
