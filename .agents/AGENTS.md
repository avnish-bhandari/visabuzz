# Project Rules & Optimization Guidelines for Visabuz

These rules are PERMANENT PROJECT RULES for all HTML, CSS, Bootstrap, and JavaScript work in this project.

## PRIMARY RULE

Before KEEPING, MODIFYING, or WRITING ANY CSS BLOCK, ALWAYS ask:

"Can this be written in fewer lines using Bootstrap, CSS shorthand, existing CSS, reusable selectors, CSS variables, or another CSS technique WITHOUT CHANGING THE DESIGN OR FUNCTIONALITY AT ALL?"

If YES:
→ Use the shorter implementation.

If NO:
→ Keep/write the existing CSS.

If uncertain:
→ DO NOT change it.

---

## DESIGN PRESERVATION — ABSOLUTE PRIORITY

Never change the existing visual design just to reduce code.

The following must remain exactly the same:

* Layout
* Spacing
* Padding
* Margins
* Gaps
* Widths
* Heights
* Colors
* Fonts
* Font sizes
* Font weights
* Line heights
* Letter spacing
* Borders
* Border radius
* Shadows
* Images
* Icons
* Positioning
* Z-index
* Backgrounds
* Animations
* Transitions
* Hover states
* Active states
* Focus states
* Responsive behavior
* Breakpoints

CODE REDUCTION IS NEVER MORE IMPORTANT THAN DESIGN PRESERVATION.

---

## BOOTSTRAP-FIRST CSS REVIEW

Whenever custom CSS is being created or reviewed, first check whether Bootstrap can replace it.

Consider Bootstrap utilities such as:

* `d-flex`
* `d-grid`
* `flex-row`
* `flex-column`
* `justify-content-*`
* `align-items-*`
* `gap-*`
* `container`
* `container-fluid`
* `row`
* `col-*`
* `m-*`
* `p-*`
* `w-*`
* `h-*`
* `position-*`
* `text-*`
* `border`
* `rounded`
* `shadow`
* responsive utilities

Only use a Bootstrap utility when it produces the EXACT same result.

Never replace:

```css
padding: 13px 27px;
```

with an approximate Bootstrap utility simply because it is shorter.

Exact visual output is more important than fewer lines.

---

## CSS SHORTHAND

Always check whether multiple declarations can safely become shorthand.

Examples:

* `margin-top/right/bottom/left` → `margin`
* `padding-top/right/bottom/left` → `padding`
* `border-*` declarations → `border`
* `background-*` declarations → `background`
* `font-*` declarations → `font`
* `transition-*` declarations → `transition`
* `animation-*` declarations → `animation`

Use shorthand only when the computed result remains identical.

---

## REUSE EXISTING CSS

Before creating a new CSS rule:

1. Search for an existing rule that already performs the same job.
2. Check whether an existing class can be reused.
3. Check whether selectors can safely be grouped.
4. Check whether a CSS variable already exists.
5. Check whether Bootstrap already provides the required utility.

Do not create duplicate CSS.

---

## EVERY NEW CSS BLOCK MUST BE JUSTIFIED

Before writing new CSS, ask:

"Does this actually need custom CSS?"

Then:

"Can Bootstrap handle this?"

Then:

"Can an existing CSS rule handle this?"

Then:

"Can this be written in fewer declarations?"

Only create the CSS if necessary.

---

## DO NOT FORCE BOOTSTRAP

Bootstrap is a tool for reducing unnecessary code, NOT a requirement that every style must use Bootstrap.

Keep custom CSS when Bootstrap cannot reproduce the design exactly.

This includes:

* Unique hero designs
* Custom cards
* Brand styling
* Custom animations
* GSAP styles
* ScrollTrigger styles
* Decorative elements
* SVG positioning
* Complex responsive layouts
* Custom backgrounds
* Pseudo-elements
* Special effects
* Custom carousel styling
* Exact spacing that Bootstrap cannot reproduce

---

## JAVASCRIPT OPTIMIZATION

Whenever existing JavaScript controls UI functionality, check whether Bootstrap can safely replace it.

Consider Bootstrap functionality for:

* `nav-tabs`
* `nav-pills`
* `dropdowns`
* `modals`
* `accordion`
* `collapse`
* `offcanvas`
* navbar toggling
* `carousel`
* `tooltips`
* `popovers`

For example, if custom JavaScript only exists to switch tabs, prefer Bootstrap's:

```html
data-bs-toggle="pill"
data-bs-target="#..."
```

or:

```html
data-bs-toggle="tab"
data-bs-target="#..."
```

BUT:

The appearance must remain exactly the same.

Bootstrap's default styling must NOT replace the existing design.

Use Bootstrap for the functionality and retain/customize CSS for the existing appearance.

---

## NEVER REMOVE FUNCTIONAL JAVASCRIPT

Before removing JavaScript, determine exactly what it does.

Keep JavaScript that handles:

* API calls
* AJAX/fetch
* Forms
* Validation
* Calculations
* Filtering
* Search
* Dynamic content
* Business logic
* GSAP
* ScrollTrigger
* Custom animations
* Third-party libraries
* Application state
* LocalStorage
* Any functionality Bootstrap cannot reproduce

Only remove JavaScript when Bootstrap or another simpler implementation provides the SAME functionality.

---

## RESPONSIVE DESIGN

Never assume Bootstrap breakpoints should replace existing breakpoints.

Preserve existing responsive behavior.

Always consider existing breakpoints such as:

* `1200px`
* `1024px`
* `992px`
* `768px`
* `576px`
* `476px`

Only replace a media query with Bootstrap responsive utilities if the result is EXACTLY the same.

---

## BEFORE REMOVING CSS OR CLASSES

Always search the entire project to determine whether the selector/class is used by:

* HTML
* JavaScript
* GSAP
* ScrollTrigger
* Swiper
* Owl Carousel
* Event listeners
* Animations
* Pseudo-elements
* Responsive rules

Never remove a selector simply because it appears unused at first glance.

---

## NO BLIND REFACTORING

Never refactor code merely because another implementation looks "cleaner."

The question is always:

"Can I make this shorter WITHOUT changing anything the user sees or experiences?"

If not, leave it alone.

---

## OPTIMIZATION PRIORITY

Always follow this priority order:

1. **Preserve functionality**
2. **Preserve design**
3. **Preserve responsiveness**
4. **Preserve maintainability**
5. **Reduce unnecessary CSS**
6. **Reduce unnecessary JavaScript**
7. **Use Bootstrap where appropriate**
8. **Reduce line count**

Never reverse this priority.

---

## FINAL RULE

These rules apply EVERY TIME you work on this project.

Do not forget them when:

* Creating new sections
* Editing existing sections
* Fixing CSS
* Making responsive changes
* Adding components
* Adding Bootstrap
* Writing JavaScript
* Refactoring CSS
* Refactoring JavaScript
* Fixing bugs
* Adding animations
* Modifying existing components

For EVERY CSS block, existing or newly created, the default question is:

"Can this be written in fewer lines using Bootstrap or another CSS technique WITHOUT CHANGING THE DESIGN OR FUNCTIONALITY AT ALL?"

If yes, optimize it.

If no, keep it.

If uncertain, keep it unchanged.

**DESIGN AND FUNCTIONALITY MUST NEVER BE SACRIFICED FOR CODE REDUCTION.**
