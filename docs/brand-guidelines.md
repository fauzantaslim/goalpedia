---

name: goalpedia-brand-guidelines
description: Defines a clean, modern, and sporty brand identity for a football content platform focused on news, stats, and insights. Optimized for readability, clarity, and scalable design systems.
license: Internal use
---------------------

# Goalpedia Brand Styling

## Overview

This brand guideline establishes a clean, modern, and sporty visual identity for a football content platform.

The design focuses on:

* Clarity over complexity
* Fast content consumption
* Modern sporty UI
* High readability (especially mobile)

---

## Brand Guidelines

### Colors

**Core Colors:**

* Primary Dark: `#093FB4` — Main brand color (trust + sporty)
* Primary Light: `#FFFCFB` — Main background
* Soft Neutral: `#FFD8D8` — Secondary background / highlight
* Border Color: `#FFD8D8` — Light borders

---

**Accent Colors:**

* Primary Accent: `#093FB4` — Buttons, links
* Secondary Accent: `#ED3500` — CTA, goals, highlights, breaking news
* Support Accent: `#FFD8D8` — Soft UI elements

---

### Color Philosophy

* **Blue (`#093FB4`)** → Trust + modern + sporty
* **Red (`#ED3500`)** → Energy + urgency (goal, match, breaking news)
* **White (`#FFFCFB`)** → Clean + readability
* **Soft Pink (`#FFD8D8`)** → Friendly UI + balance

---

### Semantic Tokens

Use semantic tokens in implementation (not raw HEX):

* `color-bg-primary` → Primary Light

* `color-bg-secondary` → Soft Neutral

* `color-text-primary` → `#000000` (pure black for maximum readability in light mode)

* `color-text-secondary` → `#374151` (dark gray for supporting text)

* `color-border` → Soft Neutral

* `color-accent-primary` → Primary Dark

* `color-accent-secondary` → Secondary Accent

* `color-accent-soft` → Soft Neutral

---

### Text Color Strategy (NEW 🔥)

* Light mode uses **pure black (`#000000`)** for primary text
* Secondary text uses **dark gray (`#374151`)** for hierarchy
* Blue (`#093FB4`) is reserved for:

  * links
  * UI elements
  * optional heading accents

👉 Avoid using blue for long paragraphs to maintain readability.

---

### Color Usage Rules

* Backgrounds → `color-bg-primary` / `color-bg-secondary`
* Headings → `color-text-primary` (black for readability)
* Body text → `color-text-primary`
* Secondary text → `color-text-secondary`
* Links → `color-accent-primary`
* Buttons → `color-accent-primary`
* CTA / highlights → `color-accent-secondary`

👉 Avoid hardcoding HEX in components.

---

## Typography

* **Headings**: Poppins (fallback: Arial, sans-serif)
* **Body Text**: Poppins (fallback: system-ui, sans-serif)

---

### Typography Scale

* H1: 28–32px → Bold
* H2: 22–26px → Semi-bold
* H3: 18–20px → Medium
* Body: 14–16px → Regular
* Small text: 12–13px

---

## Layout Style

* Clean and content-focused
* Fast scanning layout (important for news)
* Grid-based layout
* Mobile-first

---

## Component Design

### Buttons

* Background: `color-accent-primary` (`#093FB4`)
* Text: White
* Radius: 6–8px
* Hover: darker blue

👉 Secondary CTA:

* Background: `#ED3500`

---

### Cards

* Background: `color-bg-primary`
* Border: `color-border`
* Shadow: subtle

---

### Links

* Default: `color-accent-primary`
* Hover: `color-accent-secondary` + underline

---

### Tags / Labels

* Background: `color-accent-soft`
* Text: `color-text-primary`
* Used for:

  * Liga
  * Klub
  * Pemain

---

## UI Philosophy

* Simplicity over decoration
* Speed over complexity
* Readability first

---

## Content Tone & Voice

* Informative
* Clear
* Straight to the point
* Slightly energetic (sports tone)

---

## Technical Guidelines

### Color Implementation

* Use semantic tokens
* Do not use raw HEX directly in components
* Define colors in theme/config

---

### Font Management

* Use Poppins via Google Fonts
* Provide fallback fonts
* Optimize loading

---

### Responsive Design

* Mobile-first
* Max content width: 640–768px
* Padding: 16–24px

---

## Brand Personality

* ✔️ Sporty
* ✔️ Fast
* ✔️ Informative
* ✔️ Modern
* ✔️ Trustworthy

---
