Absolutely. Below is a single source-of-truth PRD.md designed to be handed directly to Gemini/Codex/another coding agent. It covers product vision, UX, information architecture, data model, ingestion pipeline, Quranic linguistic data, audio, learning engine, AI boundaries, APIs, technical architecture, implementation phases, acceptance criteria, and deployment.

I’m deliberately making the MVP complete but constrained: the agent should build a working product rather than spending the entire implementation on an over-engineered architecture.

# Quranic Arabic — Product Requirements & Technical Specification
> **Single Source of Truth**
>
> This document defines the complete product, UX, architecture, data model, content pipeline, learning system, implementation requirements, and acceptance criteria for the Quranic Arabic learning application.
>
> The implementing agent should treat this document as the authoritative specification unless explicitly instructed otherwise.
---
# 1. Product Overview
## Product Name
**Quranic Arabic**
Working tagline:
> Learn the words. Understand the structure. Read the Quran.
Alternative tagline:
> A simple path to understanding Quranic Arabic.
---
# 2. Product Vision
Build a minimal, focused web application that helps beginners learn the fundamentals of Arabic specifically for understanding the Quran.
The product should guide a learner through:
```text
Arabic Letters
      ↓
Letter Forms
      ↓
Harakat
      ↓
Reading Practice
      ↓
Basic Vocabulary
      ↓
Quranic Vocabulary
      ↓
Roots & Word Families
      ↓
Morphology
      ↓
Grammar
      ↓
Quran Word Analysis
      ↓
Ayah Understanding

The product is NOT intended to initially compete with:

* Duolingo
* Rosetta Stone
* full Modern Standard Arabic courses
* professional Arabic grammar textbooks
* formal Tajweed education

The core objective is:

Help a beginner progressively recognize, pronounce, understand, and analyze common Quranic Arabic words and structures.

⸻

3. Product Principles

3.1 Quran-first

Vocabulary and examples should prioritize words actually encountered in the Quran.

Do not prioritize arbitrary conversational vocabulary unless it is useful for foundational Arabic learning.

⸻

3.2 Structured linguistic data over AI-generated facts

AI may explain concepts, generate exercises, and act as a tutor.

AI must NOT be treated as the authoritative source for:

* Quran text
* Quran translations
* word morphology
* roots
* grammatical annotation
* Quranic pronunciation
* verse references

Authoritative/structured datasets must be used for those.

⸻

3.3 Learn by recognition

The learner should repeatedly encounter:

Arabic
↓
Sound
↓
Meaning
↓
Structure
↓
Quran occurrence

rather than memorizing isolated vocabulary lists.

⸻

3.4 Minimal interface

The application should feel closer to a focused learning tool than a traditional LMS.

Avoid:

* excessive cards
* excessive gradients
* excessive rounded containers
* giant empty spaces
* generic AI-dashboard aesthetics
* unnecessary animations
* complicated navigation

The interface should feel:

* calm
* scholarly
* modern
* readable
* focused
* typography-driven

⸻

4. Target Users

Primary User

Beginner who:

* can read little or no Arabic
* wants to understand Quranic Arabic
* knows English or Bangla
* wants pronunciation support
* wants vocabulary tied to Quranic usage

Secondary User

Learner who:

* can already read Arabic
* wants to improve Quranic vocabulary
* wants morphology/grammar explanations
* wants word-by-word Quran analysis

⸻

5. Product Scope

MVP

The first complete implementation must include:

1. Landing page
2. Learning dashboard
3. Arabic alphabet module
4. Letter-form module
5. Harakat module
6. Basic reading exercises
7. Quranic vocabulary module
8. Word pronunciation
9. Word meaning
10. Root information
11. Quran occurrence references
12. Quran reader
13. Word-by-word Quran analysis
14. Basic morphology information
15. Al-Fatihah learning experience
16. Progress tracking
17. Review system
18. Search
19. Dark/light theme
20. Responsive mobile experience
21. Seed/import pipeline for Quran data
22. Audio integration
23. Basic authentication
24. User learning progress

⸻

6. Future Scope

Do NOT block MVP on these features.

Future versions may include:

* AI tutor
* advanced grammar curriculum
* full morphology explorer
* root explorer
* spaced repetition algorithm
* personalized learning paths
* gamification
* achievements
* streaks
* pronunciation recording
* pronunciation evaluation
* Tajweed module
* quizzes generated from Quran
* offline PWA
* native mobile application
* Bangla explanations
* Arabic-to-Bangla learning mode
* teacher mode
* classroom mode
* subscription system

⸻

7. Core User Journey

Landing Page
      ↓
Start Learning
      ↓
Diagnostic / Welcome
      ↓
Learn Letters
      ↓
Learn Harakat
      ↓
Read Simple Combinations
      ↓
Learn Quranic Words
      ↓
Review
      ↓
Recognize Words in Quran
      ↓
Understand Word Structure
      ↓
Analyze Ayah
      ↓
Continue Learning

⸻

8. Application Information Architecture

/
├── Home
│
├── Learn
│   ├── Letters
│   ├── Letter Forms
│   ├── Harakat
│   ├── Reading
│   ├── Vocabulary
│   ├── Morphology
│   └── Grammar
│
├── Quran
│   ├── Surah List
│   ├── Surah
│   ├── Ayah
│   └── Word Analysis
│
├── Roots
│   └── Root Explorer
│
├── Review
│
├── Progress
│
├── Search
│
├── Settings
│
└── Account

⸻

9. Landing Page

Objective

Immediately communicate:

Learn Quranic Arabic progressively through letters, words, grammar, and Quran verses.

Layout

------------------------------------------------
QURANIC ARABIC
Learn the language of the Quran.
Letters → Words → Grammar → Quran
[ Start Learning ]
------------------------------------------------
LEARN
Letters
Learn the Arabic alphabet.
Vocabulary
Learn high-frequency Quranic words.
Grammar
Understand how words work.
Quran
See everything in context.
------------------------------------------------
HOW IT WORKS
1. Learn
2. Practice
3. Recognize
4. Understand
------------------------------------------------
Start with the alphabet.
[ Begin ]
------------------------------------------------

The landing page must remain lightweight.

⸻

10. Dashboard

The dashboard should answer:

What should I learn next?

Example:

Good morning.
Continue learning
Arabic Letters
12 / 28
████████░░░░
Next:
ب — Bāʼ
[ Continue ]
--------------------------------
Your progress
Letters       43%
Harakat       60%
Vocabulary    18%
Quran         12%
--------------------------------
Today's Word
رَبّ
Lord
🔊
Found in:
Al-Fatihah 1:2
[ Learn Word ]

⸻

11. Learning Curriculum

Level 1 — Arabic Reading Foundations

Lesson Group A — Letters

28 Arabic letters.

Each letter must contain:

* Arabic glyph
* letter name
* transliteration
* pronunciation
* isolated form
* initial form
* medial form
* final form
* example
* audio

⸻

12. Letter Data Model

Example:

{
  "letter": "ب",
  "name_ar": "باء",
  "name_latin": "Bāʼ",
  "transliteration": "b",
  "order": 2,
  "forms": {
    "isolated": "ب",
    "initial": "بـ",
    "medial": "ـبـ",
    "final": "ـب"
  }
}

⸻

13. Arabic Letters

Seed all 28 letters:

ا
ب
ت
ث
ج
ح
خ
د
ذ
ر
ز
س
ش
ص
ض
ط
ظ
ع
غ
ف
ق
ك
ل
م
ن
ه
و
ي

The application must use correct Arabic Unicode.

Do not construct Arabic letters manually using images where Unicode text is sufficient.

⸻

14. Letter Forms

Teach:

isolated
initial
medial
final

Example:

ب
بـ
ـبـ
ـب

The lesson should visually explain how letters connect.

⸻

15. Non-Connecting Letters

Explicitly teach that certain Arabic letters do not connect to the following letter:

ا
د
ذ
ر
ز
و

The lesson should contain examples.

⸻

16. Harakat Module

Teach:

Fatha
Kasra
Damma
Sukun
Shaddah
Tanwin Fath
Tanwin Kasr
Tanwin Damm
Long vowels
Alif
Waw
Ya

Example:

بَ
بِ
بُ
بْ
بّ
بً
بٍ
بٌ

⸻

17. Harakat Lesson UX

Example:

      بَ
      🔊
      Fatha
      Short "a" vowel
--------------------------------
Try it
بَ   بِ   بُ
[ Play ]
--------------------------------
Which sound did you hear?
○ ba
○ bi
○ bu

⸻

18. Reading Practice

Generate simple exercises using known letters and harakat.

Examples:

بَ
بِ
تُ
مَا
لَا
بَيْ

Progressively introduce:

simple syllables
↓
two-letter combinations
↓
three-letter combinations
↓
simple Arabic words

Do not introduce words containing symbols/features the learner has not yet learned unless explicitly marked as advanced.

⸻

19. Vocabulary Strategy

Vocabulary must be Quran-first.

Prioritize:

1. High-frequency Quranic words
2. Core grammatical words
3. Common verbs
4. Common nouns
5. Pronouns
6. Particles
7. Common derived forms

Initial target:

100 words

Then:

500 words

Then:

1000+ words

⸻

20. Vocabulary Card

Every vocabulary item should support:

Arabic word
Transliteration
Meaning
Audio
Root
Part of speech
Morphological information
Quran occurrences
Example ayah
Related words

Example:

رَبّ
Lord
🔊
Root:
ر ب ب
Part of speech:
Noun
Quran occurrences:
...
[ See in Quran ]
[ Practice ]

⸻

21. Quran Word Frequency

Create a frequency table.

Minimum fields:

word
normalized_word
frequency
lemma
root

Allow sorting:

Most frequent
Least frequent
Recently learned
Not learned

⸻

22. Quran Module

The Quran reader should support:

Surah list
Surah view
Ayah navigation
Word-by-word interaction
Audio
Translation
Transliteration
Morphology
Root

⸻

23. Quran Reader UX

Example:

Al-Fatihah
1
بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
────────────────────
بِسْمِ
🔊
اللَّهِ
🔊
الرَّحْمَٰنِ
🔊
الرَّحِيمِ
🔊
────────────────────
Translation
In the name of Allah,
the Most Compassionate,
the Most Merciful.

Each word should be clickable.

⸻

24. Word Interaction

Clicking:

رَبِّ

opens:

رَبِّ
Lord
🔊
Root
ر ب ب
Lemma
رَبّ
Part of Speech
Noun
Case
Genitive
Reason
Because it follows the previous grammatical structure.
Quran occurrences
...
[Explore Root]
[Practice Word]

⸻

25. Word Analysis

Each Quran word should have structured metadata where available:

surface_form
normalized_form
lemma
root
part_of_speech
morphological_features
case
gender
number
person
tense
voice
mood
pattern
word_position
ayah_reference

Do not invent missing values.

If a field is unavailable:

Not available

or omit it.

⸻

26. Quranic Arabic Corpus Integration

Use the Quranic Arabic Corpus as the primary linguistic source for:

* morphological annotation
* part-of-speech information
* syntactic information
* roots
* word analysis
* Quranic grammar relationships

Reference:

https://corpus.quran.com/

The import process should convert external data into the application’s internal schema.

Do not make the frontend directly dependent on the external corpus format.

⸻

27. Quran Foundation Integration

Use Quran Foundation resources where appropriate for:

* Quran text
* chapters
* verses
* translations
* word-by-word content
* transliteration
* audio
* recitation metadata

Reference:

https://api-docs.quran.com/

The application should have an importer/synchronization layer.

⸻

28. Al Quran Cloud

Al Quran Cloud may be used as an alternative/supplementary Quran audio/content provider.

Reference:

https://alquran.cloud/

The architecture should make audio providers replaceable.

Create an interface such as:

AudioProvider
    ├── QuranFoundationAudioProvider
    └── AlQuranCloudAudioProvider

Do not tightly couple business logic to one provider.

⸻

29. Audio Architecture

For Quranic verses:

Use authentic recorded recitation where available.

Do not use generic TTS as the authoritative Quranic pronunciation source.

For educational Arabic words outside Quranic recitation:

TTS may be used as supplementary pronunciation.

Potential providers:

* OpenAI TTS
* Google Cloud Text-to-Speech
* Azure Speech
* Amazon Polly
* ElevenLabs

Audio provider should be configurable.

⸻

30. Audio Interface

AudioService
playWord()
playAyah()
playSurah()
preload()
cache()

The UI:

🔊 Play
[Word]
[Slow]
[Normal]

Playback speed controls may be added later.

⸻

31. Pronunciation

For each beginner vocabulary word:

Arabic
Readable transliteration
Audio

Do not create misleading English phonetic spellings.

Prefer established transliteration conventions.

⸻

32. Root Explorer

Create a root explorer.

Example:

ر ب ب
Root meaning:
Lordship / nurturing / sustaining
Related Quranic words:
رَبّ
رَبَّانِي
رَبُّ
رَبِّي
رَبِّنَا

Show Quran occurrences.

⸻

33. Morphology Explorer

Example:

يَسْتَغْفِرُونَ
Root:
غ ف ر
Pattern:
استفعل
Form:
X
Part of Speech:
Verb
Tense:
Imperfect
Person:
3rd
Gender:
Masculine
Number:
Plural

All fields must come from structured data where possible.

AI may explain them but must not replace source data.

⸻

34. Grammar Curriculum

The grammar curriculum should be progressive.

Level 1

Nouns
Verbs
Particles

Level 2

Definite / indefinite
Masculine / feminine
Singular / dual / plural

Level 3

Pronouns
Prepositions
Possession
Idafa

Level 4

Nominative
Accusative
Genitive

Level 5

Verb forms
Past
Present
Imperative

Level 6

Nominal sentences
Verbal sentences
Adjectives
Relative structures

⸻

35. Grammar UX

Do not initially present grammar as textbook paragraphs.

Use examples.

Example:

الْحَمْدُ لِلَّهِ
الْحَمْدُ
"The praise"
Noun
Definite
Nominative
لِلَّهِ
"For Allah"
لِ + الله
Preposition + noun
Genitive

Then:

Why is this word genitive?
Because it follows a preposition.

⸻

36. Ayah Learning Mode

This should become the centerpiece of the product.

Example:

الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ

Learner sees:

الْحَمْدُ
praise
لِلَّهِ
for Allah
رَبِّ
Lord
الْعَالَمِينَ
the worlds

Then:

Grammar
Noun
+
Prepositional phrase
+
Apposition / explanatory noun
+
Plural noun

The exact grammatical relationship must come from the linguistic dataset.

⸻

37. Learning Loop

Every lesson should follow:

Introduce
   ↓
Hear
   ↓
Observe
   ↓
Practice
   ↓
Recall
   ↓
Apply
   ↓
Review

⸻

38. Exercise Types

MVP exercise types:

Multiple Choice

What does رَبّ mean?
○ Book
○ Lord
○ Knowledge
○ House

Arabic → Meaning

رَبّ
[ Lord ]

Meaning → Arabic

Lord
○ رَبّ
○ كِتَاب
○ عِلْم
○ نُور

Audio → Word

Play audio.

User chooses Arabic word.

Word Recognition

Show an ayah and ask:

Which word means "Lord"?

Harakat

Select the correct vowel:
ب _
○ بَ
○ بِ
○ بُ

⸻

39. Review System

Every learned item should have:

new
learning
review
mastered

Minimum user progress:

user_id
content_type
content_id
status
attempts
correct_attempts
last_seen_at
next_review_at

⸻

40. Spaced Repetition

MVP may use a simple interval algorithm.

Example:

New
→ 1 day
→ 3 days
→ 7 days
→ 14 days
→ 30 days

Future versions may replace this with FSRS or another proven scheduler.

The scheduler must be isolated behind:

ReviewSchedulerInterface

⸻

41. Progress Dashboard

Show:

Letters
12 / 28
Harakat
7 / 10
Vocabulary
34 / 100
Quran
12 / 114 Surahs explored
Review
8 words due

Avoid gamification overload.

⸻

42. Daily Learning

Dashboard should recommend a small daily session.

Example:

Today's lesson
5 minutes
2 letters
3 words
5 reviews
[ Start ]

⸻

43. Search

Global search must support:

Arabic word
English meaning
root
surah
ayah number
transliteration

Example:

Search:
"lord"
Results:
رَبّ
Lord
Al-Fatihah 1:2
...

⸻

44. Authentication

MVP authentication:

Email/password

Optional:

Google login
GitHub login

Anonymous browsing should remain possible.

The user should only need an account to persist progress.

⸻

45. User Profile

Store:

name
email
preferred_language
theme
learning_level
daily_goal
created_at

Do not collect unnecessary personal information.

⸻

46. Languages

Initial interface:

English

Architecture must support:

English
Bangla
Arabic

in future.

All UI strings must be translation-ready.

Do not hard-code interface strings throughout Blade templates.

⸻

47. Bangla Support

Future Bangla mode should allow:

رَبّ
অর্থ:
প্রভু

But the core linguistic data should remain language-neutral.

Example:

word
 ├── English meaning
 ├── Bangla meaning
 └── Arabic explanation

⸻

48. Technical Architecture

Use a modular monolith.

                    Internet
                       │
                       ▼
                Cloudflare
                       │
                       ▼
                   Traefik
                       │
                       ▼
                 Laravel App
                       │
          ┌────────────┼────────────┐
          │            │            │
          ▼            ▼            ▼
      PostgreSQL      Storage      Queue
          │                         │
          │                         ▼
          │                    Import Jobs
          │
          ▼
   Learning Engine
          │
          ▼
      Web UI

⸻

49. Recommended Stack

Backend

Laravel 13
PHP 8.4+

Frontend

Blade
Alpine.js
Tailwind CSS

Database

PostgreSQL

Cache

Redis is optional.

Do not introduce Redis unless required.

Queue

Laravel queues.

Database queue is acceptable for MVP.

Storage

Local storage for development.

S3-compatible object storage for production if needed.

⸻

50. Why Blade + Alpine

The application is primarily:

* content-driven
* interactive
* text-heavy
* educational
* CRUD/data-driven

A React/Next.js SPA is unnecessary for MVP.

Use:

Blade
+
Alpine.js

for:

* audio controls
* quizzes
* modal panels
* word analysis
* progress updates
* interactive lessons
* search
* navigation

⸻

51. Project Structure

Recommended:

app/
├── Actions/
├── Console/
│   └── Commands/
│       ├── Quran/
│       ├── Corpus/
│       └── Audio/
│
├── Domain/
│   ├── Learning/
│   ├── Quran/
│   ├── Arabic/
│   ├── Vocabulary/
│   ├── Grammar/
│   └── Audio/
│
├── Models/
├── Services/
└── Support/
database/
├── migrations/
├── seeders/
└── data/
resources/
├── views/
│   ├── layouts/
│   ├── home/
│   ├── dashboard/
│   ├── lessons/
│   ├── quran/
│   ├── vocabulary/
│   ├── roots/
│   ├── review/
│   └── components/
│
├── css/
└── js/
routes/
├── web.php
└── api.php

⸻

52. Domain Modules

Separate application logic into domains.

Arabic
Quran
Vocabulary
Morphology
Grammar
Learning
Review
Audio
Search
User

Do not create microservices.

⸻

53. Database Schema

users

Laravel default users table.

⸻

arabic_letters

id
character
name_ar
name_latin
transliteration
order
description
created_at
updated_at

⸻

arabic_letter_forms

id
letter_id
position
form
example
created_at
updated_at

Positions:

isolated
initial
medial
final

⸻

harakats

id
name
symbol
description
sound
order
created_at
updated_at

⸻

quran_surahs

id
number
name_ar
name_latin
revelation_type
verse_count

⸻

quran_verses

id
surah_id
verse_number
text_ar
translation
transliteration
audio_url

⸻

quran_words

id
verse_id
position
text_ar
normalized_text
lemma
root_id
translation
transliteration
audio_url

⸻

roots

id
root_ar
root_latin
meaning

⸻

word_morphologies

id
quran_word_id
part_of_speech
pattern
form
case
mood
tense
voice
person
gender
number
features_json
source

⸻

vocabulary

id
arabic
normalized_arabic
lemma
root_id
transliteration
meaning_en
meaning_bn
part_of_speech
frequency
difficulty
audio_url

⸻

vocabulary_occurrences

id
vocabulary_id
surah_id
verse_id
quran_word_id

⸻

lessons

id
title
slug
description
level
type
order
published

⸻

lesson_items

id
lesson_id
content_type
content_id
order
metadata_json

⸻

user_progress

id
user_id
content_type
content_id
status
attempts
correct_attempts
last_seen_at
next_review_at
metadata_json

Unique:

user_id
content_type
content_id

⸻

review_cards

id
user_id
content_type
content_id
interval_days
ease_factor
repetitions
due_at
last_reviewed_at

⸻

54. Data Import Architecture

External data must never be imported directly into production tables without validation.

Pipeline:

External Source
      ↓
Downloader
      ↓
Parser
      ↓
Normalizer
      ↓
Validator
      ↓
Mapper
      ↓
Database Import
      ↓
Integrity Check

⸻

55. Import Commands

Create Artisan commands:

php artisan quran:sync
php artisan quran:validate
php artisan corpus:import
php artisan vocabulary:generate
php artisan audio:sync

Optional:

php artisan learning:seed

⸻

56. Import Idempotency

Running an importer twice must NOT duplicate data.

Use:

* stable external IDs
* unique constraints
* upserts
* checksums where appropriate

Example:

quran_surahs.number UNIQUE

and:

quran_verses
UNIQUE(surah_id, verse_number)

⸻

57. Data Validation

Before activating imported Quran data:

Validate:

114 surahs
correct verse counts
Arabic text present
no duplicate verses
word positions valid
word references valid
morphology references valid
audio references valid

Fail loudly if integrity checks fail.

⸻

58. Source Attribution

Where external data requires attribution, display it appropriately.

Create:

/about/sources

Include:

* Quran text source
* translation source
* linguistic corpus
* audio/recitation source
* licenses
* attribution requirements

Do not assume that all external datasets have identical licensing terms.

Verify the license/usage terms for each imported dataset before production deployment.

⸻

59. Quran Text Integrity

Quranic Arabic text must not be modified casually.

Do not:

* normalize away meaningful Quranic orthography
* alter diacritics
* replace text with AI-generated text
* generate Quran text from an LLM
* manually “correct” imported text without source verification

Maintain:

original_text
normalized_search_text

as separate fields where normalization is necessary for search.

⸻

60. Search Normalization

Arabic search should optionally normalize:

أ
إ
آ

for search matching.

But NEVER replace the canonical Quran text with normalized text.

Example:

Canonical:
اللَّهُ
Search index:
الله

⸻

61. Arabic Text Rendering

Use a high-quality Arabic-capable font.

Potential choices:

Noto Naskh Arabic
Noto Sans Arabic
Amiri

Use Naskh-style typography for Quran reading.

The implementation should test:

* diacritics
* shaddah
* tanwin
* madd
* ligatures
* small marks
* mobile rendering

⸻

62. RTL Support

Arabic content must use:

dir="rtl"
lang="ar"

English UI remains:

dir="ltr"
lang="en"

Mixed-language components must handle direction carefully.

⸻

63. Accessibility

Requirements:

* keyboard navigation
* visible focus states
* sufficient contrast
* screen-reader labels
* audio controls accessible by keyboard
* no information conveyed by color alone
* responsive text size
* reduced-motion support

⸻

64. Responsive Design

Mobile-first.

Primary breakpoints:

mobile
tablet
desktop

The Quran reader must be particularly optimized for mobile.

Arabic text should remain comfortably readable.

⸻

65. Visual Design System

General

Minimal scholarly aesthetic.

Use:

warm neutral background
high-contrast text
subtle borders
restrained accent color

Avoid:

neon gradients
glassmorphism
huge floating blobs
excessive shadows
excessive rounded cards

⸻

66. Typography

Use:

Arabic

Noto Naskh Arabic

or another high-quality Quran-compatible Naskh font.

Latin

Use a clean modern sans-serif.

Possible:

Inter
Geist
IBM Plex Sans

The final selection should prioritize readability.

⸻

67. UI Components

Create reusable Blade components:

<ArabicWord />
<PronunciationButton />
<ProgressBar />
<LessonCard />
<VocabularyCard />
<QuranWord />
<QuranVerse />
<MorphologyPanel />
<RootPanel />
<QuizOption />
<ReviewCard />
<AudioPlayer />
<LessonNavigation />

⸻

68. Arabic Word Component

Props:

word
translation
transliteration
audio
interactive
size

Example:

<x-arabic-word
    :word="$word->arabic"
    :translation="$word->meaning_en"
    :audio="$word->audio_url"
/>

⸻

69. Audio Component

Must:

* play/pause
* loading state
* error state
* accessible label
* avoid downloading unnecessarily
* support cached audio where appropriate

⸻

70. Lesson Engine

Lessons should be data-driven.

Do NOT hard-code every lesson directly into Blade.

Example:

Lesson
  ↓
Lesson Items
  ↓
Content
  ↓
Exercise

A lesson may contain:

explanation
example
audio
quiz
practice
review

⸻

71. Example Lesson

Lesson:
Fatha
Item 1:
Introduction
Item 2:
بَ
Item 3:
تَ
Item 4:
مَ
Item 5:
Audio exercise
Item 6:
Recognition exercise
Item 7:
Review

⸻

72. Lesson Completion

A lesson is complete when:

required items completed
AND
minimum exercise score reached

MVP threshold:

70%

Allow users to continue even if they fail.

Do not create punitive UX.

⸻

73. Quiz Engine

Generic quiz model:

question
type
prompt
options
correct_answer
explanation
content_id

Question types:

multiple_choice
audio_choice
arabic_choice
meaning_choice
harakat_choice
word_matching

⸻

74. AI Tutor — Future Module

AI should have access to structured application context.

Example:

User asks:
Why does this word have a kasrah?

AI receives:

{
  "word": "رَبِّ",
  "lemma": "رَبّ",
  "root": "ر ب ب",
  "case": "genitive",
  "source": "Quranic Arabic Corpus"
}

AI then explains the concept.

AI should not independently fabricate the linguistic metadata.

⸻

75. AI Tutor Guardrails

The AI tutor must:

1. Prefer application database facts.
2. Cite the relevant Quran verse.
3. Distinguish established linguistic information from explanation.
4. Never invent Quran text.
5. Never invent hadith.
6. Never invent grammatical annotations.
7. Never claim a tafsir position without a source.
8. Clearly state when information is unavailable.

⸻

76. Future AI Features

Possible prompts:

Explain this word.
Explain this grammar.
Give me another Quranic example.
Quiz me on this root.
Test the words I learned this week.
Explain this ayah using vocabulary I already know.
What words in this ayah should I learn first?

⸻

77. Content Hierarchy

Every piece of educational content should connect to another layer.

Example:

Letter
  ↓
Harakat
  ↓
Word
  ↓
Lemma
  ↓
Root
  ↓
Morphology
  ↓
Quran occurrence
  ↓
Ayah

This graph-like relationship is fundamental to the product.

⸻

78. Example Data Relationship

Root:
ر ب ب
        ↓
Lemma:
رَبّ
        ↓
Word:
رَبِّ
        ↓
Ayah:
الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ
        ↓
Surah:
Al-Fatihah

⸻

79. Quran Coverage Strategy

MVP:

Al-Fatihah
Juz Amma

But database architecture must support the complete Quran.

The importer should be capable of loading all 114 surahs.

⸻

80. Vocabulary Selection Algorithm

Initial vocabulary selection should prioritize:

frequency
+
linguistic usefulness
+
beginner difficulty
+
Quranic relevance

Suggested ranking:

score =
frequency_weight
+
foundational_weight
+
recurrence_weight
-
difficulty_weight

Do not simply select the first 100 words by frequency.

⸻

81. Vocabulary Difficulty

Levels:

1 = beginner
2 = basic
3 = intermediate
4 = advanced
5 = specialist

Difficulty can initially be manually curated.

Do not use AI-only difficulty scoring.

⸻

82. Lesson Ordering

The curriculum should follow prerequisite dependencies.

Example:

Alphabet
   ↓
Harakat
   ↓
Reading
   ↓
Words
   ↓
Morphology
   ↓
Grammar

A user should not be forced through every prerequisite if they already demonstrate competence.

Future diagnostic testing may allow skipping.

⸻

83. Dashboard Recommendation Engine

The dashboard chooses:

next lesson
+
due reviews
+
recommended vocabulary

Priority:

Due review
↓
Incomplete lesson
↓
Next curriculum item
↓
Optional exploration

⸻

84. API Routes

Use web routes for page rendering.

Potential API routes:

GET /api/search
GET /api/words/{word}
GET /api/roots/{root}
GET /api/quran/surahs
GET /api/quran/surahs/{surah}
GET /api/quran/verses/{verse}
POST /api/progress
POST /api/review

Keep APIs internal and minimal initially.

⸻

85. Security

Implement:

* CSRF protection
* authentication
* authorization
* rate limiting
* validated input
* secure password handling
* signed/private media URLs where necessary

Do not expose administrative import endpoints publicly.

⸻

86. Admin Area

MVP admin should provide:

Dashboard
Quran
Vocabulary
Lessons
Exercises
Sources
Imports
Users

Admin can:

* publish/unpublish lessons
* edit educational metadata
* inspect imports
* see import failures
* manage curated vocabulary
* manage lesson ordering

Imported canonical Quran data should be protected from casual editing.

⸻

87. Import Logs

Create an import log table:

id
source
operation
status
started_at
completed_at
records_processed
records_created
records_updated
records_failed
error_log

Admin can inspect import history.

⸻

88. Caching

Cache:

surah list
surah metadata
popular vocabulary
lesson definitions
root pages

Do not cache personalized progress globally.

⸻

89. Performance Requirements

Target:

First page load:
< 2 seconds on normal broadband
Typical page:
< 100 KB HTML where practical
Database:
indexed lookup for Quran words
Search:
< 300ms target

Avoid loading the entire Quran into the browser.

⸻

90. Database Indexes

At minimum:

quran_surahs.number
quran_verses
(surah_id, verse_number)
quran_words
(verse_id, position)
quran_words.normalized_text
vocabulary.normalized_arabic
vocabulary.frequency
roots.root_ar
user_progress
(user_id, content_type, content_id)
review_cards
(user_id, due_at)

⸻

91. Testing Strategy

Use:

Pest

Test:

Unit

* Arabic normalization
* review scheduling
* vocabulary scoring
* lesson completion
* Quran reference parsing

Feature

* authentication
* lesson completion
* progress tracking
* Quran reader
* search
* review

Import tests

* Quran integrity
* duplicate detection
* morphology mapping
* audio URL validation

⸻

92. Critical Data Tests

Create automated assertions:

assert Quran contains 114 surahs
assert every verse has valid surah reference
assert verse numbering is sequential
assert every quran_word belongs to a valid verse
assert morphology references valid quran_word
assert vocabulary occurrence references valid records

⸻

93. Browser Tests

Use Laravel browser testing or equivalent.

Test:

User signs up
↓
Starts lesson
↓
Completes lesson
↓
Progress updates
↓
Learns vocabulary
↓
Reviews vocabulary
↓
Opens Quran
↓
Clicks word
↓
Sees analysis
↓
Plays audio

⸻

94. Offline Considerations

MVP does not require full offline functionality.

However:

* lessons should work without unnecessary API requests
* cached static assets should be used
* audio may be cached by browser
* future PWA support should remain possible

⸻

95. Deployment

Use Docker.

Recommended services:

app
queue
scheduler
postgres
redis (optional)

Example:

docker-compose.yml

Production:

Cloudflare
     ↓
Traefik
     ↓
Laravel
     ↓
PostgreSQL

⸻

96. Environment Variables

Example:

APP_NAME="Quranic Arabic"
APP_ENV=production
APP_KEY=
DB_CONNECTION=pgsql
DB_HOST=
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
QURAN_API_BASE_URL=
QURAN_API_CLIENT_ID=
QURAN_API_CLIENT_SECRET=
AUDIO_PROVIDER=
AUDIO_BASE_URL=
OPENAI_API_KEY=
FILESYSTEM_DISK=

Secrets must never be committed.

⸻

97. External API Strategy

Do not make the user experience dependent on third-party API availability.

Use:

API
 ↓
Importer
 ↓
Local DB
 ↓
Application

Third-party API requests should primarily happen during:

* data synchronization
* content refresh
* admin operations

not on every learner interaction.

⸻

98. Provider Abstractions

Create interfaces:

QuranProviderInterface
AudioProviderInterface
TranslationProviderInterface
CorpusProviderInterface

Possible implementations:

QuranFoundationProvider
AlQuranCloudProvider
QuranFoundationAudioProvider
AlQuranCloudAudioProvider
QuranicArabicCorpusProvider

This makes providers replaceable.

⸻

99. Content Licensing

Before production:

Verify licenses for:

* Quran text
* translations
* transliterations
* corpus data
* audio recordings
* fonts
* third-party datasets

Store source and license metadata.

Never assume “publicly available” means unrestricted commercial redistribution.

⸻

100. Source Metadata Model

Create:

content_sources
id
name
url
license
attribution
version
retrieved_at
notes

Every imported dataset should have source metadata.

⸻

101. Admin Data Provenance

For important records store:

source
source_id
source_version
imported_at

This allows later auditing.

⸻

102. SEO

Public pages should be indexable where appropriate.

SEO pages:

/
learn/letters
learn/letters/b
learn/vocabulary/rabb
quran/al-fatihah
quran/al-fatihah/2
roots/r-b-b

Use meaningful metadata.

Avoid exposing user-specific pages to search engines.

⸻

103. Social Sharing

Future feature.

A public vocabulary page may eventually generate:

Learn رَبّ — Lord

share cards.

Do not prioritize this over learning functionality.

⸻

104. Analytics

Use privacy-conscious analytics.

Track events such as:

lesson_started
lesson_completed
word_learned
word_reviewed
quiz_answered
quran_word_opened
audio_played
search_performed

Do not collect unnecessary personal data.

⸻

105. Product Metrics

Track:

Activation

Percentage of users completing first lesson.

Learning

Words learned per user.

Retention

Users returning after:

1 day
7 days
30 days

Engagement

Lessons completed.

Review

Review completion rate.

Avoid vanity metrics.

⸻

106. Accessibility of Arabic

The app should not assume Arabic literacy.

For beginner mode:

Large Arabic
Readable transliteration
English meaning
Audio

As the learner advances:

Reduce transliteration
Increase Arabic-only interaction

Future setting:

Beginner
Intermediate
Arabic-only

⸻

107. Progressive Difficulty

Beginner:

Arabic
+
transliteration
+
translation
+
audio

Intermediate:

Arabic
+
translation
+
audio

Advanced:

Arabic
+
grammar
+
morphology

Future:

Arabic only

⸻

108. Gamification

Keep it subtle.

Possible:

Daily goal
Learning streak
Lessons completed
Words mastered

Avoid:

* hearts/lives
* aggressive notifications
* leaderboards
* competitive ranking

The product should feel like study, not a mobile game.

⸻

109. Notifications

Future:

You have 8 words ready for review.

Do not implement push notifications in MVP unless trivial.

⸻

110. Accessibility of Audio

Every audio button must have:

aria-label="Play pronunciation"

Audio errors must show a useful fallback.

Example:

Audio unavailable.
Try again later.

⸻

111. Error Handling

Third-party API failure:

Never break the lesson.
Show:
Audio unavailable

Database failure:

Use normal Laravel error handling.

Import failure:

Mark import as failed
Log error
Do not partially publish invalid content

⸻

112. Empty States

Examples:

No words found.
Try another search.

or:

No reviews due today.
You're caught up.

⸻

113. Loading States

Use lightweight skeletons/spinners.

Do not over-animate.

⸻

114. Animation

Use animation only when it improves comprehension.

Good:

letter connection
quiz feedback
progress transition
word highlighting

Avoid:

constant floating animation
parallax
large page transitions
decorative motion

Respect:

prefers-reduced-motion

⸻

115. Color System

Define semantic tokens:

background
foreground
muted
border
accent
success
warning
error

Do not hard-code colors throughout components.

⸻

116. Dark Mode

Support:

System
Light
Dark

Arabic reading must remain comfortable in dark mode.

⸻

117. Content Editing

Educational content should be editable without modifying application code.

For example:

Lesson
Vocabulary
Exercise
Grammar explanation

should be stored in database structures.

Canonical Quran text remains source-controlled/import-controlled.

⸻

118. Seed Data

The repository must contain enough seed data to demonstrate the complete application.

At minimum:

28 letters
letter forms
harakat
initial lessons
100 vocabulary items
Al-Fatihah
Juz Amma
morphology
sample exercises

If licensing prevents bundling a dataset directly, provide a documented import command and sample development fixture.

⸻

119. Demo Mode

The application should work after:

composer install
npm install
php artisan migrate --seed
npm run build

or:

docker compose up

The agent must ensure the README explains exact setup.

⸻

120. README

README must contain:

Project overview
Requirements
Installation
Environment variables
Database setup
Data imports
Audio configuration
Running tests
Development commands
Production deployment
Data licensing
Architecture

⸻

121. Developer Documentation

Create:

docs/
├── architecture.md
├── data-sources.md
├── importing-quran.md
├── learning-engine.md
├── audio.md
└── content-model.md

The PRD remains the source of truth.

Documentation explains implementation details.

⸻

122. API Documentation

Document internal APIs.

Use:

OpenAPI

or a lightweight Markdown API specification.

⸻

123. Security Requirements

Never:

* commit API secrets
* expose admin endpoints without auth
* trust external API data blindly
* allow arbitrary HTML from imported data
* render unsanitized external content
* store passwords manually
* trust client-side progress values

Server must validate progress submissions.

⸻

124. Content Safety / Accuracy

For Quranic content:

accuracy > convenience

If data is uncertain:

Do not invent.

Use:

Source unavailable

instead.

⸻

125. Architecture Diagram

                          ┌─────────────────────┐
                          │   External Sources  │
                          ├─────────────────────┤
                          │ Quran Foundation   │
                          │ Quranic Corpus     │
                          │ Al Quran Cloud     │
                          │ Audio Providers    │
                          └──────────┬──────────┘
                                     │
                                     ▼
                         ┌────────────────────────┐
                         │     Import Pipeline     │
                         ├────────────────────────┤
                         │ Downloader              │
                         │ Parser                  │
                         │ Normalizer              │
                         │ Validator               │
                         │ Mapper                  │
                         │ Importer                │
                         └────────────┬───────────┘
                                      │
                                      ▼
                     ┌────────────────────────────────┐
                     │          PostgreSQL             │
                     ├────────────────────────────────┤
                     │ Quran                           │
                     │ Words                           │
                     │ Roots                           │
                     │ Morphology                      │
                     │ Vocabulary                      │
                     │ Lessons                         │
                     │ Exercises                       │
                     │ User Progress                   │
                     │ Reviews                         │
                     └───────────────┬────────────────┘
                                     │
                                     ▼
                     ┌────────────────────────────────┐
                     │          Laravel 13             │
                     ├────────────────────────────────┤
                     │ Quran Domain                    │
                     │ Arabic Domain                   │
                     │ Vocabulary Domain               │
                     │ Morphology Domain               │
                     │ Grammar Domain                  │
                     │ Learning Domain                 │
                     │ Review Domain                   │
                     │ Audio Domain                    │
                     │ Search Domain                   │
                     └───────────────┬────────────────┘
                                     │
                                     ▼
                     ┌────────────────────────────────┐
                     │       Blade + Alpine.js         │
                     ├────────────────────────────────┤
                     │ Dashboard                      │
                     │ Lessons                        │
                     │ Vocabulary                     │
                     │ Quran Reader                   │
                     │ Root Explorer                  │
                     │ Exercises                      │
                     │ Review                         │
                     └────────────────────────────────┘

⸻

126. Learning Architecture

                   Curriculum
                       │
                       ▼
                    Lessons
                       │
             ┌─────────┴─────────┐
             ▼                   ▼
          Content             Exercises
             │                   │
             └─────────┬─────────┘
                       ▼
                 User Progress
                       │
                       ▼
                 Review Cards
                       │
                       ▼
                Spaced Repetition
                       │
                       ▼
                 Recommendations
                       │
                       └──────────→ Dashboard

⸻

127. Quran Knowledge Graph

Conceptually model the content as:

                 ROOT
                  │
                  ▼
                LEMMA
                  │
                  ▼
               WORD FORM
                  │
                  ▼
                 AYAH
                  │
                  ▼
                SURAH

Additional relationships:

WORD → TRANSLATION
WORD → MORPHOLOGY
WORD → AUDIO
WORD → EXAMPLES
WORD → RELATED WORDS
WORD → USER PROGRESS

This structure should guide database relationships.

⸻

128. Example End-to-End Flow

User opens:

/learn/vocabulary

Selects:

رَبّ

Application retrieves:

Vocabulary
↓
Root
↓
Quran occurrences
↓
Morphology
↓
Audio

UI renders:

رَبّ
Lord
🔊
Root
ر ب ب
Noun
Quran occurrences
...
[Practice]
[See in Quran]

User clicks:

See in Quran

Application opens:

Al-Fatihah 1:2

and highlights:

رَبِّ

User clicks the word.

The same linguistic metadata appears.

This creates a closed learning loop.

⸻

129. MVP Navigation

Desktop:

Quranic Arabic
Learn
  Letters
  Harakat
  Vocabulary
  Grammar
Quran
Review
Progress
Search
Settings

Mobile:

Home
Learn
Quran
Review

Use a bottom navigation on mobile if appropriate.

⸻

130. MVP Pages

Required pages:

/
 /dashboard
 /learn
 /learn/letters
 /learn/letters/{letter}
 /learn/harakat
 /learn/reading
 /learn/vocabulary
 /learn/vocabulary/{word}
 /learn/grammar
 /quran
 /quran/{surah}
 /quran/{surah}/{ayah}
 /roots
 /roots/{root}
 /review
 /progress
 /search
 /settings
 /login
 /register

⸻

131. First-Time User Experience

First visit:

Welcome to Quranic Arabic.
We'll start with the building blocks:
Letters
↓
Sounds
↓
Words
↓
Quran

CTA:

Start with the alphabet

No mandatory account creation.

After first lesson:

Create an account to save your progress.

⸻

132. Guest Mode

Guests may:

* browse letters
* browse lessons
* browse Quran
* hear audio
* explore vocabulary

Guests cannot persist:

* progress
* reviews
* preferences

unless they authenticate.

⸻

133. Progress Synchronization

When a guest creates an account:

Attempt to preserve current local progress where practical.

Future feature if complexity is low.

⸻

134. Local Storage

Use browser local storage only for:

theme preference
audio preference
temporary lesson state
guest progress

Never treat local storage as authoritative for authenticated progress.

⸻

135. Mobile Quran Reader

The mobile Quran reader must prioritize:

Arabic readability
word selection
translation
audio
scroll position

Do not put excessive metadata around every word.

Use a bottom sheet or expandable panel for analysis.

⸻

136. Desktop Quran Reader

Desktop may show:

Ayah
Arabic text
Translation
Word analysis panel

Example:

┌─────────────────────────────┬─────────────────────┐
│                             │                     │
│ Arabic Ayah                 │ Word Analysis       │
│                             │                     │
│ الْحَمْدُ لِلَّهِ ...        │ رَبِّ               │
│                             │                     │
│ Translation                 │ Lord                │
│                             │                     │
│                             │ Root                │
│                             │ ر ب ب               │
└─────────────────────────────┴─────────────────────┘

⸻

137. Lesson Completion UX

At completion:

Lesson complete.
You learned:
✓ ب
✓ ت
✓ ث
Next:
Harakat — Fatha
[ Continue ]

Do not use excessive celebration.

⸻

138. Review UX

Simple:

What does this mean?
رَبّ
🔊
[Show Answer]

After answer:

Lord
How well did you remember?
Again
Hard
Good
Easy

⸻

139. Accessibility for Beginners

Never rely on transliteration alone.

Arabic must remain the primary representation.

Example:

رَبّ
Lord
[Audio]

Transliteration can be secondary.

⸻

140. Translation Philosophy

Translations are aids to understanding, not replacements for Arabic.

UI should visually distinguish:

Arabic
Translation
Grammar
Explanation

Do not blend them into one ambiguous block.

⸻

141. Grammar Explanation Philosophy

Prefer:

Example
↓
Observation
↓
Rule

instead of:

Rule
↓
Long explanation
↓
Example

⸻

142. Future Tajweed Boundary

If Tajweed is added later, it must be a separate domain:

Quranic Arabic
    │
    ├── Language
    │
    └── Tajweed

Do not mix grammatical pronunciation with recitation rules.

⸻

143. Future Pronunciation Practice

Possible future workflow:

Listen
↓
Record yourself
↓
Speech analysis
↓
Compare
↓
Practice

This requires a dedicated pronunciation/speech system.

Do not implement approximate pronunciation scoring in MVP.

⸻

144. Future AI Architecture

                   User
                    │
                    ▼
                AI Tutor
                    │
           ┌────────┴────────┐
           │                 │
           ▼                 ▼
     Structured Data      User Context
           │                 │
           └────────┬────────┘
                    ▼
                 LLM
                    │
                    ▼
              Explanation

The AI should retrieve authoritative application data before answering.

⸻

145. AI Retrieval Sources

Future RAG sources:

Quran word database
Quranic Arabic Corpus
grammar lessons
vocabulary database
curated explanations
licensed reference materials

Do not blindly scrape random websites into the knowledge base.

⸻

146. AI Response Format

Example:

Why is رَبِّ pronounced with this ending?
Because the word occurs in a grammatical position that requires the genitive case.
In this ayah, it is connected to the preceding structure.
See:
Al-Fatihah 1:2

The exact grammatical claim must be backed by structured source data.

⸻

147. Internationalization Architecture

Use Laravel localization:

lang/
├── en/
├── bn/
└── ar/

Content translations remain in database tables.

⸻

148. Content Translation Schema

Potential:

content_translations
id
content_type
content_id
locale
field
value

Or structured JSON if appropriate.

Use a consistent strategy.

⸻

149. Versioning

Imported datasets should record:

source
version
retrieved_at
checksum

When updating:

download
↓
validate
↓
diff
↓
import
↓
integrity check

Never blindly overwrite canonical data.

⸻

150. Backup Strategy

Production:

daily PostgreSQL backup
retention policy
off-site backup

Audio should not necessarily be duplicated if the provider is authoritative and permitted for hotlinking.

⸻

151. Observability

Log:

application errors
failed imports
failed audio requests
slow queries
authentication failures

Optional:

Sentry

Do not require external observability services for local development.

⸻

152. Performance Optimization

Use:

database eager loading
pagination
indexes
query caching
HTTP caching
asset bundling
lazy audio loading

Avoid:

N+1 queries
loading all vocabulary at once
loading all Quran verses at once
large JavaScript bundles

⸻

153. SEO Content Strategy

Public pages can eventually rank for:

Arabic alphabet
Arabic letters
Quranic Arabic
Quranic Arabic vocabulary
Arabic root meanings
Quran word meaning
Arabic grammar Quran

SEO must never compromise the learning UX.

⸻

154. Product Naming

Primary:

Quranic Arabic

Possible future branded names:

Bayān
Lisan
Qalam
Fahm
Lughah

Do not rename the product during MVP implementation unless explicitly instructed.

⸻

155. Design References

Visual inspiration:

* scholarly digital libraries
* modern Quran applications
* language-learning interfaces
* typography-focused educational products

Avoid copying any existing product.

⸻

156. Design Quality Bar

The final application must NOT look AI-generated.

Specifically avoid:

Hero:
Huge gradient text
Floating glass cards
Random blobs
Generic AI icons

Instead:

Strong typography
Careful spacing
Clear hierarchy
Excellent Arabic rendering
Subtle borders
Functional interaction

⸻

157. Core User Experience Requirement

At any point the learner should know:

Where am I?
What am I learning?
Why am I learning it?
What should I do next?

⸻

158. Implementation Phases

Phase 1 — Foundation

Implement:

Laravel
PostgreSQL
Blade
Alpine
Tailwind
Auth
Layout
Theme
Navigation

Acceptance:

Application boots
Authentication works
Responsive shell works

⸻

159. Phase 2 — Arabic Foundations

Implement:

Letters
Letter forms
Harakat
Lessons
Exercises
Audio interface

Acceptance:

All 28 letters available
Letter forms display correctly
Harakat lessons work
Exercises submit correctly
Progress persists

⸻

160. Phase 3 — Quran Data

Implement:

Surahs
Verses
Words
Translations
Audio metadata

Import:

complete Quran

if licensing/source availability permits.

Otherwise:

Al-Fatihah + development fixtures

and provide the complete importer.

Acceptance:

Surah list works
Verse pages work
Arabic rendering works

⸻

161. Phase 4 — Linguistic Data

Implement:

roots
lemmas
morphology
parts of speech
word relationships
occurrences

Acceptance:

Clicking a Quran word shows its available analysis.

⸻

162. Phase 5 — Vocabulary

Implement:

100 curated Quranic vocabulary items
frequency
root
meaning
audio
occurrences
practice

Acceptance:

Vocabulary pages work
Search works
Practice works
Progress works

⸻

163. Phase 6 — Quran Learning

Implement:

Al-Fatihah learning mode
word highlighting
word analysis
audio
translation
grammar

Acceptance:

User can study Al-Fatihah word by word.

⸻

164. Phase 7 — Review

Implement:

review cards
due reviews
simple scheduling
dashboard recommendations

Acceptance:

A completed word appears in review.
Reviewing updates next due date.

⸻

165. Phase 8 — Polish

Implement:

responsive refinement
accessibility
loading states
empty states
error handling
SEO
performance
tests
documentation

⸻

166. Phase 9 — AI Tutor

ONLY after the deterministic learning system works.

Implement:

context retrieval
AI explanation
quiz generation
learning assistance

Do not allow AI to become a dependency for the basic application.

⸻

167. Definition of Done

The project is considered complete when:

Product

* Landing page works
* Dashboard works
* Alphabet module works
* Harakat module works
* Reading practice works
* Vocabulary works
* Quran reader works
* Word analysis works
* Audio works where configured
* Progress works
* Review works
* Search works
* Authentication works

Data

* 28 letters imported
* Letter forms imported
* Harakat seeded
* Quran data imported or import pipeline documented
* Linguistic data imported or pipeline documented
* 100 vocabulary items available
* Al-Fatihah fully supported
* Sources documented
* Licensing documented

Engineering

* Tests pass
* No critical N+1 queries
* Database indexes created
* Import commands are idempotent
* Environment configuration documented
* Docker works
* Production build works
* README complete

UX

* Mobile responsive
* Arabic typography readable
* RTL correct
* Dark mode works
* Keyboard accessible
* Audio controls accessible
* No broken states
* No unnecessary UI complexity

⸻

168. Acceptance Test — New User

Given:

new user

When they visit:

/

They can:

Start Learning
↓
Open alphabet
↓
Learn first letter
↓
Hear pronunciation
↓
Complete exercise
↓
See progress
↓
Continue

⸻

169. Acceptance Test — Vocabulary

Given:

authenticated user

When they open a vocabulary word:

رَبّ

They see:

Arabic
meaning
audio
root
part of speech
Quran occurrence
practice

After completing practice:

progress updated
review card created

⸻

170. Acceptance Test — Quran

Given:

user opens Al-Fatihah

They see:

Arabic ayah
translation
audio

When clicking a word:

word analysis panel opens

When selecting:

See Root

the root page opens.

⸻

171. Acceptance Test — Review

Given:

review card due

Dashboard shows:

8 reviews due

User completes review.

System updates:

attempts
correct_attempts
interval
repetitions
next_review_at

⸻

172. Acceptance Test — Data Integrity

Run:

php artisan quran:validate

It must report:

✓ Surah count valid
✓ Verse references valid
✓ Word references valid
✓ No duplicates
✓ Morphology references valid
✓ Audio references valid

Any critical failure must exit with non-zero status.

⸻

173. Coding Standards

Follow Laravel conventions.

Use:

PSR-12
Laravel conventions
strict validation
typed properties
small services
single responsibility

Use:

Pest
Laravel Pint
PHPStan/Larastan

where practical.

⸻

174. Avoid Overengineering

Do NOT introduce:

microservices
Kubernetes
GraphQL
React
Next.js
WebSockets
ClickHouse
event sourcing
CQRS
Kafka

unless a later requirement explicitly justifies them.

This is a modular Laravel application.

⸻

175. Important Implementation Rule

If an external API can provide data, prefer:

import once
store locally
serve locally

rather than:

request API on every page load

⸻

176. Important Linguistic Rule

If a linguistic fact cannot be confidently established from the imported dataset:

Do not fabricate it.
Display:
"Detailed analysis unavailable."

⸻

177. Important Quran Rule

The Quran text is canonical content.

Never use an LLM to generate or reconstruct Quranic text.

Never silently modify Quranic text.

⸻

178. Important Audio Rule

For Quranic recitation:

Authentic recorded recitation
>
Generic TTS

For ordinary educational Arabic pronunciation:

Recorded source
or
high-quality TTS

may be used.

⸻

179. Final Product Architecture

                         USER
                           │
                           ▼
                 ┌───────────────────┐
                 │    Web Browser    │
                 │                   │
                 │ Blade + Alpine.js │
                 └─────────┬─────────┘
                           │
                           ▼
                 ┌───────────────────┐
                 │    Laravel 13     │
                 │                   │
                 │ Quran             │
                 │ Arabic            │
                 │ Vocabulary        │
                 │ Morphology        │
                 │ Grammar           │
                 │ Learning          │
                 │ Review            │
                 │ Search            │
                 │ Audio             │
                 └─────────┬─────────┘
                           │
                           ▼
                 ┌───────────────────┐
                 │    PostgreSQL     │
                 │                   │
                 │ Quran             │
                 │ Words             │
                 │ Roots             │
                 │ Morphology        │
                 │ Vocabulary        │
                 │ Lessons           │
                 │ Progress          │
                 │ Reviews           │
                 └─────────┬─────────┘
                           │
             ┌─────────────┼──────────────┐
             │             │              │
             ▼             ▼              ▼
       Quran Sources   Corpus Data     Audio
             │             │              │
             └─────────────┼──────────────┘
                           ▼
                    Import Pipeline
                           │
                           ▼
                      Local Data

⸻

180. Final Implementation Directive

The implementing coding agent must treat this document as the product source of truth.

Build the application end-to-end rather than stopping at scaffolding.

Priority order:

1. Correct data
2. Working learning flow
3. Quran integration
4. Pronunciation/audio
5. Progress/review
6. Excellent Arabic typography
7. Responsive UX
8. Testing
9. Performance
10. Visual polish

Do not spend disproportionate time on visual effects before the learning loop works.

The minimum complete loop is:

Learn letter
      ↓
Hear letter
      ↓
Practice letter
      ↓
Learn word
      ↓
Hear word
      ↓
Practice word
      ↓
Find word in Quran
      ↓
Analyze word
      ↓
Read ayah
      ↓
Review later

That loop must work before implementing advanced features.

⸻

181. MVP Success Definition

The product succeeds if a complete beginner can enter the application and, without external instructions:

learn Arabic letters
        ↓
understand basic harakat
        ↓
read simple Arabic
        ↓
learn common Quranic words
        ↓
hear their pronunciation
        ↓
recognize them in the Quran
        ↓
inspect their roots/morphology
        ↓
understand a simple ayah breakdown
        ↓
return later and review them

The product should ultimately feel like:

A small, beautiful, structured bridge between learning Arabic and understanding the Quran.

### One implementation decision I'd strongly recommend
When you hand this to the coding agent, **don't ask it to generate the Quranic linguistic data itself**. Have it build the **import/normalization pipeline** and use the real structured sources. That is the difference between a demo that *looks* like a Quranic Arabic app and an application whose linguistic layer can actually be trusted.
For V1, the agent should get the following loop working first:
**28 letters → harakat → reading exercises → 100 Quranic words → audio → Al-Fatihah → word analysis → progress/review.**
Then morphology/grammar can expand naturally on top of that data model.