# 🎨 Frontend Style Guide & Design Token Matrix

This guide details the layout framework, visual tokens, unified CSS component system, and interactive physics-based animation curves that establish the premium **BookSpace** user experience.

---

## 🌸 Visual Identity & Core Design Tokens

BookSpace replaces cold, institutional interfaces with a warm, elegant soft-pink palette paired with charming, highly readable rounded typography.

### 1. Unified Theme Colors
All colors are registered inside the application's Tailwind CSS configuration at [tailwind.config.js](file:///c:/laragon/www/BookSpace/tailwind.config.js#L14-L19):

| Color Name | Hex Code | Semantic Purpose & Application |
| :--- | :--- | :--- |
| **Primary Rose** | `#F3C5C5` | Primary buttons, active state markers, highlighted borders, calendar/date badges, and brand branding accent colors. |
| **Secondary Blush** | `#FCEAEA` | Statistics card backgrounds, secondary borders, hover states, warning tags, and subtle card backdrops. |
| **Background Cream** | `#FFF8F8` | Global application wrapper background, side navigation background blocks, and base workspace margins. |
| **Text Charcoal** | `#2D2727` | Headings, table cells, form label inputs, regular paragraph text copy, and high-contrast typography. |

### 2. Typographic Palette
BookSpace pairs two premium Google Font families to establish a friendly yet highly legible visual tone:

*   **Display Font (Fredoka)**: Registered under `font-display` inside [tailwind.config.js](file:///c:/laragon/www/BookSpace/tailwind.config.js#L22). Its rounded letterforms deliver a welcoming, premium feeling across page titles, headers, count numbers, and card labels.
*   **Body Font (Quicksand)**: Registered under `font-sans` inside [tailwind.config.js](file:///c:/laragon/www/BookSpace/tailwind.config.js#L21). It serves as the primary body font, providing high legibility for lists, tables, system notifications, descriptions, and input elements.

---

## 🧱 Unified CSS Component Architecture

To maintain a consistent styling aesthetic and reduce stylesheet footprint, all reusable components are designed utilizing Tailwind CSS directive sets inside [resources/css/app.css](file:///c:/laragon/www/BookSpace/resources/css/app.css):

### 1. Frosted Card Layouts (`.card`)
Cards use curved boundaries, soft dropshadows, and crisp, blush borders:
```css
.card {
    background-color: #ffffff;
    border-radius: 1.5rem; /* rounded-3xl */
    border: 1px solid rgba(252, 234, 234, 1);
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    overflow: hidden;
}
```

### 2. High-Fidelity Accent Buttons (`.btn-primary`)
Premium CTA buttons leverage smooth color shifts, translation scale-ups on hover, and active feedback curves:
```css
.btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem; /* px-6 py-3 */
    background-color: #F3C5C5; /* primary-rose */
    color: #ffffff;
    font-family: 'Fredoka', sans-serif;
    font-weight: 600;
    border-radius: 1rem; /* rounded-2xl */
    transition: all 150ms ease-in-out;
}
.btn-primary:hover {
    background-color: #f87171; /* rose-400 */
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(243, 197, 197, 0.4);
}
.btn-primary:active {
    background-color: #f43f5e; /* rose-500 */
}
```

### 3. Sleek Inputs (`.input-field`)
Highly interactive, anti-aliased, and accessible input fields:
```css
.input-field {
    width: 100%;
    border-radius: 1rem; /* rounded-2xl */
    border: 1px solid #FCEAEA; /* secondary-blush */
    color: #2D2727; /* text-charcoal */
    font-family: 'Quicksand', sans-serif;
    transition: all 300ms ease-in-out;
}
.input-field:focus {
    outline: none;
    border-color: rgba(243, 197, 197, 0.5); /* primary-rose/50 */
    box-shadow: 0 0 0 4px rgba(243, 197, 197, 0.1); /* primary-rose/10 */
}
```

---

## 🖥️ Responsive Widescreen Desktop Grid Layout

BookSpace features a highly optimized, dual-column responsive grid template structured for desktop monitors.

```
+-----------------------------------------------------------------------------------+
|  [Header branding logo / User stats widgets / Interactive greeting banners]       |
+-----------------------------------------------------------------------------------+
|  [COL 1 - Sticky Navigator / Indices]  |  [COL 2, 3, 4 - Main Content Grid Space]  |
|  - tata cara peminjaman                |  - interactive search catalogs           |
|  - lending guidelines & limit metrics  |  - late fee simulators                   |
|  - dynamic late-fee policies index     |  - profile curators / e-card displays     |
+-----------------------------------------------------------------------------------+
```

### 1. Widescreen Desktop Layout Implementation
Designed dynamically in files like [sop.blade.php](file:///c:/laragon/www/BookSpace/resources/views/peminjam/sop.blade.php#L8-L34), BookSpace features a clean desktop column layout using Tailwind:
```html
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start w-full">
    <!-- Sticky Quick Navigation Index (Col 1) -->
    <aside class="lg:col-span-1 sticky top-24 hidden lg:block z-20">
        <div class="p-6 bg-white/75 border border-primary-rose/25 shadow-xl shadow-rose-100/30 rounded-3xl backdrop-blur-md transition-premium hover:shadow-2xl">
            <!-- Navigation links -->
        </div>
    </aside>

    <!-- Main Content Area (Col 3 / lg:col-span-3) -->
    <main class="col-span-1 lg:col-span-3 space-y-8">
        <!-- Content sections -->
    </main>
</div>
```

### 2. Sticky Sidebar Integration
To keep layouts structured, side-indexes are nested inside `sticky` bounds equipped with standard header offsets (`top-24`) to stay locked in view as users scroll long data sheets.

---

## ✨ Animation Systems & Dynamic Motion Physics

BookSpace incorporates custom cubic-bezier deceleration timing setups and reactive micro-interactions, providing an engaging experience.

### 1. Premium Deceleration Timing Class
To replace linear CSS animations, BookSpace introduces a luxury deceleration curve utilizing a standard 10-point deceleration formula. This is defined at [resources/css/app.css](file:///c:/laragon/www/BookSpace/resources/css/app.css#L30-L32):

```css
.transition-premium {
    transition: all 450ms cubic-bezier(0.16, 1, 0.3, 1);
}
```
This curve initiates color transitions and translation offsets at maximum velocity before easing into position, creating a responsive feel.

### 2. Staggered Entrance Animations (`.animate-fade-in-up`)
To make dashboard entrances elegant, child layout blocks use staggered entrance delays inside [resources/css/app.css](file:///c:/laragon/www/BookSpace/resources/css/app.css#L34-L59):
```css
.animate-fade-in-up {
    animation: fadeInUp 700ms cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(16px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.delay-100 { animation-delay: 100ms; }
.delay-200 { animation-delay: 200ms; }
.delay-300 { animation-delay: 300ms; }
```

### 3. Interactive Alpine.js Transition Attributes (`x-transition`)
Dynamic overlays, floating toasts, modals, and review panels utilize custom Alpine.js animation hooks:
```html
<!-- Slide-over panel example -->
<div 
    x-show="isOpen"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0"
    class="fixed right-0 top-0 h-full w-96 card bg-white z-50 p-6"
>
    <!-- Dynamic Panel Content -->
</div>
```
This setup synchronizes layout movements, creating a premium feel.
