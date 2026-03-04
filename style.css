<?php
session_start();

// Guard: redirect to login if not authenticated
if (!isset($_SESSION['noir_user'])) {
    header('Location: login.php');
    exit;
}

$user    = $_SESSION['noir_user'];
$isAdmin = ($user['role'] === 'admin');

// ---- Handle Profile Update (POST) ----
$updateMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    switch ($_POST['action']) {

        case 'update_profile':
            $name  = htmlspecialchars(trim($_POST['name']  ?? ''));
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
            $city  = htmlspecialchars(trim($_POST['city']  ?? ''));
            $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));

            if (empty($name)) {
                $updateMsg = 'error:Name cannot be empty.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $updateMsg = 'error:Please enter a valid email.';
            } else {
                // Handle optional avatar upload
                if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    $maxSize = 2 * 1024 * 1024;

                    if (!in_array($_FILES['avatar']['type'], $allowed)) {
                        $updateMsg = 'error:Only JPG, PNG, GIF, or WEBP images allowed.';
                        break;
                    }
                    if ($_FILES['avatar']['size'] > $maxSize) {
                        $updateMsg = 'error:Avatar must be under 2MB.';
                        break;
                    }

                    $ext      = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                    $filename = 'avatar_' . time() . '.' . $ext;
                    $uploadDir = __DIR__ . '/../uploads/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $filename);
                    $user['avatar'] = $filename;
                }

                $user['name']  = $name;
                $user['email'] = $email;
                $user['city']  = $city;
                $user['phone'] = $phone;

                $_SESSION['noir_user'] = $user;
                $updateMsg = 'success:Profile updated successfully.';
            }
            break;

        case 'place_order':
            // Basic order placement acknowledgement
            $updateMsg = 'success:Order placed successfully! Confirmation sent to ' . htmlspecialchars($user['email']);
            break;
    }
}

// ---- Active Tab Logic ----
$tab = htmlspecialchars($_GET['tab'] ?? '');

// Use if/elseif to determine the default tab
if (empty($tab)) {
    if ($isAdmin) {
        $tab = 'admin-stats';
    } else {
        $tab = 'profile';
    }
}

// ---- Mock Data ----
$products = [
    ['id'=>1,'name'=>'The Obsidian Bag',  'cat'=>'Accessories',   'price'=>2450,'img'=>'../images/product-1.jpg'],
    ['id'=>2,'name'=>'Noir Overcoat',     'cat'=>'Outerwear',     'price'=>3800,'img'=>'../images/product-2.jpg'],
    ['id'=>3,'name'=>'Eclipse Shades',    'cat'=>'Eyewear',       'price'=>890, 'img'=>'../images/product-3.jpg'],
    ['id'=>4,'name'=>'Shadow Boots',      'cat'=>'Footwear',      'price'=>1650,'img'=>'../images/product-4.jpg'],
    ['id'=>5,'name'=>'Silk Meridian',     'cat'=>'Accessories',   'price'=>680, 'img'=>'../images/product-5.jpg'],
    ['id'=>6,'name'=>'Phantom Dress',     'cat'=>'Ready-to-Wear', 'price'=>4200,'img'=>'../images/product-6.jpg'],
];

$orderHistory = [
    ['id'=>'NM-2847','date'=>'2025-01-15','items'=>'Noir Overcoat, Eclipse Shades','total'=>4690,'status'=>'Delivered'],
    ['id'=>'NM-2831','date'=>'2024-12-28','items'=>'The Obsidian Bag',             'total'=>2450,'status'=>'Delivered'],
    ['id'=>'NM-2819','date'=>'2024-12-10','items'=>'Shadow Boots',                 'total'=>1650,'status'=>'Pending'],
    ['id'=>'NM-2805','date'=>'2024-11-22','items'=>'Phantom Dress',                'total'=>4200,'status'=>'Cancelled'],
    ['id'=>'NM-2790','date'=>'2024-11-05','items'=>'Silk Meridian, Eclipse Shades','total'=>1570,'status'=>'Delivered'],
];

$customers = [
    ['name'=>'Elara Voss',    'email'=>'elara@email.com',  'city'=>'Milan, IT',    'joined'=>'2024-01-10','orders'=>12],
    ['name'=>'Lucien Moreau', 'email'=>'lucien@email.com', 'city'=>'Paris, FR',    'joined'=>'2023-06-18','orders'=>24],
    ['name'=>'Anya Petrova',  'email'=>'anya@email.com',   'city'=>'Moscow, RU',   'joined'=>'2023-11-02','orders'=>8],
    ['name'=>'Kai Tanaka',    'email'=>'kai@email.com',    'city'=>'Tokyo, JP',    'joined'=>'2024-03-21','orders'=>15],
    ['name'=>'Sofia Reyes',   'email'=>'sofia@email.com',  'city'=>'Barcelona, ES','joined'=>'2024-05-14','orders'=>6],
    ['name'=>'Marcus Klein',  'email'=>'marcus@email.com', 'city'=>'Berlin, DE',   'joined'=>'2023-09-30','orders'=>19],
];

$adminOrders = [
    ['id'=>'NM-2850','customer'=>'Elara Voss',   'date'=>'2025-01-20','total'=>6250,'status'=>'Processing'],
    ['id'=>'NM-2849','customer'=>'Lucien Moreau','date'=>'2025-01-19','total'=>3800,'status'=>'Delivered'],
    ['id'=>'NM-2848','customer'=>'Anya Petrova', 'date'=>'2025-01-18','total'=>890, 'status'=>'Pending'],
    ['id'=>'NM-2847','customer'=>'Elara Voss',   'date'=>'2025-01-15','total'=>4690,'status'=>'Delivered'],
    ['id'=>'NM-2846','customer'=>'Kai Tanaka',   'date'=>'2025-01-14','total'=>5880,'status'=>'Delivered'],
    ['id'=>'NM-2845','customer'=>'Sofia Reyes',  'date'=>'2025-01-12','total'=>2450,'status'=>'Cancelled'],
    ['id'=>'NM-2844','customer'=>'Marcus Klein', 'date'=>'2025-01-10','total'=>1650,'status'=>'Delivered'],
];

$revenueData = [
    ['month'=>'Jul','value'=>42000],
    ['month'=>'Aug','value'=>38000],
    ['month'=>'Sep','value'=>55000],
    ['month'=>'Oct','value'=>48000],
    ['month'=>'Nov','value'=>62000],
    ['month'=>'Dec','value'=>74000],
    ['month'=>'Jan','value'=>58000],
];

// ---- Helper: Status Badge ----
function statusBadge(string $status): string {
    switch ($status) {
        case 'Delivered':  $cls = 'status-delivered';  break;
        case 'Pending':    $cls = 'status-pending';    break;
        case 'Processing': $cls = 'status-processing'; break;
        case 'Cancelled':  $cls = 'status-cancelled';  break;
        default:           $cls = '';
    }
    return '<span class="status-badge ' . $cls . '">' . htmlspecialchars($status) . '</span>';
}

// ---- Helper: Tab Label ----
function tabLabel(string $tab): string {
    $labels = [
        'profile'          => 'Profile',
        'catalog'          => 'Catalog',
        'history'          => 'Purchase History',
        'settings'         => 'Update Profile',
        'new-order'        => 'New Order',
        'admin-stats'      => 'Overview',
        'admin-customers'  => 'Customers',
        'admin-orders'     => 'Order Management',
        'admin-finances'   => 'Finances',
    ];
    return $labels[$tab] ?? ucfirst($tab);
}

// ---- SVG Icons ----
$icons = [
  'user'      => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
  'bag'       => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18"/><path d="M16 10a4 4 0 01-8 0"/></svg>',
  'history'   => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
  'settings'  => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.6V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9c.26.604.852.997 1.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>',
  'plus'      => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>',
  'chart'     => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>',
  'users'     => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>',
  'clipboard' => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>',
  'dollar'    => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>',
  'home'      => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M9 22V12h6v10"/></svg>',
  'logout'    => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>',
  'location'  => '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>',
];

// ---- User Tabs & Admin Tabs ----
$userTabs = [
    ['id'=>'profile',   'label'=>'Profile',          'icon'=>$icons['user']],
    ['id'=>'catalog',   'label'=>'Catalog',           'icon'=>$icons['bag']],
    ['id'=>'history',   'label'=>'Purchase History',  'icon'=>$icons['history']],
    ['id'=>'settings',  'label'=>'Update Profile',    'icon'=>$icons['settings']],
    ['id'=>'new-order', 'label'=>'New Order',         'icon'=>$icons['plus']],
];

$adminTabs = [
    ['id'=>'admin-stats',     'label'=>'Overview',          'icon'=>$icons['chart']],
    ['id'=>'admin-customers', 'label'=>'Customers',          'icon'=>$icons['users']],
    ['id'=>'admin-orders',    'label'=>'Order Management',   'icon'=>$icons['clipboard']],
    ['id'=>'admin-finances',  'label'=>'Finances',           'icon'=>$icons['dollar']],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#0a0a0a">
  <title>Dashboard | NOIR MAISON</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <!-- Logout Overlay -->
  <div class="logout-overlay" id="logoutOverlay">
    <p>Until next time...</p>
  </div>

  <input type="checkbox" id="sidebarToggle" style="display:none;">

  <div class="dashboard">
    <!-- ======== Sidebar ======== -->
    <aside class="sidebar" id="sidebar">
      <label for="sidebarToggle" class="sidebar-close" aria-label="Close sidebar">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
      </label>

      <div class="sidebar-header">
        <div class="sidebar-avatar"><?= htmlspecialchars(mb_substr($user['name'], 0, 1)) ?></div>
        <div class="sidebar-user-info">
          <h3><?= htmlspecialchars($user['name']) ?></h3>
          <p><?= $isAdmin ? 'Administrator' : 'Member' ?></p>
        </div>
      </div>

      <nav class="sidebar-nav">
        <?php if ($isAdmin): ?>
          <p class="sidebar-section-label">Administration</p>
          <?php foreach ($adminTabs as $t): ?>
            <a href="dashboard.php?tab=<?= $t['id'] ?>"
               class="sidebar-link <?= ($tab === $t['id']) ? 'active' : '' ?>">
              <?= $t['icon'] ?> <?= htmlspecialchars($t['label']) ?>
            </a>
          <?php endforeach; ?>
          <p class="sidebar-section-label">Client View</p>
        <?php endif; ?>

        <?php foreach ($userTabs as $t): ?>
          <a href="dashboard.php?tab=<?= $t['id'] ?>"
             class="sidebar-link <?= ($tab === $t['id']) ? 'active' : '' ?>">
            <?= $t['icon'] ?> <?= htmlspecialchars($t['label']) ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <div class="sidebar-footer">
        <a href="index.php" class="sidebar-link" style="border-left:none;padding-left:0;">
          <?= $icons['home'] ?> Home
        </a>
        <a href="logout.php" class="logout-btn">
          <?= $icons['logout'] ?> Logout
        </a>
      </div>
    </aside>

    <!-- ======== Main Content ======== -->
    <div class="main-content">
      <!-- Top Bar -->
      <header class="top-bar">
        <div style="display:flex;align-items:center;gap:16px;">
          <label for="sidebarToggle" class="mobile-menu-btn" aria-label="Open menu">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
          </label>
          <div class="breadcrumb">
            <span>Dashboard</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            <span class="current"><?= htmlspecialchars(tabLabel($tab)) ?></span>
          </div>
        </div>
        <div class="top-bar-actions">
          <div class="search-bar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" placeholder="Search..." aria-label="Search">
          </div>
          <button class="notif-btn" aria-label="Notifications">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            <span class="badge">3</span>
          </button>
        </div>
      </header>

      <!-- ======== Content Area ======== -->
      <div class="content-area">

        <?php
        // ---- Render active tab using switch ----
        switch ($tab) {

          // ==================== PROFILE ====================
          case 'profile':
        ?>
        <div class="profile-banner">
          <div class="profile-avatar-lg"><?= htmlspecialchars(mb_substr($user['name'], 0, 1)) ?></div>
          <div class="profile-info">
            <h2><?= htmlspecialchars($user['name']) ?></h2>
            <p class="location"><?= $icons['location'] ?> <?= htmlspecialchars($user['city'] ?? 'Unknown') ?></p>
            <p class="member-since">Member since <?= htmlspecialchars($user['joinDate']) ?></p>
          </div>
        </div>
        <div class="profile-stats">
          <div class="stat-card-sm"><p class="label">Total Orders</p><p class="value">12</p></div>
          <div class="stat-card-sm"><p class="label">Total Spent</p><p class="value">$14,560</p></div>
          <div class="stat-card-sm"><p class="label">Loyalty Tier</p><p class="value">Gold</p></div>
        </div>
        <div style="background:var(--surface);border:1px solid var(--border);padding:28px;">
          <h3 style="font-family:var(--font-display);font-size:1rem;margin-bottom:16px;">Recent Activity</h3>
          <div style="display:flex;flex-direction:column;gap:12px;">
            <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);">
              <span style="font-size:0.85rem;">Order NM-2847 delivered</span>
              <span style="font-size:0.75rem;color:var(--text-muted);">Jan 15, 2025</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);">
              <span style="font-size:0.85rem;">Added Silk Meridian to wishlist</span>
              <span style="font-size:0.75rem;color:var(--text-muted);">Jan 12, 2025</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:12px 0;">
              <span style="font-size:0.85rem;">Profile updated</span>
              <span style="font-size:0.75rem;color:var(--text-muted);">Jan 8, 2025</span>
            </div>
          </div>
        </div>
        <?php break;

          // ==================== CATALOG ====================
          case 'catalog':
        ?>
        <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;margin-bottom:24px;">Collection</h2>
        <div class="catalog-grid">
          <?php foreach ($products as $p): ?>
          <div class="catalog-card">
            <div class="catalog-card-img"><img src="<?= htmlspecialchars($p['img']) ?>" alt="<?= htmlspecialchars($p['name']) ?>"></div>
            <div class="catalog-card-body">
              <div class="info">
                <h3><?= htmlspecialchars($p['name']) ?></h3>
                <p><?= htmlspecialchars($p['cat']) ?></p>
              </div>
              <span class="price">$<?= number_format($p['price']) ?></span>
            </div>
            <a href="dashboard.php?tab=new-order" class="add-order-btn">Add to Order</a>
          </div>
          <?php endforeach; ?>
        </div>
        <?php break;

          // ==================== HISTORY ====================
          case 'history':
        ?>
        <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;margin-bottom:24px;">Purchase History</h2>
        <div style="overflow-x:auto;">
          <table class="data-table">
            <thead>
              <tr>
                <th>Order ID</th><th>Date</th><th>Items</th><th>Total</th><th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orderHistory as $o): ?>
              <tr>
                <td style="font-weight:500;"><?= htmlspecialchars($o['id']) ?></td>
                <td><?= htmlspecialchars($o['date']) ?></td>
                <td><?= htmlspecialchars($o['items']) ?></td>
                <td style="color:var(--gold);font-family:var(--font-display);">$<?= number_format($o['total']) ?></td>
                <td><?= statusBadge($o['status']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php break;

          // ==================== SETTINGS ====================
          case 'settings':
        ?>
        <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;margin-bottom:32px;">Update Profile</h2>

        <?php
        if (!empty($updateMsg)) {
            [$msgType, $msgText] = explode(':', $updateMsg, 2);
            $bgColor    = ($msgType === 'success') ? '#0a1a0a' : '#2a0a0a';
            $borderColor= ($msgType === 'success') ? '#1a5c1a' : '#8b1a1a';
            $textColor  = ($msgType === 'success') ? '#4ade80' : '#f87171';
            echo "<div style='background:{$bgColor};border:1px solid {$borderColor};color:{$textColor};padding:12px 16px;margin-bottom:24px;font-size:0.85rem;'>" . htmlspecialchars($msgText) . "</div>";
        }
        ?>

        <form class="update-form" method="POST" action="dashboard.php?tab=settings" enctype="multipart/form-data">
          <input type="hidden" name="action" value="update_profile">

          <p class="section-heading">Personal Information</p>

          <div class="form-group">
            <label>Avatar (optional)</label>
            <label class="avatar-upload" for="avatarInput" id="avatarDrop">
              <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 16V4m0 0L8 8m4-4l4 4"/><path d="M20 16v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2"/></svg>
              <span id="avatarLabel">Click to upload new profile picture</span>
              <input type="file" id="avatarInput" name="avatar" accept="image/*" hidden>
            </label>
          </div>

          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>City / Location</label>
              <input type="text" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>
          </div>

          <p class="section-heading">Security</p>
          <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="current_password" placeholder="Enter current password">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>New Password</label>
              <input type="password" name="new_password" placeholder="New password">
            </div>
            <div class="form-group">
              <label>Confirm New Password</label>
              <input type="password" name="confirm_password" placeholder="Confirm new password">
            </div>
          </div>

          <button type="submit" class="btn-gold" style="margin-top:20px;">Save Changes</button>
        </form>
        <?php break;

          // ==================== NEW ORDER ====================
          case 'new-order':
        ?>
        <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;margin-bottom:24px;">New Order</h2>

        <?php
        if (!empty($updateMsg) && str_starts_with($updateMsg, 'success')) {
            [,$msgText] = explode(':', $updateMsg, 2);
            echo "<div style='background:#0a1a0a;border:1px solid #1a5c1a;color:#4ade80;padding:12px 16px;margin-bottom:24px;font-size:0.85rem;'>" . htmlspecialchars($msgText) . "</div>";
        }
        ?>

        <form method="POST" action="dashboard.php?tab=new-order">
          <input type="hidden" name="action" value="place_order">
          <div class="new-order-layout">
            <div class="order-products-grid">
              <?php foreach ($products as $p): ?>
              <div class="order-product-card">
                <div class="order-product-thumb"><img src="<?= htmlspecialchars($p['img']) ?>" alt="<?= htmlspecialchars($p['name']) ?>"></div>
                <div class="order-product-info">
                  <h4><?= htmlspecialchars($p['name']) ?></h4>
                  <p class="order-price">$<?= number_format($p['price']) ?></p>
                  <div class="qty-control">
                    <span style="font-size:0.75rem;color:var(--text-muted);">Qty:</span>
                    <input type="number" name="qty[<?= $p['id'] ?>]" value="0" min="0" max="10"
                           style="width:60px;background:var(--surface-alt);border:1px solid var(--border);color:var(--text);padding:4px 8px;text-align:center;">
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <div class="order-summary">
              <h3>Order Summary</h3>
              <p style="font-size:0.85rem;color:var(--text-muted);padding:16px 0;">Set quantities above, then click Place Order.</p>
              <div class="order-summary-total" style="margin-top:12px;">
                <span>Customer</span>
                <span style="font-size:0.85rem;"><?= htmlspecialchars($user['name']) ?></span>
              </div>
              <button type="submit" class="btn-gold" style="width:100%;justify-content:center;margin-top:20px;">
                Place Order
              </button>
            </div>
          </div>
        </form>
        <?php break;

          // ==================== ADMIN: STATS ====================
          case 'admin-stats':
          if (!$isAdmin) { echo '<p>Access denied.</p>'; break; }
        ?>
        <div class="admin-stats-grid">
          <div class="admin-stat-card">
            <div class="icon"><?= $icons['dollar'] ?></div>
            <p class="stat-label">Total Revenue</p>
            <p class="stat-value">$377,000</p>
            <p class="stat-change">+12.5% from last month</p>
          </div>
          <div class="admin-stat-card">
            <div class="icon"><?= $icons['clipboard'] ?></div>
            <p class="stat-label">Total Orders</p>
            <p class="stat-value">1,248</p>
            <p class="stat-change">+8.2% from last month</p>
          </div>
          <div class="admin-stat-card">
            <div class="icon"><?= $icons['users'] ?></div>
            <p class="stat-label">Active Customers</p>
            <p class="stat-value">864</p>
            <p class="stat-change">+5.1% from last month</p>
          </div>
          <div class="admin-stat-card">
            <div class="icon"><?= $icons['chart'] ?></div>
            <p class="stat-label">Avg Order Value</p>
            <p class="stat-value">$302</p>
            <p class="stat-change">+3.8% from last month</p>
          </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
          <div style="background:var(--surface);border:1px solid var(--border);padding:28px;">
            <h3 style="font-family:var(--font-display);font-size:1rem;margin-bottom:20px;">Recent Orders</h3>
            <?php foreach (array_slice($adminOrders, 0, 4) as $o): ?>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--border);">
              <div>
                <p style="font-size:0.85rem;font-weight:500;"><?= htmlspecialchars($o['id']) ?></p>
                <p style="font-size:0.7rem;color:var(--text-muted);"><?= htmlspecialchars($o['customer']) ?></p>
              </div>
              <div style="text-align:right;">
                <p style="font-size:0.85rem;color:var(--gold);font-family:var(--font-display);">$<?= number_format($o['total']) ?></p>
                <?= statusBadge($o['status']) ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <div style="background:var(--surface);border:1px solid var(--border);padding:28px;">
            <h3 style="font-family:var(--font-display);font-size:1rem;margin-bottom:20px;">Top Customers</h3>
            <?php foreach (array_slice($customers, 0, 4) as $c): ?>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--border);">
              <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:32px;height:32px;border-radius:50%;background:var(--surface-alt);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:600;color:var(--gold);">
                  <?= htmlspecialchars(mb_substr($c['name'], 0, 1)) ?>
                </div>
                <div>
                  <p style="font-size:0.85rem;font-weight:500;"><?= htmlspecialchars($c['name']) ?></p>
                  <p style="font-size:0.7rem;color:var(--text-muted);"><?= htmlspecialchars($c['city']) ?></p>
                </div>
              </div>
              <span style="font-size:0.8rem;color:var(--text-muted);"><?= $c['orders'] ?> orders</span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php break;

          // ==================== ADMIN: CUSTOMERS ====================
          case 'admin-customers':
          if (!$isAdmin) { echo '<p>Access denied.</p>'; break; }
        ?>
        <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;margin-bottom:24px;">Customers</h2>
        <div style="overflow-x:auto;">
          <table class="data-table">
            <thead>
              <tr><th>Customer</th><th>Email</th><th>Location</th><th>Joined</th><th>Orders</th></tr>
            </thead>
            <tbody>
              <?php foreach ($customers as $c): ?>
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:32px;height:32px;border-radius:50%;background:var(--surface-alt);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:600;color:var(--gold);">
                      <?= htmlspecialchars(mb_substr($c['name'], 0, 1)) ?>
                    </div>
                    <span style="font-weight:500;"><?= htmlspecialchars($c['name']) ?></span>
                  </div>
                </td>
                <td style="color:var(--text-muted);"><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['city']) ?></td>
                <td><?= htmlspecialchars($c['joined']) ?></td>
                <td style="color:var(--gold);font-family:var(--font-display);"><?= $c['orders'] ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php break;

          // ==================== ADMIN: ORDERS ====================
          case 'admin-orders':
          if (!$isAdmin) { echo '<p>Access denied.</p>'; break; }
          $filterStatus = htmlspecialchars($_GET['status'] ?? 'all');
        ?>
        <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;margin-bottom:24px;">Order Management</h2>

        <!-- Filter via GET -->
        <form method="GET" action="dashboard.php" class="filter-bar" style="margin-bottom:20px;">
          <input type="hidden" name="tab" value="admin-orders">
          <select name="status" onchange="this.form.submit()"
                  style="background:var(--surface);border:1px solid var(--border);color:var(--text);padding:8px 12px;font-family:var(--font-body);font-size:0.8rem;">
            <?php
            $statuses = ['all'=>'All Statuses','Delivered'=>'Delivered','Pending'=>'Pending','Processing'=>'Processing','Cancelled'=>'Cancelled'];
            foreach ($statuses as $val => $label):
            ?>
              <option value="<?= $val ?>" <?= ($filterStatus === $val) ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
          </select>
        </form>

        <div style="overflow-x:auto;">
          <table class="data-table">
            <thead>
              <tr><th>Order ID</th><th>Customer</th><th>Date</th><th>Total</th><th>Status</th></tr>
            </thead>
            <tbody>
              <?php foreach ($adminOrders as $o):
                if ($filterStatus !== 'all' && $o['status'] !== $filterStatus) continue;
              ?>
              <tr>
                <td style="font-weight:500;"><?= htmlspecialchars($o['id']) ?></td>
                <td><?= htmlspecialchars($o['customer']) ?></td>
                <td><?= htmlspecialchars($o['date']) ?></td>
                <td style="color:var(--gold);font-family:var(--font-display);">$<?= number_format($o['total']) ?></td>
                <td><?= statusBadge($o['status']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php break;

          // ==================== ADMIN: FINANCES ====================
          case 'admin-finances':
          if (!$isAdmin) { echo '<p>Access denied.</p>'; break; }
          $maxVal = max(array_column($revenueData, 'value'));
        ?>
        <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;margin-bottom:24px;">Finances</h2>

        <div class="chart-container">
          <h3>Revenue Overview (Last 7 Months)</h3>
          <div class="chart-bars">
            <?php foreach ($revenueData as $d):
              $height = round(($d['value'] / $maxVal) * 180);
            ?>
            <div class="chart-bar-group">
              <div class="chart-bar" style="height:<?= $height ?>px;" title="$<?= number_format($d['value']) ?>"></div>
              <span class="chart-bar-label"><?= htmlspecialchars($d['month']) ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="kpi-row">
          <div class="kpi-card"><p class="kpi-label">Gross Revenue</p><p class="kpi-value" style="color:var(--gold);">$377,000</p></div>
          <div class="kpi-card"><p class="kpi-label">Net Profit</p><p class="kpi-value">$142,800</p></div>
          <div class="kpi-card"><p class="kpi-label">Profit Margin</p><p class="kpi-value" style="color:var(--gold);">37.9%</p></div>
        </div>

        <div style="margin-top:28px;background:var(--surface);border:1px solid var(--border);padding:28px;">
          <h3 style="font-family:var(--font-display);font-size:1rem;margin-bottom:20px;">Monthly Breakdown</h3>
          <table class="data-table">
            <thead>
              <tr><th>Month</th><th>Revenue</th><th>Orders</th><th>Avg. Order</th></tr>
            </thead>
            <tbody>
              <?php foreach ($revenueData as $d):
                $orders   = (int)floor($d['value'] / 300);
                $avgOrder = $orders > 0 ? (int)floor($d['value'] / $orders) : 0;
              ?>
              <tr>
                <td style="font-weight:500;"><?= htmlspecialchars($d['month']) ?> 2025</td>
                <td style="color:var(--gold);font-family:var(--font-display);">$<?= number_format($d['value']) ?></td>
                <td><?= $orders ?></td>
                <td style="color:var(--text-muted);">$<?= number_format($avgOrder) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php break;

          // ==================== DEFAULT ====================
          default:
            echo '<p style="color:var(--text-muted);">Tab not found.</p>';
            break;
        } // end switch
        ?>

      </div><!-- /.content-area -->
    </div><!-- /.main-content -->
  </div><!-- /.dashboard -->

</body>
</html>
