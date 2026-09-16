# Design System: Quranic Arabic

<!-- impeccable:design-schema 1 -->

## Philosophy

Minimal, contemplative, and reverent. The interface recedes completely so the sacred script, pronunciation, and linguistic structure take center stage. Avoid harsh borders, neon accents, or distracting gamification elements.

## Color Palette

### Light Mode (Warm Parchment & Ink)
- `bg-surface`: `#FAF8F5` (warm ivory paper)
- `bg-card`: `#FFFFFF` (pure soft white)
- `border-subtle`: `#EBE6DE` (light stone hairline)
- `text-primary`: `#1A1D20` (deep ink)
- `text-secondary`: `#687076` (slate ink)
- `accent-emerald`: `#1B4D3E` (deep Quranic green for active states and completion)
- `accent-gold`: `#9A722C` (warm ochre for root indicators and morphology highlights)

### Dark Mode (Nocturnal Obsidian)
- `bg-surface`: `#0B0F19` (deep obsidian night)
- `bg-card`: `#131926` (elevated midnight slate)
- `border-subtle`: `#212B3E` (subdued slate hairline)
- `text-primary`: `#F0F4F8` (bright soft chalk)
- `text-secondary`: `#94A3B8` (muted moonlight slate)
- `accent-emerald`: `#34D399` (radiant soft emerald)
- `accent-gold`: `#FBBF24` (warm amber gold)

## Typography

### Arabic Text
- Fonts: `'Amiri'`, `'Scheherazade New'`, `'Noto Naskh Arabic'`, serif
- Metrics: Ample line height (`leading-[2.2]`) ensuring harakat (fathah, kasrah, shaddah, sukun) never clip.
- Sizes:
  - Alphabet cards: `text-4xl` to `text-5xl`
  - Quran verse / word: `text-2xl` to `text-3xl`
  - Morphology breakdown: `text-xl`

### Latin / UI Text
- Fonts: `'Plus Jakarta Sans'`, `'Inter'`, system-ui, sans-serif
- Hierarchy: Clean, disciplined type scale with high legibility for transliteration and grammar notes.

## Spatial System & Components

- Ample whitespace and breathable grid layouts (`gap-6` to `gap-8`).
- Delicate border radius (`rounded-xl` / `rounded-2xl`).
- Minimalist shadow elevation (`shadow-xs` / `shadow-sm`), relying on gentle contrast and hairline borders.
- Subdued Alpine micro-interactions: gentle ease transitions (150ms-200ms) on hover and active audio clicks.
