/**
 * Trova — Hero & Navbar Interactions
 * Pure Vanilla JavaScript
 */

document.addEventListener('DOMContentLoaded', () => {
  // Navigation Elements
  const floatingNavbar = document.getElementById('floatingNavbar');
  const navPillToggle = document.getElementById('navPillToggle');
  const navOverlay = document.getElementById('navOverlay');
  const navOverlayClose = document.getElementById('navOverlayClose');
  const navOverlayBackdrop = document.getElementById('navOverlayBackdrop');
  const overlayLinks = document.querySelectorAll('.overlay-link');
  const filterPills = document.querySelectorAll('.filter-pill');
  const heroSection = document.getElementById('hero');

  /* --------------------------------------------------------------------------
     1. Dynamic Floating Navbar on Scroll
     -------------------------------------------------------------------------- */
  const handleScroll = () => {
    if (!floatingNavbar) return;
    if (window.scrollY > 40) {
      floatingNavbar.classList.add('scrolled');
    } else {
      floatingNavbar.classList.remove('scrolled');
    }
  };

  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll();

  /* --------------------------------------------------------------------------
     2. Fullscreen Blur Navigation Overlay Controls
     -------------------------------------------------------------------------- */
  const openMenu = () => {
    if (!navOverlay) return;
    navOverlay.classList.add('is-open');
    navOverlay.setAttribute('aria-hidden', 'false');
    if (navPillToggle) navPillToggle.setAttribute('aria-expanded', 'true');
    document.body.classList.add('menu-open');
    document.body.style.overflow = 'hidden';
  };

  const closeMenu = () => {
    if (!navOverlay) return;
    navOverlay.classList.remove('is-open');
    navOverlay.setAttribute('aria-hidden', 'true');
    if (navPillToggle) navPillToggle.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('menu-open');
    document.body.style.overflow = '';
  };

  if (navPillToggle) {
    navPillToggle.addEventListener('click', openMenu);
  }

  if (navOverlayClose) {
    navOverlayClose.addEventListener('click', closeMenu);
  }

  if (navOverlayBackdrop) {
    navOverlayBackdrop.addEventListener('click', closeMenu);
  }

  // Close when clicking any nav link
  overlayLinks.forEach(link => {
    link.addEventListener('click', () => {
      closeMenu();
    });
  });

  // Close on Escape key press
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && navOverlay && navOverlay.classList.contains('is-open')) {
      closeMenu();
    }
  });

  /* --------------------------------------------------------------------------
     3. Category Filter Buttons (Interactive selection)
     -------------------------------------------------------------------------- */
  filterPills.forEach(pill => {
    pill.addEventListener('click', () => {
      // Toggle active class among category pills
      filterPills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');

      // Subtle haptic ripple / feedback
      pill.style.transform = 'scale(0.96)';
      setTimeout(() => {
        pill.style.transform = '';
      }, 120);
    });
  });

  /* --------------------------------------------------------------------------
     4. Subtle Parallax Effect on Background (Desktop only)
     -------------------------------------------------------------------------- */
  if (window.matchMedia('(hover: hover) and (min-width: 1024px)').matches && heroSection) {
    let mouseX = 0;
    let mouseY = 0;
    let currentX = 0;
    let currentY = 0;

    window.addEventListener('mousemove', (e) => {
      // Normalized coordinates from -1 to 1
      mouseX = (e.clientX / window.innerWidth - 0.5) * 12;
      mouseY = (e.clientY / window.innerHeight - 0.5) * 8;
    }, { passive: true });

    const animateParallax = () => {
      currentX += (mouseX - currentX) * 0.05;
      currentY += (mouseY - currentY) * 0.05;

      heroSection.style.backgroundPosition = `calc(50% + ${currentX}px) calc(32% + ${currentY}px)`;

      requestAnimationFrame(animateParallax);
    };

    requestAnimationFrame(animateParallax);
  }

  /* --------------------------------------------------------------------------
     5. Fanned Story Cards Interactive Controls
     -------------------------------------------------------------------------- */
  const deckButtons = document.querySelectorAll('.deck-btn');
  const deckCards = document.querySelectorAll('.deck-card');

  const setStoryActive = (target) => {
    // Update button states
    deckButtons.forEach(btn => {
      btn.classList.toggle('active', btn.dataset.target === target);
    });

    // Reset card classes
    deckCards.forEach(card => {
      card.classList.remove('card-left', 'card-center', 'card-right', 'active');
    });

    const cardMountain = document.getElementById('cardMountain');
    const cardCoastal = document.getElementById('cardCoastal');
    const cardForest = document.getElementById('cardForest');

    if (target === 'coastal') {
      if (cardCoastal) cardCoastal.classList.add('card-center', 'active');
      if (cardMountain) cardMountain.classList.add('card-right');
      if (cardForest) cardForest.classList.add('card-left');
    } else if (target === 'forest') {
      if (cardForest) cardForest.classList.add('card-center', 'active');
      if (cardMountain) cardMountain.classList.add('card-left');
      if (cardCoastal) cardCoastal.classList.add('card-right');
    } else {
      // Default: mountain
      if (cardMountain) cardMountain.classList.add('card-center', 'active');
      if (cardCoastal) cardCoastal.classList.add('card-left');
      if (cardForest) cardForest.classList.add('card-right');
    }
  };

  // Button clicks
  deckButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.dataset.target;
      if (target) setStoryActive(target);
    });
  });

  // Direct card clicks
  deckCards.forEach(card => {
    card.addEventListener('click', () => {
      const story = card.dataset.story;
      if (story) setStoryActive(story);
    });
  });

  /* --------------------------------------------------------------------------
     6. How It Works - Step Cards Active Highlight on Scroll
     -------------------------------------------------------------------------- */
  const stepCards = document.querySelectorAll('.step-card');
  if (stepCards.length > 0) {
    const observerOptions = {
      root: null,
      rootMargin: '-25% 0px -35% 0px',
      threshold: 0.15
    };

    const stepObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          stepCards.forEach(card => card.classList.remove('active'));
          entry.target.classList.add('active');
        }
      });
    }, observerOptions);

    stepCards.forEach(card => stepObserver.observe(card));
  }

  /* --------------------------------------------------------------------------
     7. Most Loved Destinations Continuous Smooth 3D Flip & Scroll Engine
     -------------------------------------------------------------------------- */
  const destTrack = document.getElementById('destinationsTrack');
  const destBgImages = document.querySelectorAll('.destinations-bg-img');
  const destCardItems = document.querySelectorAll('.dest-card-item');
  const destMarqueeTrack = document.getElementById('destMarqueeTrack');

  const countryNames = ['Japan', 'Switzerland', 'Italy', 'Indonesia'];
  let currentCountryIndex = -1;

  // Render marquee for active country
  const renderMarquee = (countryName) => {
    if (!destMarqueeTrack) return;
    let html = '';
    for (let i = 0; i < 16; i++) {
      html += `<span class="dest-marquee-item">${countryName}</span>`;
    }
    destMarqueeTrack.innerHTML = html;
  };

  renderMarquee(countryNames[0]);
  currentCountryIndex = 0;

  let targetScrollPos = 0; // Target destination position (0 to 3)
  let smoothScrollPos = 0; // Lerp interpolated destination position
  let isTicking = false;

  const updateDestinationVisuals = () => {
    // Silky smooth lerp interpolation with damping factor
    const diff = targetScrollPos - smoothScrollPos;
    if (Math.abs(diff) < 0.0004) {
      smoothScrollPos = targetScrollPos;
    } else {
      smoothScrollPos += diff * 0.09;
    }

    // Clamp smoothScrollPos in [0, 3]
    const clampedPos = Math.max(0, Math.min(3, smoothScrollPos));

    // Determine current base index and fractional progress between destinations
    let baseIndex = Math.floor(clampedPos);
    let frac = clampedPos - baseIndex;
    if (baseIndex >= 3) {
      baseIndex = 2;
      frac = 1.0;
    }

    // Determine which card and background are active (solid switch at 90° flip midpoint)
    let visibleCardIndex;
    let cardRotateX = 0;
    let cardTranslateY = 0;
    let cardScale = 1;
    let cardBrightness = 1;
    let isFullyLanded = false;

    if (clampedPos >= 3) {
      visibleCardIndex = 3;
      cardRotateX = 0;
      cardTranslateY = 0;
      cardScale = 1;
      cardBrightness = 1;
      isFullyLanded = true;
    } else if (frac < 0.5) {
      // First half of flip: outgoing card tilts forward/downward toward -90deg (solid, no fade)
      visibleCardIndex = baseIndex;
      const progress = frac / 0.5; // 0.0 to 1.0
      cardRotateX = -progress * 90; // 0deg down to -90deg
      cardTranslateY = -progress * 35; // px
      cardScale = 1 - progress * 0.08;
      cardBrightness = 1 - progress * 0.3;
      isFullyLanded = progress < 0.15;
    } else {
      // Second half of flip: incoming card enters from +90deg down to 0deg (solid, no fade)
      visibleCardIndex = baseIndex + 1;
      const progress = (frac - 0.5) / 0.5; // 0.0 to 1.0
      cardRotateX = (1 - progress) * 90; // 90deg down to 0deg
      cardTranslateY = (1 - progress) * 35; // px
      cardScale = 0.92 + progress * 0.08;
      cardBrightness = 0.7 + progress * 0.3;
      isFullyLanded = progress > 0.85;
    }

    // 1. Update 3D Cards — 100% solid, fully opaque, NO cross-fade
    destCardItems.forEach((cardItem, idx) => {
      if (idx === visibleCardIndex) {
        cardItem.style.transform = `perspective(1400px) rotateX(${cardRotateX.toFixed(2)}deg) translateY(${cardTranslateY.toFixed(1)}px) scale(${cardScale.toFixed(3)})`;
        cardItem.style.opacity = '1';
        cardItem.style.filter = `brightness(${cardBrightness.toFixed(2)})`;
        cardItem.style.visibility = 'visible';
        cardItem.classList.toggle('is-active', isFullyLanded);
        cardItem.classList.toggle('is-interactive', isFullyLanded);
        cardItem.style.zIndex = '5';
      } else {
        cardItem.style.opacity = '0';
        cardItem.style.visibility = 'hidden';
        cardItem.style.transform = idx < visibleCardIndex
          ? 'perspective(1400px) rotateX(-90deg) translateY(-35px) scale(0.92)'
          : 'perspective(1400px) rotateX(90deg) translateY(35px) scale(0.92)';
        cardItem.classList.remove('is-active', 'is-interactive');
        cardItem.style.zIndex = '1';
      }
    });

    // 2. Update Backgrounds — Solid crisp display, NO transparent cross-fade
    const activeBgIndex = visibleCardIndex;
    destBgImages.forEach((bg, idx) => {
      if (idx === activeBgIndex) {
        bg.style.opacity = '1';
        bg.style.visibility = 'visible';
        bg.style.zIndex = '1';
      } else {
        bg.style.opacity = '0';
        bg.style.visibility = 'hidden';
        bg.style.zIndex = '0';
      }
    });

    // 3. Update Marquee for the active country
    if (activeBgIndex !== currentCountryIndex) {
      currentCountryIndex = activeBgIndex;
      renderMarquee(countryNames[activeBgIndex]);
    }

    // Continue animation loop until settled
    if (smoothScrollPos !== targetScrollPos) {
      requestAnimationFrame(updateDestinationVisuals);
    } else {
      isTicking = false;
    }
  };

  const onDestScroll = () => {
    if (!destTrack) return;
    const rect = destTrack.getBoundingClientRect();
    const windowHeight = window.innerHeight;
    const scrollableDistance = rect.height - windowHeight;

    if (scrollableDistance <= 0) return;

    // Calculate scroll progress from 0 to 1
    const progress = Math.max(0, Math.min(1, -rect.top / scrollableDistance));

    // Map progress smoothly across the 4 destinations (0.0 to 3.0)
    targetScrollPos = progress * 3;

    if (!isTicking) {
      isTicking = true;
      requestAnimationFrame(updateDestinationVisuals);
    }
  };

  /* --------------------------------------------------------------------------
     8. Experience Section Swiper Infinite Carousel
     -------------------------------------------------------------------------- */
  const expSwiperContainer = document.querySelector('.experience-swiper');
  if (expSwiperContainer && typeof Swiper !== 'undefined') {
    const experienceSwiper = new Swiper('.experience-swiper', {
      slidesPerView: 'auto',
      spaceBetween: 10,
      loop: true,
      loopAdditionalSlides: 7,
      speed: 6000,
      autoplay: {
        delay: 0,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      freeMode: {
        enabled: true,
        momentum: false,
      },
      grabCursor: true,
      allowTouchMove: true,
      breakpoints: {
        320: {
          spaceBetween: 8,
        },
        640: {
          spaceBetween: 10,
        },
        1024: {
          spaceBetween: 10,
        },
      },
    });
  }

  window.addEventListener('scroll', onDestScroll, { passive: true });
  // Initial frame
  onDestScroll();
});



