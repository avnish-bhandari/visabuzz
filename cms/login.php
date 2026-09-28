<?php
/**
 * login.php — CMS Login (Admin Password & Team Email OTP)
 * Provides dual sign-in options:
 * 1. Admin login via Username & Password with full system access
 * 2. Team member login via Email with 6-digit OTP verification
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

// Already logged in? Go to dashboard
if (cms_is_logged_in()) {
    header('Location: index.php');
    exit;
}

// Handle AJAX requests for OTP
if (isset($_GET['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') || str_starts_with($_SERVER['CONTENT_TYPE'] ?? '', 'application/json')) {
    header('Content-Type: application/json; charset=utf-8');
    $action = $_POST['action'] ?? '';

    // ── 1. SEND OTP ──────────────────────────────────────────
    if ($action === 'send_otp') {
        $email = strtolower(trim($_POST['email'] ?? ''));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['ok' => false, 'error' => 'Please provide a valid email address.']);
            exit;
        }

        // Generate 6-digit OTP
        $otp = sprintf('%06d', random_int(100000, 999999));
        $expiresAt = date('Y-m-d H:i:s', time() + (10 * 60)); // 10 minutes

        // Remove old pending OTPs for this email
        $pdo->prepare("DELETE FROM cms_otps WHERE email = ?")->execute([$email]);

        // Insert new OTP with MySQL native NOW() + INTERVAL 10 MINUTE
        $stmt = $pdo->prepare("INSERT INTO cms_otps (email, otp_code, expires_at) VALUES (?, ?, NOW() + INTERVAL 10 MINUTE)");
        $stmt->execute([$email, $otp]);

        // Attempt sending via PHP mail()
        $subject = "Your Visabuz CMS Login Code: $otp";
        $headers = "From: Visabuz CMS <noreply@visabuz.com>\r\nReply-To: noreply@visabuz.com\r\nX-Mailer: PHP/" . phpversion();
        $body = "Hello,\n\nYour one-time login verification code for Visabuz CMS is:\n\n"
              . "  $otp\n\n"
              . "This code is valid for 10 minutes.\nIf you did not request this login, please ignore this email.\n\n"
              . "Best regards,\nVisabuz Team";

        @mail($email, $subject, $body, $headers);

        // For local development / XAMPP environments without an active SMTP server, return test preview
        $isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true) || str_contains($_SERVER['HTTP_HOST'] ?? '', 'localhost');

        echo json_encode([
            'ok'      => true,
            'message' => "Verification code sent to $email.",
            'is_test' => $isLocal,
            'test_code' => $isLocal ? $otp : null,
        ]);
        exit;
    }

    // ── 2. VERIFY OTP & SIGN IN ─────────────────────────────
    if ($action === 'verify_otp') {
        $email = strtolower(trim($_POST['email'] ?? ''));
        $otp   = trim($_POST['otp'] ?? '');

        if (!$email || !$otp) {
            echo json_encode(['ok' => false, 'error' => 'Email and 6-digit OTP are required.']);
            exit;
        }

        // Check OTP in database
        $stmt = $pdo->prepare("
            SELECT id FROM cms_otps
            WHERE email = ? AND otp_code = ? AND expires_at >= NOW()
            ORDER BY id DESC LIMIT 1
        ");
        $stmt->execute([$email, $otp]);
        $validOtp = $stmt->fetch();

        if (!$validOtp) {
            echo json_encode(['ok' => false, 'error' => 'Invalid or expired verification code.']);
            exit;
        }

        // Clean up verified OTP
        $pdo->prepare("DELETE FROM cms_otps WHERE email = ?")->execute([$email]);

        // Find or auto-create team member account in cms_users
        $stmt = $pdo->prepare("SELECT * FROM cms_users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            if (($user['status'] ?? 'active') === 'disabled') {
                echo json_encode(['ok' => false, 'error' => 'Your account has been deactivated by the Administrator.']);
                exit;
            }
        } else {
            // New user login via email -> default role user with dashboard access pending admin configuration
            $baseUsername = strtolower(preg_replace('/[^a-z0-9_]/i', '', strstr($email, '@', true) ?: 'user'));
            $fullName     = ucwords(str_replace(['.', '_', '-'], ' ', strstr($email, '@', true) ?: 'Team Member'));

            $ins = $pdo->prepare("
                INSERT INTO cms_users (username, password_hash, full_name, email, role, permissions, can_edit, status, position)
                VALUES (?, '', ?, ?, 'user', '[\"dashboard\"]', 0, 'active', 'Team Member')
            ");
            $ins->execute([$baseUsername, $fullName, $email]);
            $newId = (int)$pdo->lastInsertId();

            $stmt = $pdo->prepare("SELECT * FROM cms_users WHERE id = ?");
            $stmt->execute([$newId]);
            $user = $stmt->fetch();
        }

        // Set session
        session_regenerate_id(true);
        $_SESSION['cms_user_id']     = (int)$user['id'];
        $_SESSION['cms_username']    = $user['username'];
        $_SESSION['cms_full_name']   = $user['full_name'] ?: $user['username'];
        $_SESSION['cms_role']        = $user['role'] ?: 'user';
        $_SESSION['cms_permissions'] = json_decode($user['permissions'] ?? '["dashboard"]', true) ?: ['dashboard'];
        $_SESSION['cms_can_edit']    = (int)($user['can_edit'] ?? 1);

        echo json_encode(['ok' => true, 'redirect' => 'index.php']);
        exit;
    }

    echo json_encode(['ok' => false, 'error' => 'Unknown action.']);
    exit;
}

// Handle standard Admin Password POST
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'admin_login') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM cms_users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            if (($user['status'] ?? 'active') === 'disabled') {
                $error = 'This account has been disabled.';
            } else {
                session_regenerate_id(true);
                $_SESSION['cms_user_id']     = (int)$user['id'];
                $_SESSION['cms_username']    = $user['username'];
                $_SESSION['cms_full_name']   = $user['full_name'] ?: $user['username'];
                $_SESSION['cms_role']        = $user['role'] ?: 'admin';
                $_SESSION['cms_permissions'] = json_decode($user['permissions'] ?? '["*"]', true) ?: ['*'];
                $_SESSION['cms_can_edit']    = (int)($user['can_edit'] ?? 1);

                header('Location: index.php');
                exit;
            }
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Login — Visabuz CMS</title>
  <link rel="stylesheet" href="assets/cms.css" />
</head>
<body>

<div class="cms-login-page">
  <div class="cms-login-card">

    <!-- Logo -->
    <div class="cms-login-logo">
      <div class="cms-brand-icon">V</div>
      <div>
        <div class="cms-brand-name">Visabuz <span class="cms-brand-dot"></span></div>
        <span class="cms-brand-badge">CMS Portal</span>
      </div>
    </div>

    <h1 class="cms-login-title">Welcome back</h1>
    <p class="cms-login-sub">Sign in to manage website content and services.</p>

    <!-- Sign-in Mode Segmented Control -->
    <div class="cms-btn-group w-full" style="display:flex;margin-bottom:22px;">
      <button type="button" id="tabAdminBtn" class="cms-btn-group-item active" style="flex:1;text-align:center;" onclick="showLoginMode('admin')">
        Admin Password
      </button>
      <button type="button" id="tabOtpBtn" class="cms-btn-group-item" style="flex:1;text-align:center;" onclick="showLoginMode('otp')">
        Team Email OTP
      </button>
    </div>

    <!-- Error Banner for Admin Form -->
    <?php if ($error): ?>
      <div class="cms-alert cms-alert-error" id="adminErrorBanner">
        <div class="cms-alert-icon">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </div>
        <div class="cms-alert-content">
          <strong>Oh snap!</strong> <?= htmlspecialchars($error) ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Dynamic Status Banner for OTP Flow -->
    <div id="otpStatusBanner" class="cms-alert" style="display:none;">
      <div class="cms-alert-icon" id="otpStatusIcon"></div>
      <div class="cms-alert-content" id="otpStatusMsg"></div>
    </div>

    <!-- ═══════════════════════════════════════════════════════
         MODE 1: ADMIN LOGIN FORM
    ═══════════════════════════════════════════════════════ -->
    <form id="adminLoginForm" method="POST" action="login.php" autocomplete="on">
      <input type="hidden" name="action" value="admin_login" />

      <div class="cms-form-group">
        <label class="cms-label" for="username">Username</label>
        <input
          type="text"
          id="username"
          name="username"
          class="cms-input"
          placeholder="admin"
          value="<?= htmlspecialchars($_POST['username'] ?? 'admin') ?>"
          autocomplete="username"
          required
        />
      </div>

      <div class="cms-form-group">
        <label class="cms-label" for="password">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          class="cms-input"
          placeholder="••••••••"
          autocomplete="current-password"
          required
        />
      </div>

      <button type="submit" class="cms-btn cms-btn-primary w-full" style="justify-content:center;margin-top:8px;">
        Sign In as Admin
      </button>
    </form>

    <!-- ═══════════════════════════════════════════════════════
         MODE 2: TEAM EMAIL + OTP FLOW
    ═══════════════════════════════════════════════════════ -->
    <div id="otpLoginContainer" style="display:none;">

      <!-- Step 1: Request OTP -->
      <div id="otpStep1">
        <div class="cms-form-group">
          <label class="cms-label" for="otpEmail">Work Email Address</label>
          <input
            type="email"
            id="otpEmail"
            class="cms-input"
            placeholder="name@visabuz.com"
            autocomplete="email"
          />
        </div>

        <button type="button" id="btnSendOtp" class="cms-btn cms-btn-primary w-full" style="justify-content:center;margin-top:8px;" onclick="handleSendOtp()">
          Send Login Code
        </button>
      </div>

      <!-- Step 2: Enter & Verify 6-digit OTP -->
      <div id="otpStep2" style="display:none;">
        <div class="cms-form-group">
          <label class="cms-label">Enter 6-Digit Code</label>
          <input
            type="text"
            id="otpCode"
            class="cms-input"
            placeholder="000000"
            maxlength="6"
            style="letter-spacing:0.3em;text-align:center;font-size:20px;font-weight:500;"
          />
          <div style="font-size:13px;color:var(--text-muted);margin-top:6px;display:flex;justify-content:space-between;align-items:center;">
            <span id="sentToNotice">Sent to email</span>
            <button type="button" class="cms-profile-edit-link" onclick="resetOtpStep()" style="font-size:13px;">Change Email</button>
          </div>
        </div>

        <button type="button" id="btnVerifyOtp" class="cms-btn cms-btn-primary w-full" style="justify-content:center;margin-top:8px;" onclick="handleVerifyOtp()">
          Verify & Sign In
        </button>

        <div style="text-align:center;margin-top:16px;">
          <button type="button" class="cms-profile-edit-link" onclick="handleSendOtp()" style="font-size:13.5px;">Resend Verification Code</button>
        </div>
      </div>

    </div>

  </div>
</div>

<script>
function showLoginMode(mode) {
  const adminTab = document.getElementById('tabAdminBtn');
  const otpTab   = document.getElementById('tabOtpBtn');
  const adminFrm = document.getElementById('adminLoginForm');
  const otpBox   = document.getElementById('otpLoginContainer');
  const errBanner = document.getElementById('adminErrorBanner');
  const otpBanner = document.getElementById('otpStatusBanner');

  if (mode === 'admin') {
    adminTab.classList.add('active');
    otpTab.classList.remove('active');
    adminFrm.style.display = 'block';
    otpBox.style.display   = 'none';
    if (otpBanner) otpBanner.style.display = 'none';
  } else {
    otpTab.classList.add('active');
    adminTab.classList.remove('active');
    adminFrm.style.display = 'none';
    otpBox.style.display   = 'block';
    if (errBanner) errBanner.style.display = 'none';
  }
}

function showOtpBanner(type, message) {
  const banner = document.getElementById('otpStatusBanner');
  const icon   = document.getElementById('otpStatusIcon');
  const msg    = document.getElementById('otpStatusMsg');

  banner.className = `cms-alert cms-alert-${type}`;
  banner.style.display = 'flex';

  const checkSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>';
  const crossSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
  const infoSvg  = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>';

  icon.innerHTML = type === 'success' ? checkSvg : (type === 'error' ? crossSvg : infoSvg);
  msg.innerHTML  = message;
}

function resetOtpStep() {
  document.getElementById('otpStep1').style.display = 'block';
  document.getElementById('otpStep2').style.display = 'none';
  document.getElementById('otpCode').value = '';
}

async function handleSendOtp() {
  const emailInput = document.getElementById('otpEmail');
  const btn = document.getElementById('btnSendOtp');
  const email = emailInput.value.trim();

  if (!email || !email.includes('@')) {
    showOtpBanner('error', '<strong>Oops!</strong> Please enter a valid email address.');
    emailInput.focus();
    return;
  }

  btn.disabled = true;
  btn.textContent = 'Sending code...';

  const formData = new FormData();
  formData.append('action', 'send_otp');
  formData.append('email', email);

  try {
    const res = await fetch('login.php?ajax=1', { method: 'POST', body: formData });
    const json = await res.json();

    if (json.ok) {
      document.getElementById('otpStep1').style.display = 'none';
      document.getElementById('otpStep2').style.display = 'block';
      document.getElementById('sentToNotice').textContent = 'Sent to ' + email;

      let msg = `<strong>Code Sent!</strong> Check your email inbox.`;
      if (json.is_test && json.test_code) {
        msg += `<br/><span style="font-size:12.5px;color:var(--text-secondary);">Test environment code: <code style="background:#fff;padding:2px 6px;border-radius:4px;font-weight:500;">${json.test_code}</code></span>`;
      }
      showOtpBanner('success', msg);
      document.getElementById('otpCode').focus();
    } else {
      showOtpBanner('error', json.error || 'Failed to send verification code.');
    }
  } catch (e) {
    showOtpBanner('error', 'Network error. Could not request OTP.');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Send Login Code';
  }
}

async function handleVerifyOtp() {
  const email = document.getElementById('otpEmail').value.trim();
  const otpInput = document.getElementById('otpCode');
  const otp = otpInput.value.trim();
  const btn = document.getElementById('btnVerifyOtp');

  if (!otp || otp.length !== 6) {
    showOtpBanner('error', '<strong>Invalid Code!</strong> Please enter the 6-digit code.');
    otpInput.focus();
    return;
  }

  btn.disabled = true;
  btn.textContent = 'Verifying...';

  const formData = new FormData();
  formData.append('action', 'verify_otp');
  formData.append('email', email);
  formData.append('otp', otp);

  try {
    const res = await fetch('login.php?ajax=1', { method: 'POST', body: formData });
    const json = await res.json();

    if (json.ok) {
      showOtpBanner('success', '<strong>Success!</strong> Logging you into the CMS...');
      window.location.href = json.redirect || 'index.php';
    } else {
      showOtpBanner('error', json.error || 'Invalid or expired code.');
      btn.disabled = false;
      btn.textContent = 'Verify & Sign In';
    }
  } catch (e) {
    showOtpBanner('error', 'Network error during verification.');
    btn.disabled = false;
    btn.textContent = 'Verify & Sign In';
  }
}
</script>

</body>
</html>
