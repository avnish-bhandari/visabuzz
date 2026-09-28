<?php
/**
 * profile.php — CMS Administrator Profile & Team Access Control ("Rizz" SaaS Theme)
 * 100% relevant to Visabuz Visa & Immigration Consultancy CMS:
 * - Top Hero Banner: Live CMS metrics (Destinations, Client Reviews, Team Members, CMS Health)
 * - Left Column: Administrator Information, Visa scopes, official contacts & offices
 * - Right Column: Underline tabs (Overview & Notes, Destination Media, Settings, Team & Access)
 * - Strict design rules: Pure SVG icons only, ZERO emojis, font weight <= 500
 */
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
cms_require_auth();

$pdo = cms_pdo();
$userId = (int)($_SESSION['cms_user_id'] ?? 1);
$isAdmin = cms_is_admin();

// Fetch current user row
$stmt = $pdo->prepare("SELECT * FROM cms_users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $stmt = $pdo->query("SELECT * FROM cms_users LIMIT 1");
    $user = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

// Live CMS metrics for profile hero & overview
$destCount  = (int)$pdo->query("SELECT COUNT(*) FROM cms_destinations WHERE is_active = 1")->fetchColumn();
$testiCount = (int)$pdo->query("SELECT COUNT(*) FROM cms_testimonials WHERE is_active = 1")->fetchColumn();
$teamCount  = (int)$pdo->query("SELECT COUNT(*) FROM cms_users WHERE status = 'active'")->fetchColumn();

// CMS & Visabuz context defaults
$fullName   = !empty($user['full_name'])  ? $user['full_name']  : ($user['role'] === 'admin' ? 'Admin' : 'Team Member');
$email      = !empty($user['email'])      ? $user['email']      : ($user['role'] === 'admin' ? 'admin@visabuz.com' : 'user@visabuz.com');
$phone      = !empty($user['phone'])      ? $user['phone']      : '+91 73890 40152';
$position   = !empty($user['position'])   ? $user['position']   : ($user['role'] === 'admin' ? 'Super Administrator & Lead Consultant' : 'Team Member');
$education  = !empty($user['education'])  ? $user['education']  : 'Visabuz Visa Operations';
$languages  = !empty($user['languages'])  ? $user['languages']  : 'UK, Canada, Australia, Europe, USA';
$birthDate  = !empty($user['birth_date']) ? $user['birth_date'] : 'Noida Sector 142 and Paris';
$avatarUrl  = !empty($user['avatar_url']) ? $user['avatar_url'] : 'assets/profile_avatar.jpg';
$avatarDisplay = (str_starts_with($avatarUrl, 'http://') || str_starts_with($avatarUrl, 'https://')) ? $avatarUrl : $cmsRoot . $avatarUrl;

$defaultBio = 'Super Administrator overseeing the Visabuz Visa & Immigration consultancy portal. Directing overseas study programs, country destination guides, client reviews, SEO configurations, and team access permissions.';
$bio = !empty($user['bio']) ? $user['bio'] : $defaultBio;

$defaultSkills = 'Visa Advisory, Study Abroad, PR & Immigration, University Admissions, Content Operations, Portal Access Control';
$skillsStr = !empty($user['skills']) && !str_contains($user['skills'], 'Javascript') ? $user['skills'] : $defaultSkills;
$skillsList = array_filter(array_map('trim', explode(',', $skillsStr)));

// Master list of controllable CMS tabs
$allPermittedSlugs = [
    'dashboard'           => 'Dashboard',
    'home'                => 'Home Page',
    'destinations'        => 'Destinations',
    'destination-content' => 'Study Pages Content',
    'services'            => 'Visa Services',
    'testimonials'        => 'Testimonials',
    'nav'                 => 'Navigation',
    'footer-editor'       => 'Footer Editor',
    'seo'                 => 'SEO Manager',
];

// Fetch all users for Admin
$allUsers = [];
if ($isAdmin) {
    $allUsers = $pdo->query("SELECT * FROM cms_users ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
}

$pageTitle    = 'Profile';
$pageSlug     = 'profile';
$pageSubtitle = $isAdmin ? 'Admin Profile & Team Access Control' : 'User Profile & Settings';
$cmsRoot      = '../';

require_once dirname(__DIR__) . '/includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════
     TOP PROFILE HERO BANNER (100% CMS RELATED)
═══════════════════════════════════════════════════════ -->
<div class="cms-profile-banner">
  <!-- Avatar & Name / Role -->
  <div class="cms-profile-hero-left">
    <div class="cms-profile-avatar-wrap">
      <img src="<?= htmlspecialchars($avatarDisplay) ?>" alt="<?= htmlspecialchars($fullName) ?>" class="cms-profile-avatar" id="heroAvatarImg" />
      <button type="button" class="cms-avatar-badge" title="Change Avatar" onclick="switchProfileTab('settings'); document.getElementById('field_avatar_url')?.focus();">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
          <circle cx="12" cy="13" r="3"/>
        </svg>
      </button>
    </div>
    <div class="cms-profile-hero-meta">
      <h2 class="cms-profile-name" id="heroFullName"><?= htmlspecialchars($fullName) ?></h2>
      <div class="cms-profile-role" id="heroPosition"><?= htmlspecialchars($position) ?></div>
    </div>
  </div>

  <!-- Center Metric Boxes (Live CMS Data) -->
  <div class="cms-profile-hero-stats">
    <div class="cms-profile-stat-box">
      <div class="cms-profile-stat-num"><?= $destCount ?></div>
      <div class="cms-profile-stat-label">Destinations</div>
    </div>
    <div class="cms-profile-stat-box">
      <div class="cms-profile-stat-num"><?= $testiCount ?></div>
      <div class="cms-profile-stat-label">Client Reviews</div>
    </div>
    <div class="cms-profile-stat-box">
      <div class="cms-profile-stat-num"><?= $teamCount ?></div>
      <div class="cms-profile-stat-label">Team Members</div>
    </div>
  </div>

  <!-- Radial CMS Health Gauge -->
  <div class="cms-profile-radial-wrap" title="CMS Portal Status: 100% Operational">
    <svg width="84" height="84" viewBox="0 0 84 84" style="transform: rotate(-90deg);">
      <circle cx="42" cy="42" r="34" stroke="#e2e8f0" stroke-width="7" fill="none" />
      <circle cx="42" cy="42" r="34" stroke="#22c55e" stroke-width="7" stroke-dasharray="213.6" stroke-dashoffset="0" stroke-linecap="round" fill="none" />
    </svg>
    <div class="cms-profile-radial-text" style="color:#16a34a;">100%</div>
    <div class="cms-profile-radial-label">CMS Health</div>
  </div>

  <!-- Hero Actions (CMS Specific) -->
  <div class="cms-profile-actions">
    <a href="<?= htmlspecialchars($_ENV['APP_URL'] ?? '/') ?>" target="_blank" class="cms-btn cms-btn-primary" style="gap:8px;">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>
      </svg>
      Live Website
    </a>
    <button type="button" class="cms-btn cms-btn-secondary" onclick="switchProfileTab('settings')" style="gap:8px;">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="3"/>
        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
      </svg>
      Edit Settings
    </button>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     2-COLUMN LOWER LAYOUT
═══════════════════════════════════════════════════════ -->
<div class="cms-profile-layout">

  <!-- LEFT: Administrator Information Card -->
  <div class="cms-card">
    <div class="cms-profile-card-header">
      <div class="cms-profile-card-title">Administrator Information</div>
      <button type="button" class="cms-profile-edit-link" onclick="switchProfileTab('settings')" title="Edit Information">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
          <path d="m15 5 4 4"/>
        </svg>
        Edit
      </button>
    </div>

    <!-- Bio text -->
    <p class="cms-profile-bio" id="infoBio"><?= htmlspecialchars($bio) ?></p>

    <!-- Skills / Scope pills -->
    <div class="cms-skills-wrap" id="infoSkillsList">
      <?php foreach ($skillsList as $sk): ?>
        <span class="cms-skill-pill"><?= htmlspecialchars($sk) ?></span>
      <?php endforeach; ?>
    </div>

    <!-- Meta Details List (CMS & Consultancy Details) -->
    <div class="cms-meta-list">
      <div class="cms-meta-item">
        <span class="cms-meta-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
          </svg>
        </span>
        <div><span class="cms-meta-label">Position :</span> <span class="cms-meta-val" id="infoPosition"><?= htmlspecialchars($position) ?></span></div>
      </div>

      <div class="cms-meta-item">
        <span class="cms-meta-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 21h18"/>
            <path d="M5 21V7l8-4v18"/>
            <path d="M19 21V11l-6-3"/>
            <path d="M9 9v.01"/>
            <path d="M9 12v.01"/>
            <path d="M9 15v.01"/>
            <path d="M9 18v.01"/>
          </svg>
        </span>
        <div><span class="cms-meta-label">Department :</span> <span class="cms-meta-val" id="infoEducation"><?= htmlspecialchars($education) ?></span></div>
      </div>

      <div class="cms-meta-item">
        <span class="cms-meta-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="2" y1="12" x2="22" y2="12"/>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
          </svg>
        </span>
        <div><span class="cms-meta-label">Coverage :</span> <span class="cms-meta-val" id="infoLanguages"><?= htmlspecialchars($languages) ?></span></div>
      </div>

      <div class="cms-meta-item">
        <span class="cms-meta-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
        </span>
        <div><span class="cms-meta-label">Offices :</span> <span class="cms-meta-val" id="infoBirthDate"><?= htmlspecialchars($birthDate) ?></span></div>
      </div>

      <div class="cms-meta-item">
        <span class="cms-meta-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
          </svg>
        </span>
        <div><span class="cms-meta-label">Phone :</span> <span class="cms-meta-val" id="infoPhone"><?= htmlspecialchars($phone) ?></span></div>
      </div>

      <div class="cms-meta-item">
        <span class="cms-meta-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="20" height="16" x="2" y="4" rx="2"/>
            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
          </svg>
        </span>
        <div><span class="cms-meta-label">Email :</span> <span class="cms-meta-val" id="infoEmail"><?= htmlspecialchars($email) ?></span></div>
      </div>
    </div>

    <!-- Official Links & Socials -->
    <div class="cms-profile-socials">
      <a href="https://facebook.com" target="_blank" rel="noopener" class="cms-social-icon-btn" style="background:#1877f2;" title="Facebook">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
          <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
        </svg>
      </a>
      <a href="https://twitter.com" target="_blank" rel="noopener" class="cms-social-icon-btn" style="background:#0f172a;" title="X (Twitter)">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
          <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>
      </a>
      <a href="https://linkedin.com" target="_blank" rel="noopener" class="cms-social-icon-btn" style="background:#0a66c2;" title="LinkedIn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
          <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
          <rect width="4" height="12" x="2" y="9"/>
          <circle cx="4" cy="4" r="2"/>
        </svg>
      </a>
    </div>
  </div>

  <!-- RIGHT: Tabs & Tab Content -->
  <div>
    <!-- Navigation Underline Tabs -->
    <ul class="cms-tabs" role="tablist">
      <li>
        <button type="button" class="cms-tab-btn active" data-tab="overview" onclick="switchProfileTab('overview')">Overview & Notes</button>
      </li>
      <li>
        <button type="button" class="cms-tab-btn" data-tab="gallery" onclick="switchProfileTab('gallery')">Destination Media</button>
      </li>
      <li>
        <button type="button" class="cms-tab-btn" data-tab="settings" onclick="switchProfileTab('settings')">Account Settings</button>
      </li>
      <?php if ($isAdmin): ?>
      <li>
        <button type="button" class="cms-tab-btn" data-tab="access" onclick="switchProfileTab('access')">Team & Access</button>
      </li>
      <?php endif; ?>
    </ul>

    <!-- ── TAB PANE: OVERVIEW & NOTES ───────────────────────── -->
    <div class="cms-tab-pane active" id="pane-overview">
      <!-- Mini Stat Cards Row (Live CMS Metrics) -->
      <div class="cms-profile-post-stats">
        <div class="cms-stat-mini-card">
          <div class="cms-stat-mini-top">
            <div>
              <div class="cms-stat-mini-lbl">Live Destinations</div>
              <div class="cms-stat-mini-num"><?= $destCount ?> <span style="font-size:16px;font-weight:400;color:var(--text-muted);">Active</span></div>
            </div>
            <div class="cms-stat-mini-icon" style="background:#ecfdf5;color:#10b981;">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
              </svg>
            </div>
          </div>
          <div class="cms-stat-mini-sub">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span><strong style="font-weight:500;color:var(--text-primary);"><?= $destCount ?></strong> Country pathways active on website</span>
          </div>
        </div>

        <div class="cms-stat-mini-card">
          <div class="cms-stat-mini-top">
            <div>
              <div class="cms-stat-mini-lbl">Published Testimonials</div>
              <div class="cms-stat-mini-num"><?= $testiCount ?> <span style="font-size:16px;font-weight:400;color:var(--text-muted);">Verified</span></div>
            </div>
            <div class="cms-stat-mini-icon" style="background:#fffbeb;color:#f59e0b;">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
              </svg>
            </div>
          </div>
          <div class="cms-stat-mini-sub">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
            </svg>
            <span><strong style="font-weight:500;color:var(--text-primary);"><?= $testiCount ?></strong> Client success stories online</span>
          </div>
        </div>
      </div>

      <!-- Team Announcement & Operational Notes Composer -->
      <div class="cms-post-box">
        <div class="cms-post-header">
          <div class="cms-post-author">
            <img src="<?= $cmsRoot . htmlspecialchars($avatarUrl) ?>" alt="Author" class="cms-post-author-avatar" />
            <div>
              <div class="cms-post-author-name"><?= htmlspecialchars($fullName) ?></div>
              <div class="cms-post-author-status">
                <span class="cms-post-status-dot"></span>
                <span><?= htmlspecialchars($position) ?></span>
              </div>
            </div>
          </div>

          <!-- Tool Icons -->
          <div class="cms-post-tools">
            <button type="button" class="cms-post-tool-btn" title="Add Media" onclick="Toast.show('Attach media selected', 'info')">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                <circle cx="9" cy="9" r="2"/>
                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
              </svg>
            </button>
            <button type="button" class="cms-post-tool-btn" title="Attach Document" onclick="Toast.show('Attach file selected', 'info')">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
              </svg>
            </button>
            <button type="button" class="cms-post-tool-btn" title="Schedule Event" onclick="Toast.show('Schedule event selected', 'info')">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                <line x1="16" x2="16" y1="2" y2="6"/>
                <line x1="8" x2="8" y1="2" y2="6"/>
                <line x1="3" x2="21" y1="10" y2="10"/>
              </svg>
            </button>
            <button type="button" class="cms-post-tool-btn" title="Options" onclick="Toast.show('More options', 'info')">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="1"/>
                <circle cx="12" cy="5" r="1"/>
                <circle cx="12" cy="19" r="1"/>
              </svg>
            </button>
          </div>
        </div>

        <textarea id="quickPostText" class="cms-post-textarea" placeholder="Write an announcement, operational note, or task for team members..."></textarea>

        <div class="cms-post-footer">
          <button type="button" class="cms-btn cms-btn-primary" onclick="publishQuickPost()">Post Announcement</button>
        </div>
      </div>
    </div>

    <!-- ── TAB PANE: DESTINATION MEDIA ────────────────────── -->
    <div class="cms-tab-pane" id="pane-gallery">
      <div class="cms-card">
        <div class="cms-card-header">
          <div>
            <div class="cms-card-title">Destination Guides & Media Portfolio</div>
            <div class="cms-card-subtitle">Visual showcases and guides published across study abroad destinations</div>
          </div>
        </div>
        <div class="cms-gallery-grid">
          <div class="cms-gallery-item">
            <img src="<?= $cmsRoot ?>../assets/images/study-uk.jpg" alt="United Kingdom" class="cms-gallery-img" onerror="this.src='<?= $cmsRoot ?>assets/profile_avatar.jpg'" />
            <div class="cms-gallery-caption">United Kingdom Study Guide</div>
          </div>
          <div class="cms-gallery-item">
            <img src="<?= $cmsRoot ?>../assets/images/study-canada.jpg" alt="Canada" class="cms-gallery-img" onerror="this.src='<?= $cmsRoot ?>assets/profile_avatar.jpg'" />
            <div class="cms-gallery-caption">Canada Immigration & PR</div>
          </div>
          <div class="cms-gallery-item">
            <img src="<?= $cmsRoot ?>../assets/images/study-australia.jpg" alt="Australia" class="cms-gallery-img" onerror="this.src='<?= $cmsRoot ?>assets/profile_avatar.jpg'" />
            <div class="cms-gallery-caption">Australia Student Route</div>
          </div>
          <div class="cms-gallery-item">
            <img src="<?= $cmsRoot ?>../assets/images/study-germany.jpg" alt="Germany" class="cms-gallery-img" onerror="this.src='<?= $cmsRoot ?>assets/profile_avatar.jpg'" />
            <div class="cms-gallery-caption">Germany Pathways & Jobs</div>
          </div>
          <div class="cms-gallery-item">
            <img src="<?= $cmsRoot ?>../assets/images/study-usa.jpg" alt="USA" class="cms-gallery-img" onerror="this.src='<?= $cmsRoot ?>assets/profile_avatar.jpg'" />
            <div class="cms-gallery-caption">USA Higher Education</div>
          </div>
          <div class="cms-gallery-item">
            <img src="<?= $cmsRoot ?>assets/profile_avatar.jpg" alt="Team Design" class="cms-gallery-img" />
            <div class="cms-gallery-caption">Visa Consultation Team</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── TAB PANE: SETTINGS ─────────────────────────────── -->
    <div class="cms-tab-pane" id="pane-settings">
      <!-- Edit Profile Card -->
      <div class="cms-card">
        <div class="cms-card-header">
          <div>
            <div class="cms-card-title">Edit Profile & Contact Details</div>
            <div class="cms-card-subtitle">Update administrator identity, contact information, department, and scope</div>
          </div>
        </div>

        <form id="profileForm" onsubmit="handleProfileSubmit(event)">
          <input type="hidden" name="action" value="update_profile" />

          <div class="cms-input-row">
            <div class="cms-form-group">
              <label class="cms-label" for="field_full_name">Full Name</label>
              <input type="text" id="field_full_name" name="full_name" class="cms-input" value="<?= htmlspecialchars($fullName) ?>" required />
            </div>

            <div class="cms-form-group">
              <label class="cms-label" for="field_position">Position / Title</label>
              <input type="text" id="field_position" name="position" class="cms-input" value="<?= htmlspecialchars($position) ?>" placeholder="e.g. Super Administrator & Lead Consultant" />
            </div>
          </div>

          <div class="cms-input-row">
            <div class="cms-form-group">
              <label class="cms-label" for="field_email">Official Email</label>
              <input type="email" id="field_email" name="email" class="cms-input" value="<?= htmlspecialchars($email) ?>" required />
            </div>

            <div class="cms-form-group">
              <label class="cms-label" for="field_phone">Official Phone</label>
              <input type="text" id="field_phone" name="phone" class="cms-input" value="<?= htmlspecialchars($phone) ?>" />
            </div>
          </div>

          <div class="cms-input-row">
            <div class="cms-form-group">
              <label class="cms-label" for="field_education">Department / Operations Unit</label>
              <input type="text" id="field_education" name="education" class="cms-input" value="<?= htmlspecialchars($education) ?>" placeholder="e.g. Visabuz Visa Operations" />
            </div>

            <div class="cms-form-group">
              <label class="cms-label" for="field_languages">Coverage Regions</label>
              <input type="text" id="field_languages" name="languages" class="cms-input" value="<?= htmlspecialchars($languages) ?>" placeholder="e.g. UK, Canada, Australia, Europe, USA" />
            </div>
          </div>

          <div class="cms-input-row">
            <div class="cms-form-group">
              <label class="cms-label" for="field_birth_date">Office Locations</label>
              <input type="text" id="field_birth_date" name="birth_date" class="cms-input" value="<?= htmlspecialchars($birthDate) ?>" placeholder="e.g. Noida Sector 142 & Paris" />
            </div>

            <div class="cms-form-group">
              <label class="cms-label" for="field_skills">Scopes & Focus Areas (Comma-separated)</label>
              <input type="text" id="field_skills" name="skills" class="cms-input" value="<?= htmlspecialchars($skillsStr) ?>" placeholder="e.g. Visa Advisory, Study Abroad, PR & Immigration" />
            </div>
          </div>

          <div class="cms-form-group">
            <label class="cms-label" for="field_avatar_url">Profile Avatar</label>
            <div class="cms-image-upload-wrap">
              <div class="cms-image-preview-box is-avatar" id="box_profile_avatar" style="width:52px; height:52px;">
                <img id="prev_profile_avatar" src="<?= htmlspecialchars($avatarDisplay) ?>" alt="Avatar" style="<?= !empty($avatarUrl) ? 'display:block;' : 'display:none;' ?>" />
                <div class="cms-upload-empty" id="empty_profile_avatar" style="<?= empty($avatarUrl) ? 'display:block;' : 'display:none;' ?>">No Img</div>
              </div>
              <div class="cms-upload-content" style="flex:1;">
                <div class="cms-upload-actions">
                  <label class="cms-upload-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <span><?= !empty($avatarUrl) ? 'Change Avatar' : 'Upload Avatar' ?></span>
                    <input type="file" accept="image/*" style="display:none;" onchange="cmsUploadFile(this, 'field_avatar_url', 'prev_profile_avatar', function(json) { const heroImg = document.getElementById('heroAvatarImg'); if (heroImg) heroImg.src = json.url.startsWith('http') ? json.url : ('../' + json.url); })" />
                  </label>
                  <button type="button" class="cms-remove-img-btn" onclick="cmsRemoveImage('field_avatar_url', 'prev_profile_avatar', function() { const heroImg = document.getElementById('heroAvatarImg'); if (heroImg) heroImg.src = ''; })">Remove</button>
                </div>
                <div style="font-size:12px; color:var(--text-muted); margin-top:6px;">Upload personal avatar photo (JPG, PNG, WebP)</div>
              </div>
              <input type="hidden" id="field_avatar_url" name="avatar_url" class="cms-input" value="<?= htmlspecialchars($avatarUrl) ?>" />
            </div>
          </div>

          <div class="cms-form-group">
            <label class="cms-label" for="field_bio">Administrative Overview & Bio</label>
            <textarea id="field_bio" name="bio" class="cms-textarea" rows="4"><?= htmlspecialchars($bio) ?></textarea>
          </div>

          <div style="display:flex;justify-content:flex-end;">
            <button type="submit" class="cms-btn cms-btn-primary" id="saveProfileBtn">Save Changes</button>
          </div>
        </form>
      </div>

      <!-- Change Password Card -->
      <div class="cms-card">
        <div class="cms-card-header">
          <div>
            <div class="cms-card-title">Security & Password</div>
            <div class="cms-card-subtitle">Change your account login credentials securely</div>
          </div>
        </div>

        <form id="passwordForm" onsubmit="handlePasswordSubmit(event)">
          <input type="hidden" name="action" value="change_password" />

          <div class="cms-form-group">
            <label class="cms-label" for="field_current_password">Current Password</label>
            <input type="password" id="field_current_password" name="current_password" class="cms-input" required />
          </div>

          <div class="cms-input-row">
            <div class="cms-form-group">
              <label class="cms-label" for="field_new_password">New Password</label>
              <input type="password" id="field_new_password" name="new_password" class="cms-input" minlength="6" required />
            </div>

            <div class="cms-form-group">
              <label class="cms-label" for="field_confirm_password">Confirm New Password</label>
              <input type="password" id="field_confirm_password" name="confirm_password" class="cms-input" minlength="6" required />
            </div>
          </div>

          <div style="display:flex;justify-content:flex-end;">
            <button type="submit" class="cms-btn cms-btn-primary" id="savePassBtn">Update Password</button>
          </div>
        </form>
      </div>
    </div>

    <?php if ($isAdmin): ?>
    <!-- ── TAB PANE: ACCESS & TEAM (ADMIN ONLY) ───────────── -->
    <div class="cms-tab-pane" id="pane-access">

      <!-- Header Card with Add User Button -->
      <div class="cms-card">
        <div class="cms-card-header">
          <div>
            <div class="cms-card-title">Team Management & Access Permissions</div>
            <div class="cms-card-subtitle">Allow team members to log in with their email & OTP, and configure which tabs they can see or edit.</div>
          </div>
          <button type="button" class="cms-btn cms-btn-primary cms-btn-sm" onclick="toggleAddMemberForm()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="5" x2="12" y2="19"/>
              <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Team Member
          </button>
        </div>

        <!-- Add Member Form (Collapsible) -->
        <div id="addMemberCard" style="display:none;background:#f8fafc;border:1px dashed #cbd5e1;border-radius:var(--radius-md);padding:24px;margin-bottom:24px;">
          <h3 style="font-size:16px;font-weight:500;margin-bottom:16px;color:var(--text-primary);">Invite New Team Member</h3>
          <form id="addMemberForm" onsubmit="handleAddMemberSubmit(event)">
            <input type="hidden" name="action" value="add_user" />

            <div class="cms-input-row">
              <div class="cms-form-group">
                <label class="cms-label">Account Email (used for OTP sign-in) *</label>
                <input type="email" name="email" class="cms-input" placeholder="member@visabuz.com" required />
              </div>
              <div class="cms-form-group">
                <label class="cms-label">Full Name</label>
                <input type="text" name="full_name" class="cms-input" placeholder="e.g. John Doe" />
              </div>
            </div>

            <div class="cms-input-row">
              <div class="cms-form-group">
                <label class="cms-label">Role</label>
                <select name="role" class="cms-select" onchange="toggleAddPerms(this.value)">
                  <option value="user">Team Member (Custom Tab Access)</option>
                  <option value="admin">Administrator (Full Access)</option>
                </select>
              </div>
              <div class="cms-form-group">
                <label class="cms-label">Position / Title</label>
                <input type="text" name="position" class="cms-input" placeholder="e.g. Visa Consultant" />
              </div>
            </div>

            <!-- Permission Checkbox Pills -->
            <div id="newMemberPermsGroup" class="cms-form-group">
              <label class="cms-label">Allow Access to Tabs</label>
              <div class="cms-perm-grid">
                <?php foreach ($allPermittedSlugs as $slugKey => $slugTitle): ?>
                  <label class="cms-perm-pill">
                    <input type="checkbox" name="add_perms[]" value="<?= $slugKey ?>" <?= $slugKey === 'dashboard' ? 'checked' : '' ?> />
                    <span><?= htmlspecialchars($slugTitle) ?></span>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="cms-form-group" style="display:flex;align-items:center;gap:10px;">
              <input type="checkbox" id="add_can_edit" name="can_edit" value="1" checked style="accent-color:#22c55e;width:17px;height:17px;" />
              <label for="add_can_edit" class="cms-label" style="margin-bottom:0;cursor:pointer;">Can Edit & Save Changes (uncheck for View-Only)</label>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px;">
              <button type="button" class="cms-btn cms-btn-secondary cms-btn-sm" onclick="toggleAddMemberForm()">Cancel</button>
              <button type="submit" class="cms-btn cms-btn-primary cms-btn-sm" id="btnAddMember">Create Member</button>
            </div>
          </form>
        </div>

        <!-- Users Table -->
        <div class="cms-table-wrap">
          <table class="cms-table">
            <thead>
              <tr>
                <th>Member</th>
                <th>Role</th>
                <th>Status</th>
                <th>Permitted Tabs</th>
                <th>Editing Rights</th>
                <th style="text-align:right;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($allUsers as $u): 
                  $uRole    = $u['role'] ?? 'user';
                  $uPerms   = json_decode($u['permissions'] ?? '[]', true) ?: [];
                  $uStatus  = $u['status'] ?? 'active';
                  $uCanEdit = (int)($u['can_edit'] ?? 1);
                  $isPrimaryAdmin = ((int)$u['id'] === 1 || $u['username'] === 'admin');
              ?>
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:12px;">
                    <div class="cms-avatar" style="width:38px;height:38px;font-size:14px;">
                      <?= strtoupper(substr($u['username'] ?: 'U', 0, 1)) ?>
                    </div>
                    <div>
                      <div style="font-weight:500;color:var(--text-primary);"><?= htmlspecialchars($u['full_name'] ?: $u['username']) ?></div>
                      <div style="font-size:12.5px;color:var(--text-muted);"><?= htmlspecialchars($u['email'] ?: 'No email') ?></div>
                    </div>
                  </div>
                </td>
                <td>
                  <?php if ($uRole === 'admin'): ?>
                    <span class="cms-badge cms-badge-green">Administrator</span>
                  <?php else: ?>
                    <span class="cms-badge cms-badge-blue">Team Member</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($uStatus === 'active'): ?>
                    <span class="cms-status-pill cms-badge-success">Active</span>
                  <?php else: ?>
                    <span class="cms-status-pill cms-badge-expired">Disabled</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($uRole === 'admin' || in_array('*', $uPerms, true)): ?>
                    <span style="font-size:13.5px;color:#16a34a;font-weight:500;">All Tabs (Full Access)</span>
                  <?php else: ?>
                    <span style="font-size:13px;color:var(--text-secondary);">
                      <?= count($uPerms) ?> of <?= count($allPermittedSlugs) ?> Tabs
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($uCanEdit): ?>
                    <span style="font-size:13px;color:#16a34a;font-weight:500;">Can Edit</span>
                  <?php else: ?>
                    <span style="font-size:13px;color:var(--text-muted);">View-Only</span>
                  <?php endif; ?>
                </td>
                <td style="text-align:right;">
                  <button type="button" class="cms-btn cms-btn-secondary cms-btn-sm" onclick="toggleUserPermsRow(<?= (int)$u['id'] ?>)">
                    Configure Access
                  </button>
                </td>
              </tr>

              <!-- Expandable Permissions Row -->
              <tr id="permsRow_<?= (int)$u['id'] ?>" style="display:none;background:#fcfdfe;">
                <td colspan="6" style="padding:22px 28px;border-bottom:2px solid var(--border);">
                  <div style="max-width:920px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                      <h4 style="font-size:15px;font-weight:500;color:var(--text-primary);margin:0;">
                        Permissions for <?= htmlspecialchars($u['full_name'] ?: $u['username']) ?>
                      </h4>
                      <span style="font-size:12.5px;color:var(--text-muted);"><?= htmlspecialchars($u['email']) ?></span>
                    </div>

                    <?php if ($isPrimaryAdmin): ?>
                      <div class="cms-alert cms-alert-info" style="margin-bottom:12px;">
                        <div class="cms-alert-icon">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        <div class="cms-alert-content">
                          This is the primary <strong>Administrator</strong> account. It maintains full and unrestricted access across all CMS tabs.
                        </div>
                      </div>
                    <?php else: ?>
                      <form id="permForm_<?= (int)$u['id'] ?>" onsubmit="handleSaveUserPermissions(event, <?= (int)$u['id'] ?>)">
                        <div class="cms-form-group">
                          <label class="cms-label">Allowed Navigation Tabs:</label>
                          <div class="cms-perm-grid">
                            <?php foreach ($allPermittedSlugs as $slugKey => $slugTitle): 
                                $checked = (in_array('*', $uPerms, true) || in_array($slugKey, $uPerms, true)) ? 'checked' : '';
                            ?>
                              <label class="cms-perm-pill">
                                <input type="checkbox" name="user_perms[]" value="<?= $slugKey ?>" <?= $checked ?> />
                                <span><?= htmlspecialchars($slugTitle) ?></span>
                              </label>
                            <?php endforeach; ?>
                          </div>
                        </div>

                        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-top:14px;">
                          <div class="cms-form-group">
                            <label class="cms-label">Account Role</label>
                            <select name="user_role" class="cms-select">
                              <option value="user" <?= $uRole === 'user' ? 'selected' : '' ?>>Team Member</option>
                              <option value="admin" <?= $uRole === 'admin' ? 'selected' : '' ?>>Administrator (Full Access)</option>
                            </select>
                          </div>

                          <div class="cms-form-group">
                            <label class="cms-label">Account Status</label>
                            <select name="user_status" class="cms-select">
                              <option value="active" <?= $uStatus === 'active' ? 'selected' : '' ?>>Active (Can Login)</option>
                              <option value="disabled" <?= $uStatus === 'disabled' ? 'selected' : '' ?>>Disabled (Blocked)</option>
                            </select>
                          </div>

                          <div class="cms-form-group">
                            <label class="cms-label">Editing Rights</label>
                            <select name="user_can_edit" class="cms-select">
                              <option value="1" <?= $uCanEdit ? 'selected' : '' ?>>Can Edit & Save Changes</option>
                              <option value="0" <?= !$uCanEdit ? 'selected' : '' ?>>View-Only (Read-Only)</option>
                            </select>
                          </div>
                        </div>

                        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:18px;border-top:1px solid var(--border-muted);padding-top:14px;">
                          <button type="button" class="cms-btn cms-btn-danger cms-btn-sm" onclick="handleDeleteUser(<?= (int)$u['id'] ?>, '<?= htmlspecialchars($u['email']) ?>')">
                            Delete Account
                          </button>

                          <div style="display:flex;gap:10px;">
                            <button type="button" class="cms-btn cms-btn-secondary cms-btn-sm" onclick="toggleUserPermsRow(<?= (int)$u['id'] ?>)">Close</button>
                            <button type="submit" class="cms-btn cms-btn-primary cms-btn-sm" id="btnSavePerms_<?= (int)$u['id'] ?>">Save Permissions</button>
                          </div>
                        </div>
                      </form>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
    <?php endif; ?>

  </div>
</div>

<script>
// ── Tab Switching ──────────────────────────────────────────
function switchProfileTab(tabName) {
  document.querySelectorAll('.cms-tab-btn').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.tab === tabName);
  });
  document.querySelectorAll('.cms-tab-pane').forEach(pane => {
    pane.classList.toggle('active', pane.id === `pane-${tabName}`);
  });
}

// ── Quick Announcement Composer ───────────────────────────
function publishQuickPost() {
  window.cmsSyncEditors?.();
  const textarea = document.getElementById('quickPostText');
  const content = textarea.value.trim();
  if (!content) {
    Toast.show('Please write an announcement before posting.', 'warning');
    return;
  }
  Toast.success('Team announcement posted successfully!');
  textarea.value = '';
  const ed = window.cmsRichEditors?.get(textarea);
  if (ed) ed.setData('');
}

// ── Save Profile via AJAX ─────────────────────────────────
async function handleProfileSubmit(e) {
  e.preventDefault();
  window.cmsSyncEditors?.();
  const form = document.getElementById('profileForm');
  const btn = document.getElementById('saveProfileBtn');
  btn.disabled = true;
  btn.textContent = 'Saving...';

  const formData = new FormData(form);
  formData.append('_csrf', CMS_CSRF);

  try {
    const res = await fetch('../api/save.php', { method: 'POST', body: formData });
    const json = await res.json();
    if (json.ok) {
      Toast.success('Profile updated successfully.');
      const fn = formData.get('full_name');
      const pos = formData.get('position');
      const bio = formData.get('bio');
      const bdate = formData.get('birth_date');
      const edu = formData.get('education');
      const lang = formData.get('languages');
      const ph = formData.get('phone');
      const em = formData.get('email');
      const skills = formData.get('skills');

      if (fn) document.getElementById('heroFullName').textContent = fn;
      if (pos) {
        document.getElementById('heroPosition').textContent = pos;
        document.getElementById('infoPosition').textContent = pos;
      }
      if (bio) document.getElementById('infoBio').textContent = bio;
      if (bdate) document.getElementById('infoBirthDate').textContent = bdate;
      if (edu) document.getElementById('infoEducation').textContent = edu;
      if (lang) document.getElementById('infoLanguages').textContent = lang;
      if (ph) document.getElementById('infoPhone').textContent = ph;
      if (em) document.getElementById('infoEmail').textContent = em;

      if (skills) {
        const skillsContainer = document.getElementById('infoSkillsList');
        skillsContainer.innerHTML = '';
        skills.split(',').map(s => s.trim()).filter(Boolean).forEach(s => {
          const pill = document.createElement('span');
          pill.className = 'cms-skill-pill';
          pill.textContent = s;
          skillsContainer.appendChild(pill);
        });
      }
    } else {
      Toast.error(json.error || 'Failed to update profile.');
    }
  } catch (err) {
    Toast.error('Network error while saving profile.');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Save Changes';
  }
}

// ── Change Password via AJAX ──────────────────────────────
async function handlePasswordSubmit(e) {
  e.preventDefault();
  const form = document.getElementById('passwordForm');
  const btn = document.getElementById('savePassBtn');
  btn.disabled = true;
  btn.textContent = 'Updating...';

  const formData = new FormData(form);
  formData.append('_csrf', CMS_CSRF);

  try {
    const res = await fetch('../api/save.php', { method: 'POST', body: formData });
    const json = await res.json();
    if (json.ok) {
      Toast.success('Password changed successfully.');
      form.reset();
    } else {
      Toast.error(json.error || 'Failed to change password.');
    }
  } catch (err) {
    Toast.error('Network error while changing password.');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Update Password';
  }
}

// ── ACCESS CONTROL: Toggle Add Member Form ─────────────────
function toggleAddMemberForm() {
  const card = document.getElementById('addMemberCard');
  card.style.display = card.style.display === 'none' ? 'block' : 'none';
}

function toggleAddPerms(role) {
  const grp = document.getElementById('newMemberPermsGroup');
  if (grp) grp.style.display = role === 'admin' ? 'none' : 'block';
}

// ── ACCESS CONTROL: Toggle User Perms Row ──────────────────
function toggleUserPermsRow(uid) {
  const row = document.getElementById('permsRow_' + uid);
  if (!row) return;
  row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}

// ── ACCESS CONTROL: Save User Permissions ──────────────────
async function handleSaveUserPermissions(e, uid) {
  e.preventDefault();
  const form = document.getElementById('permForm_' + uid);
  const btn = document.getElementById('btnSavePerms_' + uid);
  btn.disabled = true;
  btn.textContent = 'Saving...';

  const selectedPerms = [];
  form.querySelectorAll('input[name="user_perms[]"]:checked').forEach(cb => {
    selectedPerms.push(cb.value);
  });

  const formData = new FormData();
  formData.append('_csrf', CMS_CSRF);
  formData.append('action', 'save_user_permissions');
  formData.append('user_id', uid);
  formData.append('role', form.querySelector('[name="user_role"]').value);
  formData.append('status', form.querySelector('[name="user_status"]').value);
  formData.append('can_edit', form.querySelector('[name="user_can_edit"]').value);
  formData.append('permissions', JSON.stringify(selectedPerms));

  try {
    const res = await fetch('../api/save.php', { method: 'POST', body: formData });
    const json = await res.json();
    if (json.ok) {
      Toast.success('Permissions saved successfully.');
      setTimeout(() => location.reload(), 800);
    } else {
      Toast.error(json.error || 'Failed to save permissions.');
    }
  } catch (err) {
    Toast.error('Network error saving permissions.');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Save Permissions';
  }
}

// ── ACCESS CONTROL: Add Member ────────────────────────────
async function handleAddMemberSubmit(e) {
  e.preventDefault();
  const form = document.getElementById('addMemberForm');
  const btn = document.getElementById('btnAddMember');
  btn.disabled = true;
  btn.textContent = 'Adding...';

  const selectedPerms = [];
  form.querySelectorAll('input[name="add_perms[]"]:checked').forEach(cb => {
    selectedPerms.push(cb.value);
  });

  const formData = new FormData(form);
  formData.append('_csrf', CMS_CSRF);
  formData.append('permissions', JSON.stringify(selectedPerms));

  try {
    const res = await fetch('../api/save.php', { method: 'POST', body: formData });
    const json = await res.json();
    if (json.ok) {
      Toast.success('Team member added successfully.');
      setTimeout(() => location.reload(), 900);
    } else {
      Toast.error(json.error || 'Failed to add member.');
    }
  } catch (err) {
    Toast.error('Network error adding member.');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Create Member';
  }
}

// ── ACCESS CONTROL: Delete User ───────────────────────────
async function handleDeleteUser(uid, email) {
  if (!confirm(`Are you sure you want to remove ${email}? They will no longer be able to log in.`)) {
    return;
  }

  const formData = new FormData();
  formData.append('_csrf', CMS_CSRF);
  formData.append('action', 'delete_user');
  formData.append('user_id', uid);

  try {
    const res = await fetch('../api/save.php', { method: 'POST', body: formData });
    const json = await res.json();
    if (json.ok) {
      Toast.success('User deleted successfully.');
      setTimeout(() => location.reload(), 800);
    } else {
      Toast.error(json.error || 'Failed to delete user.');
    }
  } catch (err) {
    Toast.error('Network error deleting user.');
  }
}
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
