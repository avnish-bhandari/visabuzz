/**
 * Visabuz Blog Interactive Scripts
 */

document.addEventListener('DOMContentLoaded', function () {
    // --------------------------------------------------
    // Category Filtering (index.php)
    // --------------------------------------------------
    const filterButtons = document.querySelectorAll('.category-filter-btn');
    const filterItems = document.querySelectorAll('.filter-item');

    if (filterButtons.length && filterItems.length) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                // Toggle active class
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const selectedCategory = this.getAttribute('data-category');

                filterItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');

                    if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                        item.classList.remove('is-hidden');
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(8px)';
                        setTimeout(() => {
                            item.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 20);
                    } else {
                        item.classList.add('is-hidden');
                    }
                });
            });
        });
    }

    // --------------------------------------------------
    // Sticky Table of Contents ScrollSpy (single.php)
    // --------------------------------------------------
    const tocLinks = document.querySelectorAll('.toc-link');
    const contentHeadings = document.querySelectorAll('.single-post-content h2, .single-post-content h3');

    if (tocLinks.length && contentHeadings.length) {
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -65% 0px',
            threshold: 0
        };

        const headingObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    if (!id) return;

                    tocLinks.forEach(link => {
                        if (link.getAttribute('href') === `#${id}`) {
                            tocLinks.forEach(l => l.classList.remove('active'));
                            link.classList.add('active');
                        }
                    });
                }
            });
        }, observerOptions);

        contentHeadings.forEach(heading => headingObserver.observe(heading));
    }
});
