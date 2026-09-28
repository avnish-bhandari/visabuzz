<?php
/**
 * study-global.php — Dynamic Study Destination Page
 * Serves all countries from CMS: ?country=uk|usa|canada|ireland|germany|dubai|france|europe|italy
 * Matches the university editorial design exactly.
 */

// ── DB ─────────────────────────────────────────────────────────────────────
require_once __DIR__ . '/cms/config/db.php';
$pdo = cms_pdo();

// ── URL param ──────────────────────────────────────────────────────────────
$slug = preg_replace('/[^a-z0-9-]/', '', strtolower(trim($_GET['country'] ?? 'uk')));

// ── Fetch destination ──────────────────────────────────────────────────────
$stmtD = $pdo->prepare("SELECT * FROM cms_destinations WHERE country_slug = ? AND is_active = 1 LIMIT 1");
$stmtD->execute([$slug]);
$dest = $stmtD->fetch();
if (!$dest) { header('Location: index.php'); exit; }

// ── Fetch all section fields ───────────────────────────────────────────────
$stmtS = $pdo->prepare("SELECT section_key, field_key, field_value FROM cms_destination_sections WHERE destination_id = ?");
$stmtS->execute([$dest['id']]);
$s = [];
foreach ($stmtS->fetchAll() as $r) {
    $s[$r['section_key']][$r['field_key']] = $r['field_value'];
}

// ── Helpers ────────────────────────────────────────────────────────────────
if (!function_exists('gs')) {
    function gs(array $s, string $sec, string $fld, string $def = ''): string {
        $val = $s[$sec][$fld] ?? '';
        return ($val !== '') ? $val : $def;
    }
}
if (!function_exists('gsj')) {
    function gsj(array $s, string $sec, string $fld, array $def = []): array {
        $v = $s[$sec][$fld] ?? '';
        return $v ? (json_decode($v, true) ?: $def) : $def;
    }
}
if (!function_exists('esc')) {
    function esc(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('safe_html')) {
    function safe_html(string $v): string {
        return strip_tags($v, '<p><br><b><strong><i><em><u><a><ul><ol><li><span>');
    }
}

// ── Country Display & Fast Facts ──────────────────────────────────────────
$countryClean = preg_replace('/^Study in\s+(the\s+)?/i', '', $dest['country_name'] ?? strtoupper($slug));
if (empty($countryClean)) {
    $countryClean = strtoupper($slug);
}

$destFactMap = [
    'uk' => [
        'intakes'   => 'Jan / Feb & Sep / Oct',
        'duration'  => '3 Yrs (UG) / 1 Yr (PG)',
        'psw'       => '2 - 3 Years (Graduate Route)',
        'work'      => 'Up to 20 hrs/week term time',
    ],
    'usa' => [
        'intakes'   => 'Fall (Aug) & Spring (Jan)',
        'duration'  => '4 Yrs (UG) / 2 Yrs (PG)',
        'psw'       => '1 - 3 Years (OPT / STEM OPT)',
        'work'      => 'Up to 20 hrs/week on-campus',
    ],
    'canada' => [
        'intakes'   => 'Fall (Sep), Winter (Jan), May',
        'duration'  => '3-4 Yrs (UG) / 1-2 Yrs (PG)',
        'psw'       => 'Up to 3 Years (PGWP)',
        'work'      => '20 - 24 hrs/week part-time',
    ],
    'germany' => [
        'intakes'   => 'Winter (Sep/Oct) & Summer (Mar/Apr)',
        'duration'  => '3 Yrs (UG) / 1.5 - 2 Yrs (PG)',
        'psw'       => '18 Months Job Seeking Visa',
        'work'      => '140 full days / 280 half days',
    ],
    'ireland' => [
        'intakes'   => 'Autumn (Sep) & Spring (Jan/Feb)',
        'duration'  => '3-4 Yrs (UG) / 1 Yr (PG)',
        'psw'       => '2 Years (Third Level Graduate)',
        'work'      => 'Up to 20 hrs/week term time',
    ],
    'dubai' => [
        'intakes'   => 'Sep, Jan & May',
        'duration'  => '3-4 Yrs (UG) / 1-2 Yrs (PG)',
        'psw'       => 'Post-Grad & Golden Visa Routes',
        'work'      => 'Part-time student work permitted',
    ],
    'france' => [
        'intakes'   => 'Sep / Oct & Jan / Feb',
        'duration'  => '3 Yrs (License) / 2 Yrs (Master)',
        'psw'       => '2 Years Post-Study Work Permit',
        'work'      => 'Up to 60% of annual hours',
    ],
    'italy' => [
        'intakes'   => 'September / October',
        'duration'  => '3 Yrs (UG) / 2 Yrs (PG)',
        'psw'       => '1 Year Permesso di Soggiorno',
        'work'      => 'Up to 20 hrs/week (1040 hrs/yr)',
    ],
    'europe' => [
        'intakes'   => 'Fall (Sep) & Spring (Feb)',
        'duration'  => '3 Yrs (UG) / 1 - 2 Yrs (PG)',
        'psw'       => '1 - 2 Years EU Job Seeker Route',
        'work'      => '20 hrs/week part-time allowed',
    ],
];

$defaultFacts = $destFactMap[$slug] ?? [
    'intakes'   => 'Jan / Feb & Sep / Oct',
    'duration'  => '3 Yrs (UG) / 1-2 Yrs (PG)',
    'psw'       => '1 - 3 Years Post-Study Work',
    'work'      => '20 hrs/week part-time work rights',
];

$curFacts = [
    'intakes'   => gs($s, 'hero', 'fact_intakes', $defaultFacts['intakes']),
    'duration'  => gs($s, 'hero', 'fact_duration', $defaultFacts['duration']),
    'psw'       => gs($s, 'hero', 'fact_psw', $defaultFacts['psw']),
    'work'      => gs($s, 'hero', 'fact_work', $defaultFacts['work']),
    'btn_label' => gs($s, 'hero', 'fact_btn_label', 'Check Eligibility & Options'),
    'btn_url'   => gs($s, 'hero', 'fact_btn_url', '#apply'),
];

// ── Parse JSON collections ─────────────────────────────────────────────────
$featureCards = gsj($s, 'features', 'cards_json', [
    [
        'icon'        => 'bulb',
        'title'       => 'Inspiring Student Life',
        'desc'        => 'We have focused on generating new knowledge & promoting.',
        'btn_label'   => 'Read More',
        'btn_url'     => '#',
        'is_featured' => false
    ],
    [
        'icon'        => 'grad',
        'title'       => 'Education Affordability',
        'desc'        => 'We have focused on generating new knowledge & promoting.',
        'btn_label'   => 'Read More',
        'btn_url'     => '#',
        'is_featured' => true
    ],
    [
        'icon'        => 'academic',
        'title'       => 'Core-level Academics solutions',
        'desc'        => 'We have focused on generating new knowledge & promoting.',
        'btn_label'   => 'Read More',
        'btn_url'     => '#',
        'is_featured' => false
    ]
]);

$testimonialCards = gsj($s, 'testimonials', 'cards_json', [
    [
        'title'         => 'A Truly Global Learning Experience',
        'quote'         => 'Studying here allowed me to connect with students from different cultures while gaining a strong academic foundation. The global exposure has truly shaped my career.',
        'author_name'   => 'Leslie Alexander',
        'author_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
        'rating'        => 5,
        'is_featured'   => true
    ],
    [
        'title'         => 'Education That Builds Confidence',
        'quote'         => 'The faculty support and hands-on learning approach helped me grow both academically and personally. I graduated with confidence and real-world skills.',
        'author_name'   => 'Leslie Alexander',
        'author_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
        'rating'        => 5,
        'is_featured'   => false
    ],
    [
        'title'         => 'A Campus That Feels Like Home',
        'quote'         => 'I feel confident knowing my child is learning in a safe and quality-driven institution.',
        'author_name'   => 'Jacob Jones',
        'author_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80',
        'rating'        => 5,
        'is_featured'   => false
    ],
    [
        'title'         => 'Preparing Students for Real Careers',
        'quote'         => 'The learning environment here is inspiring, diverse, and career-focused.',
        'author_name'   => 'Jacob Jones',
        'author_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80',
        'rating'        => 5,
        'is_featured'   => false
    ],
    [
        'title'         => 'Support Beyond the Classroom',
        'quote'         => 'A truly global university that prepares you for real-world challenges.',
        'author_name'   => 'Jacob Jones',
        'author_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80',
        'rating'        => 5,
        'is_featured'   => false
    ],
    [
        'title'         => 'A Future-Focused Institution',
        'quote'         => 'I feel confident knowing my child is learning in a safe and quality-driven institution.',
        'author_name'   => 'Ralph Edwards',
        'author_avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=150&q=80',
        'rating'        => 5,
        'is_featured'   => false
    ]
]);



$faqItems = gsj($s, 'faq', 'items_json', [
    [
        'question' => 'What programs does the university offer?',
        'answer'   => 'We offer a wide range of undergraduate, postgraduate, and research programs across multiple disciplines, designed to meet global academic and industry standards.'
    ],
    [
        'question' => 'How can I apply for admission?',
        'answer'   => 'Applications can be submitted directly through our online admissions portal. You will need to submit academic transcripts, proof of language proficiency, and recommendation letters.'
    ],
    [
        'question' => 'Are scholarships or financial aid available?',
        'answer'   => 'Yes, merit-based and need-based international scholarships are awarded each intake. Priority consideration is given to early applicants.'
    ],
    [
        'question' => 'Does the university provide on-campus accommodation?',
        'answer'   => 'Guaranteed on-campus university housing is available for all first-year international students who complete their accommodation booking before the priority deadline.'
    ],
    [
        'question' => 'What support services are available for students?',
        'answer'   => 'Our dedicated International Student Support team offers visa advisory, airport welcome services, career guidance, language support, and 24/7 student welfare assistance.'
    ]
]);

// ── SEO ────────────────────────────────────────────────────────────────────
$pageTitle = gs($s, 'seo', 'title',       "Study in {$dest['country_name']} — Visabuz");
$pageDesc  = gs($s, 'seo', 'description', "Complete guide to studying in {$dest['country_name']} with Visabuz.");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($pageTitle) ?></title>
  <meta name="description" content="<?= esc($pageDesc) ?>" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet" />
  <link href="https://api.fontshare.com/v2/css?f[]=cabinet-grotesk@500,700,800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/study-global.css" />
</head>

<body class="editorial-global-page">

  <?php include 'components/navbar.php'; ?>

  <main class="sg-page-canvas">

    <!-- ======================================================================
         1. HERO SECTION
         ====================================================================== -->
    <section class="sg-hero-section" style="background-image: url('<?= esc(gs($s, 'hero', 'img_main', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1600&q=80')) ?>');">
      <div class="sg-hero-overlay"></div>
      <div class="sg-container position-relative">
        <div class="sg-hero-grid">
          <!-- Left Info Column -->
          <div class="sg-hero-content">
            <?php
              $heroTitle = trim(strip_tags(gs($s, 'hero', 'title', 'Study in the UK')));
              if (preg_match('/^(Study in the|Study in|Study)\s+(.*)$/i', $heroTitle, $m)) {
                  $formattedTitle = esc($m[1]) . ' <span class="sg-title-accent">' . esc($m[2]) . '</span>';
              } elseif (preg_match('/^(.*?)\s+([A-Za-z0-9\-]+)$/', $heroTitle, $m)) {
                  $formattedTitle = esc($m[1]) . ' <span class="sg-title-accent">' . esc($m[2]) . '</span>';
              } else {
                  $formattedTitle = esc($heroTitle);
              }
            ?>
            <h1 class="sg-hero-title"><?= $formattedTitle ?></h1>

            <p class="sg-hero-subtitle">
              <?= safe_html(gs($s, 'hero', 'subtitle', 'Empowering students with world-class education, innovation, and global opportunities.')) ?>
            </p>

            <div class="sg-hero-ctas">
              <a href="<?= esc(gs($s, 'hero', 'cta1_url', '#apply')) ?>" class="sg-btn-primary">
                <?= esc(gs($s, 'hero', 'cta1_label', 'Apply Now')) ?> &#8599;
              </a>
              <a href="<?= esc(gs($s, 'hero', 'cta2_url', '#why-us')) ?>" class="sg-btn-secondary">
                <?= esc(gs($s, 'hero', 'cta2_label', 'Explore Campus')) ?>
              </a>
            </div>

            <div class="sg-hero-social-proof">
              <div class="sg-stat-highlight">
                <div class="sg-stat-number"><?= esc(gs($s, 'hero', 'stat_rate', '99%')) ?></div>
                <div class="sg-stat-caption"><?= esc(gs($s, 'hero', 'stat_rate_label', 'Our Success Rate')) ?></div>
              </div>

              <div class="sg-students-proof">
                <div class="sg-avatar-stack">
                  <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Student 1" />
                  <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" alt="Student 2" />
                  <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80" alt="Student 3" />
                </div>
                <div class="sg-students-label">
                  <strong><?= esc(gs($s, 'hero', 'stat_students', '30K')) ?></strong> <?= esc(gs($s, 'hero', 'stat_students_label', 'Total Students')) ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Highlights Column (No Images, Pure Glassmorphic SVG Card) -->
          <div class="sg-hero-card-col">
            <div class="sg-hero-highlights-card">
              <div class="sg-highlights-card-header">
                <div class="sg-highlights-card-tag">
                  <span class="sg-tag-pulse"></span>
                  <span>DESTINATION FAST FACTS</span>
                </div>
                <h3 class="sg-highlights-card-title"><?= esc($countryClean) ?> at a Glance</h3>
              </div>

              <div class="sg-highlights-card-body">
                <div class="sg-highlight-row">
                  <div class="sg-highlight-icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                      <line x1="16" y1="2" x2="16" y2="6"></line>
                      <line x1="8" y1="2" x2="8" y2="6"></line>
                      <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                  </div>
                  <div class="sg-highlight-info">
                    <span class="sg-highlight-label">Upcoming Intakes</span>
                    <span class="sg-highlight-value"><?= esc($curFacts['intakes']) ?></span>
                  </div>
                </div>

                <div class="sg-highlight-row">
                  <div class="sg-highlight-icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                      <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                    </svg>
                  </div>
                  <div class="sg-highlight-info">
                    <span class="sg-highlight-label">Course Duration</span>
                    <span class="sg-highlight-value"><?= esc($curFacts['duration']) ?></span>
                  </div>
                </div>

                <div class="sg-highlight-row">
                  <div class="sg-highlight-icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                      <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                  </div>
                  <div class="sg-highlight-info">
                    <span class="sg-highlight-label">Post-Study Work Visa</span>
                    <span class="sg-highlight-value"><?= esc($curFacts['psw']) ?></span>
                  </div>
                </div>

                <div class="sg-highlight-row">
                  <div class="sg-highlight-icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="12" cy="12" r="10"></circle>
                      <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                  </div>
                  <div class="sg-highlight-info">
                    <span class="sg-highlight-label">Student Work Rights</span>
                    <span class="sg-highlight-value"><?= esc($curFacts['work']) ?></span>
                  </div>
                </div>
              </div>

              <div class="sg-highlights-card-footer">
                <a href="<?= esc($curFacts['btn_url']) ?>" class="sg-highlights-btn">
                  <span><?= esc($curFacts['btn_label']) ?></span>
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M7 17L17 7M17 7H7M17 7V17"/>
                  </svg>
                </a>
                <div class="sg-highlights-guarantee">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#79cca8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5"/>
                  </svg>
                  <span>100% Free Profile Assessment &bull; Top University Partners</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         3. WHY CHOOSE US (Features Section)
         ====================================================================== -->
    <section class="sg-why-section" id="why-us">
      <div class="sg-container">
        <div class="sg-why-header">
          <h2 class="sg-why-title">
            <?= esc(gs($s, 'features', 'title', 'One of the largest, most diverse universities in the World')) ?>
          </h2>
          <p class="sg-why-subtitle">
            <?= safe_html(gs($s, 'features', 'subtitle', 'Home to students from every corner of the globe, fostering diversity, inclusion, and world-class academic excellence.')) ?>
          </p>
        </div>

        <div class="sg-features-grid">
          <?php foreach ($featureCards as $idx => $card):
            $isFeatured = !empty($card['is_featured']);
            $iconType   = $card['icon'] ?? ($idx === 1 ? 'grad' : ($idx === 2 ? 'academic' : 'bulb'));
          ?>
          <div class="sg-feature-card <?= $isFeatured ? 'is-featured' : '' ?>">
            <div class="sg-feature-icon-wrap">
              <?php if ($iconType === 'grad'): ?>
                <!-- Graduation Cap & Book / Affordability -->
                <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M32 8L6 22L32 36L58 22L32 8Z" stroke-width="2"/>
                  <path d="M14 26.5V42C14 42 22 48 32 48C42 48 50 42 50 42V26.5" stroke-width="2"/>
                  <path d="M58 22V38" stroke-width="2"/>
                  <circle cx="32" cy="54" r="5" stroke-width="2"/>
                  <path d="M30 54H34" stroke-width="2"/>
                </svg>
              <?php elseif ($iconType === 'academic'): ?>
                <!-- Lightbulb Torch / Academic Spark -->
                <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M32 10C24.27 10 18 16.27 18 24C18 29.8 21.5 34.8 26.5 37V42C26.5 43.1 27.4 44 28.5 44H35.5C36.6 44 37.5 43.1 37.5 42V37C42.5 34.8 46 29.8 46 24C46 16.27 39.73 10 32 10Z" stroke-width="2"/>
                  <path d="M28 48H36" stroke-width="2"/>
                  <path d="M30 52H34" stroke-width="2"/>
                  <path d="M32 2V6M54 24H58M6 24H10M47.5 8.5L44.5 11.5M16.5 8.5L19.5 11.5" stroke-width="2"/>
                </svg>
              <?php else: ?>
                <!-- Idea Bulb in Book / Inspiring Life -->
                <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 48C18 45 26 45 32 48C38 45 46 45 52 48V18C46 15 38 15 32 18C26 15 18 15 12 18V48Z" stroke-width="2"/>
                  <path d="M32 18V48" stroke-width="2"/>
                  <circle cx="32" cy="28" r="7" stroke-width="2"/>
                  <path d="M32 21V23M32 33V35M25 28H27M37 28H39" stroke-width="2"/>
                </svg>
              <?php endif; ?>
            </div>
            <h3 class="sg-feature-title"><?= esc($card['title'] ?? '') ?></h3>
            <p class="sg-feature-desc"><?= esc($card['desc'] ?? '') ?></p>
            <a href="<?= esc($card['btn_url'] ?? '#apply') ?>" class="sg-feature-btn">
              <?= esc($card['btn_label'] ?? 'Read More') ?> &#8599;
            </a>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         2. ABOUT / POTENTIAL SECTION (Dark Forest Green)
         ====================================================================== -->
    <section class="sg-about-section">
      <div class="sg-container">
        <div class="sg-about-grid">

          <!-- Left Column -->
          <div class="sg-about-left">
            <div class="sg-about-graduates-frame">
              <img src="<?= esc(gs($s, 'about', 'img_left', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=900&q=80')) ?>"
                   alt="Graduates with Diplomas" loading="lazy" />
            </div>
            <div class="sg-about-metrics-row">
              <div class="sg-about-metric-col">
                <div class="sg-about-metric-val"><?= esc(gs($s, 'about', 'stat1_pct', '30%')) ?></div>
                <div class="sg-about-metric-text"><?= esc(gs($s, 'about', 'stat1_label', 'Daily Growing Students are still grinding')) ?></div>
                <div class="sg-metric-progress-track">
                  <div class="sg-metric-progress-bar" style="width: <?= esc(intval(gs($s, 'about', 'stat1_pct', '30'))) ?>%;"></div>
                </div>
              </div>
              <div class="sg-about-metric-col">
                <div class="sg-about-metric-val"><?= esc(gs($s, 'about', 'stat2_pct', '95%')) ?></div>
                <div class="sg-about-metric-text"><?= esc(gs($s, 'about', 'stat2_label', 'They are in a job related to their field of study')) ?></div>
                <div class="sg-metric-progress-track">
                  <div class="sg-metric-progress-bar" style="width: <?= esc(intval(gs($s, 'about', 'stat2_pct', '95'))) ?>%;"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column -->
          <div class="sg-about-right">
            <h2 class="sg-about-heading">
              <?= esc(gs($s, 'about', 'heading', 'The right opportunity can turn dreams into limitless potential.')) ?>
            </h2>
            <div class="sg-about-desc">
              <?= safe_html(gs($s, 'about', 'desc', 'Founded in 1999, NUOVA EDILE COSTANZA is a community - driven institution renowned for it\'s unique contributions.')) ?>
            </div>
            <div class="sg-about-tossing-frame">
              <img src="<?= esc(gs($s, 'about', 'img_right', 'https://images.unsplash.com/photo-1525921429624-479b6a26d84d?auto=format&fit=crop&w=900&q=80')) ?>"
                   alt="Graduates Tossing Caps" loading="lazy" />
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ======================================================================
         4. TESTIMONIALS SECTION ("Voices From Our Global Community")
         ====================================================================== -->
    <section class="sg-testimonials-section">
      <div class="sg-container">
        <div class="sg-testimonials-header">
          <h2 class="sg-testimonials-title">
            <?= esc(gs($s, 'testimonials', 'title', 'Voices From Our Global Community')) ?>
          </h2>
        </div>

        <?php
          $topTwo = array_slice($testimonialCards, 0, 2);
          $bottomFour = array_slice($testimonialCards, 2);
        ?>

        <!-- Top 2 Big Cards -->
        <?php if (!empty($topTwo)): ?>
        <div class="sg-testi-top-row">
          <?php foreach ($topTwo as $idx => $t):
            $isFeatured = !empty($t['is_featured']) || ($idx === 0);
          ?>
          <div class="sg-testi-card-lg <?= $isFeatured ? 'is-featured' : '' ?>">
            <div class="sg-testi-top-content">
              <div class="sg-testi-quote-mark">&ldquo;&rdquo;</div>
              <h3 class="sg-testi-card-title"><?= esc($t['title'] ?? '') ?></h3>
              <p class="sg-testi-quote-body">&ldquo;<?= esc($t['quote'] ?? '') ?>&rdquo;</p>
            </div>
            <div class="sg-testi-footer">
              <div class="sg-testi-author-info">
                <img src="<?= esc($t['author_avatar'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80') ?>"
                     alt="<?= esc($t['author_name'] ?? 'Student') ?>" class="sg-testi-author-avatar" loading="lazy" />
                <div class="sg-testi-author-meta">
                  <span class="sg-testi-author-name"><?= esc($t['author_name'] ?? 'Student') ?></span>
                  <span class="sg-testi-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                </div>
              </div>
              <button type="button" class="sg-testi-dots-btn" aria-label="More options">&hellip;</button>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Bottom 4 Small Cards -->
        <?php if (!empty($bottomFour)): ?>
        <div class="sg-testi-bottom-row">
          <?php foreach ($bottomFour as $t): ?>
          <div class="sg-testi-card-sm">
            <div class="sg-testi-top-content">
              <div class="sg-testi-quote-mark">&ldquo;&rdquo;</div>
              <h4 class="sg-testi-card-title"><?= esc($t['title'] ?? '') ?></h4>
              <p class="sg-testi-quote-body">&ldquo;<?= esc($t['quote'] ?? '') ?>&rdquo;</p>
            </div>
            <div class="sg-testi-footer">
              <div class="sg-testi-author-info">
                <img src="<?= esc($t['author_avatar'] ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80') ?>"
                     alt="<?= esc($t['author_name'] ?? 'Student') ?>" class="sg-testi-author-avatar" loading="lazy" />
                <div class="sg-testi-author-meta">
                  <span class="sg-testi-author-name"><?= esc($t['author_name'] ?? 'Student') ?></span>
                  <span class="sg-testi-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                </div>
              </div>
              <button type="button" class="sg-testi-dots-btn" aria-label="More options">&hellip;</button>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

      </div>
    </section>

    <!-- ======================================================================
         5. FREQUENTLY ASKED QUESTIONS (FAQ)
         ====================================================================== -->
    <section class="sg-faq-section" id="faq">
      <div class="sg-container">
        <div class="sg-faq-header">
          <h2 class="sg-faq-title">
            <?= esc(gs($s, 'faq', 'title', 'Frequently Asked Questions?')) ?>
          </h2>
        </div>

        <div class="sg-faq-grid">
          <!-- Left Facade Photo -->
          <div class="sg-faq-facade-card">
            <img src="<?= esc(gs($s, 'faq', 'img_url', 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=900&q=80')) ?>"
                 alt="University Historic Building" loading="lazy" />
          </div>

          <!-- Right Accordion List -->
          <div class="sg-faq-accordion-list">
            <?php foreach ($faqItems as $idx => $faq):
              $isOpen = ($idx === 0);
            ?>
            <div class="sg-faq-item <?= $isOpen ? 'is-open' : '' ?>">
              <button type="button" class="sg-faq-trigger" aria-expanded="<?= $isOpen ? 'true' : 'false' ?>">
                <span><?= esc($faq['question'] ?? '') ?></span>
                <span class="sg-faq-icon-indicator"><?= $isOpen ? '&minus;' : '+' ?></span>
              </button>
              <div class="sg-faq-body">
                <p><?= esc($faq['answer'] ?? '') ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="js/script.js"></script>

  <!-- FAQ Accordion Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const faqItems = document.querySelectorAll('.sg-faq-item');
      faqItems.forEach(item => {
        const trigger = item.querySelector('.sg-faq-trigger');
        const indicator = item.querySelector('.sg-faq-icon-indicator');
        trigger.addEventListener('click', function () {
          const isOpen = item.classList.contains('is-open');
          // Close all other items
          faqItems.forEach(other => {
            other.classList.remove('is-open');
            const otherTrig = other.querySelector('.sg-faq-trigger');
            const otherInd = other.querySelector('.sg-faq-icon-indicator');
            if (otherTrig) otherTrig.setAttribute('aria-expanded', 'false');
            if (otherInd) otherInd.innerHTML = '+';
          });
          // Toggle current
          if (!isOpen) {
            item.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
            if (indicator) indicator.innerHTML = '&minus;';
          }
        });
      });
    });
  </script>

</body>
</html>
