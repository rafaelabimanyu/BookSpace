# 🎨 Frontend Style Guide & Design Token Matrix

This style guide documents the layout guidelines, custom visual theme parameters, utility component structures, and animated experiences that define BookSpace's elegant aesthetic.

---

## 🌸 Core Design Theme & Tokens

BookSpace replaces harsh visual colors with a soft-pink palette paired with charming, rounded typography, providing high legibility.

### 1. Color Palette Tokens
All colors are registered inside the application's configuration as Tailwind CSS semantic variables:

| Token Name | Hex Code | Purpose & Application |
| :--- | :--- | :--- |
| `primary-rose` | `#F3C5C5` | Active menus, key button backgrounds, accent text, active pagination labels. |
| `secondary-blush` | `#FCEAEA` | Hover backgrounds, border outlines, statistics container shadows, light card accents. |
| `bg-cream` | `#FFF8F8` | Primary global screen backgrounds, secondary sidebar backgrounds, body page containers. |
| `text-charcoal` | `#2D2727` | High contrast headings, form labels, body text copy, default table row font colors. |

### 2. Typography Pairings
BookSpace couples two premium Google Fonts to achieve a professional yet friendly tone:

*   **Display / Headings (Fredoka)**: Used for layout headers, card names, metric numbers, and welcome titles. Its rounded look gives BookSpace a charming, soft tone.
*   **Body / Forms (Quicksand)**: Used for details, table rows, button labels, and description blocks. It provides excellent legibility at smaller font sizes.

---

## 🧱 Global CSS Utility Components

To avoid style drift and reduce asset sizes, global components are built using native CSS variables and Tailwind classes. They are stored inside [resources/css/app.css](file:///c:/laragon/www/BookSpace/resources/css/app.css):

### 1. Card Container (`.card`)
An elegant container with curved edges, smooth shadow framing, and soft-blush outlines:
```css
.card {
    background-color: #ffffff;
    border-radius: 1.5rem; /* rounded-3xl */
    border: 1px solid rgba(252, 234, 234, 0.8);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
}
```

### 2. Primary Buttons (`.btn-primary`)
High-impact call-to-actions built on the primary accent color:
```css
.btn-primary {
    background-color: #F3C5C5;
    color: #2D2727;
    font-weight: 700;
    font-family: 'Fredoka', sans-serif;
    border-radius: 1rem; /* rounded-2xl */
    border: 1px solid rgba(252, 234, 234, 0.8);
    transition: all 0.2s ease-in-out;
}
.btn-primary:hover {
    background-color: #e5b4b4;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(243, 197, 197, 0.4);
}
```

### 3. Input Fields (`.input-field`)
Clean, accessible, and structured form fields:
```css
.input-field {
    width: 100%;
    border-radius: 1rem; /* rounded-2xl */
    border: 1px solid rgba(252, 234, 234, 1);
    color: #2D2727;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    transition: all 0.2s ease-in-out;
}
.input-field:focus {
    outline: none;
    border-color: #F3C5C5;
    box-shadow: 0 0 0 3px rgba(243, 197, 197, 0.3);
}
```

---

## ✨ Borrower Dashboard Animations

The borrower (`peminjam`) dashboard contains customized animations to create an engaging experience:

### 1. Asymmetrical Dashboard Grid
Designed in [dashboard.blade.php](file:///c:/laragon/www/BookSpace/resources/views/dashboard.blade.php), the layout uses an asymmetrical columns structure:
- **Left Column (Col-Span 2)**: Houses welcoming hero banners, reader summaries, and return warnings.
- **Right Column (Col-Span 1)**: Displays the borrower's active borrowings timeline.

### 2. Pulsing Return Warnings
A warning ring is animated next to upcoming return deadlines to capture the reader's attention:
```html
<div class="relative flex items-center justify-center">
    <!-- Pulsing Ping Ring -->
    <span class="absolute inline-flex h-12 w-12 rounded-full bg-rose-400 opacity-20 animate-ping"></span>
    <div class="relative p-3 bg-rose-50 border border-rose-100 rounded-full text-rose-500">
        <svg class="w-6 h-6" ...></svg>
    </div>
</div>
```

### 3. Micro-Interaction Scale-Up on Hover
Book recommendation cards zoom smoothly when hovered to invite user interaction:
```html
<div class="card p-4 bg-white border border-secondary-blush/40 hover:shadow-md transition duration-300 transform hover:scale-105">
    <!-- Card content here -->
</div>
```
This is powered by Tailwind's transition utilities:
- `transition`: Enacts standard transition durations.
- `duration-300`: Slows the transition to exactly 300 milliseconds.
- `transform hover:scale-105`: Increases card size by 5% on mouse-over.
