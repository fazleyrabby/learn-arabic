<x-layouts.app>
    <x-slot:title>Retention & Review (SRS) — Quranic Arabic</x-slot:title>

    <div x-data="{
        cards: {{ json_encode($cards) }},
        currentIndex: 0,
        revealed: false,
        submitting: false,
        completed: false,
        get currentCard() {
            return this.cards[this.currentIndex] || null;
        },
        reveal() {
            this.revealed = true;
        },
        async submitGrade(quality) {
            if (!this.currentCard || this.submitting) return;
            this.submitting = true;

            try {
                const response = await fetch('{{ route('review.submit') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        card_id: this.currentCard.id,
                        quality: quality
                    })
                });

                if (response.ok) {
                    this.currentIndex++;
                    this.revealed = false;
                    if (this.currentIndex >= this.cards.length) {
                        this.completed = true;
                    }
                }
            } catch (error) {
                console.error('Failed to submit review', error);
            } finally {
                this.submitting = false;
            }
        }
    }" class="space-y-8 max-w-2xl mx-auto">

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-[#EBE6DE] dark:border-[#212B3E] pb-4">
            <div>
                <h1 class="text-xl font-semibold text-[#1A1D20] dark:text-white">Daily Review Session</h1>
                <p class="text-xs text-[#687076] dark:text-[#94A3B8]">Spaced repetition for long-term retention</p>
            </div>
            <template x-if="!completed && cards.length > 0">
                <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-[#FAF8F5] dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] text-[#687076] dark:text-[#94A3B8]">
                    <span x-text="currentIndex + 1"></span> of <span x-text="cards.length"></span>
                </span>
            </template>
        </div>

        <!-- Active Flashcard State -->
        <template x-if="!completed && currentCard">
            <div class="space-y-6">
                <!-- Card Body -->
                <div class="min-h-[360px] rounded-3xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-8 flex flex-col items-center justify-between text-center shadow-xs transition-all">
                    <!-- Card Type Tag -->
                    <span class="text-[11px] font-medium tracking-wider uppercase text-[#687076] dark:text-[#94A3B8]" x-text="currentCard.sub"></span>

                    <!-- Prompt (Front) -->
                    <div class="my-6">
                        <div class="font-arabic text-7xl sm:text-8xl text-[#1A1D20] dark:text-white leading-relaxed select-none" x-text="currentCard.title"></div>
                    </div>

                    <!-- Answer (Back) -->
                    <div class="w-full">
                        <div x-show="!revealed">
                            <button @click="reveal()" type="button" class="w-full py-3 rounded-2xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] text-xs font-semibold text-[#1A1D20] dark:text-white hover:border-[#1B4D3E] dark:hover:border-emerald-500 transition-colors">
                                Show Answer
                            </button>
                        </div>

                        <div x-show="revealed" x-transition class="space-y-3 pt-4 border-t border-[#EBE6DE]/60 dark:border-[#212B3E]/60">
                            <div class="text-xl font-bold text-[#1B4D3E] dark:text-emerald-400" x-text="currentCard.answer"></div>
                            <div class="text-xs text-[#687076] dark:text-[#94A3B8]" x-text="currentCard.details"></div>
                        </div>
                    </div>
                </div>

                <!-- Grading Buttons (Only visible when answer is revealed) -->
                <div x-show="revealed" x-transition class="grid grid-cols-4 gap-2 pt-2">
                    <button @click="submitGrade(1)" :disabled="submitting" class="p-3 rounded-xl bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900/50 hover:bg-red-100 dark:hover:bg-red-900/50 text-center transition-colors">
                        <div class="text-xs font-bold text-red-700 dark:text-red-400">Again</div>
                        <div class="text-[10px] text-red-600/70 dark:text-red-400/70 mt-0.5">1 day</div>
                    </button>

                    <button @click="submitGrade(2)" :disabled="submitting" class="p-3 rounded-xl bg-orange-50 dark:bg-orange-950/30 border border-orange-200 dark:border-orange-900/50 hover:bg-orange-100 dark:hover:bg-orange-900/50 text-center transition-colors">
                        <div class="text-xs font-bold text-orange-700 dark:text-orange-400">Hard</div>
                        <div class="text-[10px] text-orange-600/70 dark:text-orange-400/70 mt-0.5">1-2 days</div>
                    </button>

                    <button @click="submitGrade(3)" :disabled="submitting" class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-900/50 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 text-center transition-colors">
                        <div class="text-xs font-bold text-[#1B4D3E] dark:text-emerald-400">Good</div>
                        <div class="text-[10px] text-[#1B4D3E]/70 dark:text-emerald-400/70 mt-0.5">3-4 days</div>
                    </button>

                    <button @click="submitGrade(4)" :disabled="submitting" class="p-3 rounded-xl bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-900/50 hover:bg-blue-100 dark:hover:bg-blue-900/50 text-center transition-colors">
                        <div class="text-xs font-bold text-blue-700 dark:text-blue-400">Easy</div>
                        <div class="text-[10px] text-blue-600/70 dark:text-blue-400/70 mt-0.5">6+ days</div>
                    </button>
                </div>
            </div>
        </template>

        <!-- Completed / Empty Queue State -->
        <template x-if="completed || cards.length === 0">
            <div class="rounded-3xl bg-white dark:bg-[#131926] border border-[#EBE6DE] dark:border-[#212B3E] p-10 text-center space-y-4 shadow-xs">
                <div class="w-14 h-14 rounded-full bg-[#1B4D3E]/10 dark:bg-emerald-400/10 text-[#1B4D3E] dark:text-emerald-400 flex items-center justify-center mx-auto text-xl">
                    ✓
                </div>
                <h2 class="text-xl font-bold text-[#1A1D20] dark:text-white">Review Session Complete</h2>
                <p class="text-sm text-[#687076] dark:text-[#94A3B8] max-w-sm mx-auto">
                    All cards scheduled for today have been reviewed. Return tomorrow for optimal spaced memory consolidation.
                </p>
                <div class="pt-4 flex items-center justify-center gap-3">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-[#1B4D3E] dark:bg-emerald-600 text-white text-xs font-semibold hover:opacity-90 transition-opacity">
                        Back to Dashboard
                    </a>
                    <a href="{{ route('quran.fatihah') }}" class="px-5 py-2.5 rounded-xl bg-[#FAF8F5] dark:bg-[#0B0F19] border border-[#EBE6DE] dark:border-[#212B3E] text-xs font-semibold text-[#1A1D20] dark:text-white hover:bg-[#EAE5DB]/50 transition-colors">
                        Study Al-Fatihah
                    </a>
                </div>
            </div>
        </template>
    </div>
</x-layouts.app>
