<?php
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['noir_user'])) {
    header('Location: dashboard.php');
    exit;
}

$error   = '';
$success = '';
$fields  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize all POST inputs
    $fullName        = htmlspecialchars(trim($_POST['fullName']        ?? ''));
    $email           = filter_var(trim($_POST['email']           ?? ''), FILTER_SANITIZE_EMAIL);
    $password        = trim($_POST['password']        ?? '');
    $confirmPassword = trim($_POST['confirmPassword'] ?? '');
    $city            = htmlspecialchars(trim($_POST['city']            ?? ''));
    $phone           = htmlspecialchars(trim($_POST['phone']           ?? ''));

    // Preserve typed values for form re-fill
    $fields = compact('fullName', 'email', 'city', 'phone');

    // --- Validation using if / elseif ---
    if (empty($fullName)) {
        $error = 'Full name is required.';
    } elseif (strlen($fullName) < 2) {
        $error = 'Full name must be at least 2 characters.';
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (empty($password) || strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        // --- File Upload Handling ---
        $avatarFilename = '';

        if (!empty($_FILES['avatar']['name'])) {
            $file      = $_FILES['avatar'];
            $allowed   = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize   = 2 * 1024 * 1024; // 2MB

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $error = 'Avatar upload failed. Please try again.';
            } elseif (!in_array($file['type'], $allowed)) {
                $error = 'Only JPG, PNG, GIF, or WEBP images are allowed.';
            } elseif ($file['size'] > $maxSize) {
                $error = 'Avatar image must be under 2MB.';
            } else {
                $ext            = pathinfo($file['name'], PATHINFO_EXTENSION);
                $avatarFilename = 'avatar_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $uploadDir      = __DIR__ . '/../uploads/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $uploadDir . $avatarFilename)) {
                    $error = 'Could not save avatar. Please try again.';
                }
            }
        }

        // Register user if no errors
        if (empty($error)) {
            $_SESSION['noir_user'] = [
                'name'     => $fullName,
                'email'    => $email,
                'city'     => $city,
                'phone'    => $phone,
                'role'     => 'user',
                'joinDate' => date('Y-m-d'),
                'avatar'   => $avatarFilename,
            ];
            header('Location: dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#0a0a0a">
  <title>Create Account | NOIR MAISON</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <div class="auth-split">
    <!-- Left: Editorial Image -->
    <div class="auth-image">
      <img src="../images/auth-editorial.jpg" alt="Fashion editorial">
      <div class="auth-image-overlay">
        <h2>Join the<br>Maison</h2>
        <p>Enter a world of dark luxury and avant-garde elegance.</p>
      </div>
    </div>

    <!-- Right: Registration Form -->
    <div class="auth-form-side">
      <div class="auth-form-container">
        <p class="form-logo">NOIR <span>MAISON</span></p>
        <p class="form-subtitle">Create your exclusive account</p>

        <?php if (!empty($error)): ?>
          <div style="background:#2a0a0a;border:1px solid #8b1a1a;color:#f87171;padding:12px 16px;margin-bottom:20px;font-size:0.85rem;letter-spacing:0.03em;">
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <!-- enctype required for file upload -->
        <form method="POST" action="register.php" enctype="multipart/form-data">

          <!-- Avatar Upload -->
          <div class="form-group">
            <label>Avatar</label>
            <label class="avatar-upload" for="avatarInput" id="avatarDrop">
              <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M12 16V4m0 0L8 8m4-4l4 4"/>
                <path d="M20 16v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2"/>
              </svg>
              <span id="avatarLabel">Drop image or click to upload</span>
              <input type="file" id="avatarInput" name="avatar" accept="image/*" hidden>
            </label>
          </div>

          <div class="form-group">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName"
                   placeholder="Enter your full name"
                   value="<?= htmlspecialchars($fields['fullName'] ?? '') ?>"
                   required>
          </div>

          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email"
                   placeholder="your@email.com"
                   value="<?= htmlspecialchars($fields['email'] ?? '') ?>"
                   required>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password"
                     placeholder="Min 8 characters" required minlength="8">
            </div>
            <div class="form-group">
              <label for="confirmPassword">Confirm Password</label>
              <input type="password" id="confirmPassword" name="confirmPassword"
                     placeholder="Re-enter password" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="city">City / Location</label>
              <input type="text" id="city" name="city"
                     placeholder="Paris, FR"
                     value="<?= htmlspecialchars($fields['city'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="tel" id="phone" name="phone"
                     placeholder="+33 1 42 ..."
                     value="<?= htmlspecialchars($fields['phone'] ?? '') ?>">
            </div>
          </div>

          <button type="submit" class="form-submit">Create Account</button>

          <p class="form-links">
            Already a member? <a href="login.php">Sign In</a>
          </p>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
