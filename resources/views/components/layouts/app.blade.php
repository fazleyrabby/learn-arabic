<!DOCTYPE html>
<html lang="en" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark',
    arabicFont: localStorage.getItem('arabicFont') || 'amiri',
    fontMenuOpen: false,
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
    playAudio(url) {
        if (!url) return;
        if (this.audioPlayer) {
            this.audioPlayer.pause();
            this.audioPlayer.currentTime = 0;
            if (this.playingUrl === url && this.isPlaying) {
                this.isPlaying = false;
                this.playingUrl = null;
                return;
            }
        }
        this.playingUrl = url;
        this.isPlaying = true;
        this.audioPlayer = new Audio(url);
        this.audioPlayer.play().catch(e => {
            console.log('Audio playback prevented', e);
            this.isPlaying = false;
            this.playingUrl = null;
        });
        this.audioPlayer.onended = () => {
            this.isPlaying = false;
            this.playingUrl = null;
        };
        this.audioPlayer.onerror = () => {
            this.isPlaying = false;
            this.playingUrl = null;
        };
    }
}" 
:class="{ 'dark': darkMode }" 
:data-arabic-font="arabicFont"
class="h-full scroll-smooth"
@keydown.window.m.prevent="toggleTheme()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Quranic Arabic — Direct Path to Understanding the Holy Quran' }}</title>
    
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
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 group">
                <div class="w-9 h-9 rounded-xl bg-[#1B4D3E] text-[#FAF8F5] flex items-center justify-center font-arabic text-xl font-bold shadow-xs group-hover:scale-105 transition-transform duration-150">
                    ق
                </div>
                <div class="flex flex-col">
                    <span class="font-display font-semibold text-sm tracking-wide text-[#181C1E] dark:text-white">QURANIC ARABIC</span>
                    <span class="text-[11px] font-arabic text-[#5C656C] dark:text-[#94A3B8] font-normal tracking-wide">الْعَرَبِيَّةُ لِلْقُرْآن</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-1.5 text-xs font-medium">
                <a href="{{ route('dashboard') }}" class="px-3.5 py-2 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    Path
                </a>
                <a href="{{ route('alphabet.index') }}" class="px-3.5 py-2 rounded-xl {{ request()->routeIs('alphabet.*') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    Alphabet & Harakat
                </a>
                <a href="{{ route('reading.index') }}" class="px-3.5 py-2 rounded-xl {{ request()->routeIs('reading.*') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    Reading Studio
                </a>
                <a href="{{ route('vocabulary.index') }}" class="px-3.5 py-2 rounded-xl {{ request()->routeIs('vocabulary.*') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    Vocabulary
                </a>
                <a href="{{ route('quran.fatihah') }}" class="px-3.5 py-2 rounded-xl {{ request()->routeIs('quran.*') ? 'bg-[#EAE4D9]/70 dark:bg-[#141C2B] text-[#181C1E] dark:text-white font-semibold' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors">
                    Surah Al-Fatihah
                </a>
                <a href="{{ route('review.index') }}" class="px-3.5 py-2 rounded-xl {{ request()->routeIs('review.*') ? 'bg-[#1B4D3E]/10 dark:bg-emerald-950/40 text-[#1B4D3E] dark:text-emerald-400 font-semibold border border-[#1B4D3E]/20 dark:border-emerald-500/30' : 'text-[#5C656C] dark:text-[#94A3B8] hover:text-[#181C1E] dark:hover:text-white hover:bg-[#EAE4D9]/40 dark:hover:bg-[#141C2B]/60' }} transition-colors flex items-center gap-2">
                    <span>Daily Review</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#1B4D3E] dark:bg-emerald-400"></span>
                </a>
            </nav>

            <!-- Actions: Arabic Font Dropdown Selector & Theme Toggle -->
            <div class="flex items-center gap-2">
                <!-- Arabic Font Selector Dropdown -->
                <div class="relative" @click.outside="fontMenuOpen = false">
                    <button @click="fontMenuOpen = !fontMenuOpen" type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-[#E8E2D8] dark:border-[#1E2738] bg-white/70 dark:bg-[#111723]/70 hover:bg-[#EAE4D9]/50 dark:hover:bg-[#141C2B] text-xs font-medium text-[#181C1E] dark:text-white transition-colors">
                        <span class="font-arabic text-sm text-[#1B4D3E] dark:text-emerald-400">خط</span>
                        <span class="hidden sm:inline" x-text="arabicFont === 'amiri' ? 'Amiri' : (arabicFont === 'scheherazade' ? 'Scheherazade' : (arabicFont === 'noto' ? 'Noto Naskh' : 'Lateef'))"></span>
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
                            Select Quranic Font
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
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{ $slot }}
    </main>

    <!-- Reverent Scholarly Footer -->
    <footer class="mt-auto border-t border-[#E8E2D8] dark:border-[#1E2738] py-10 text-xs text-[#5C656C] dark:text-[#94A3B8]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="font-display font-semibold tracking-wider text-[#181C1E] dark:text-white">QURANIC ARABIC</span>
                <span>•</span>
                <a href="{{ route('references') }}" class="hover:text-[#181C1E] dark:hover:text-white transition-colors underline underline-offset-4">
                    Data Sources & Verification
                </a>
            </div>
            <div class="font-arabic text-base text-[#1B4D3E] dark:text-emerald-400 select-none">
                وَلَقَدْ يَسَّرْنَا الْقُرْآنَ لِلذِّكْرِ فَهَلْ مِن مُّدَّكِرٍ
            </div>
        </div>
    </footer>

</body>
</html>
