<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Alumni</title>
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Login Alumni</h2>
                <p>Masukan Akun Anda</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
<div class="error-message show" style="margin-bottom:15px">
    <?php
        if ($_GET['error'] === 'email') echo "Email tidak terdaftar";
        if ($_GET['error'] === 'password') echo "Password salah";
        if ($_GET['error'] === 'kosong') echo "Email & password wajib diisi";
    ?>
</div>
<?php endif; ?>
            
            <form class="login-form" id="loginForm" method="POST" action="proses_login.php">
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" required autocomplete="email">
                        <label for="email">Email</label>
                    </div>
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                        <label for="password">Password</label>
                        <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                            <span class="toggle-icon"></span>
                        </button>
                    </div>
                    <span class="error-message" id="passwordError"></span>
                </div>

                <div class="form-options">
                    <div class="remember-wrapper">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" class="checkbox-label">
                            <span class="checkmark"></span>
                            Ingatkan Saya
                        </label>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <span class="btn-text">Login</span>
                    <span class="btn-loader"></span>
                </button>
            </form>

            <div class="signup-link">
                <p>Belum punya akun?
                    <a href="buat_akun.php">Buat Akun</a>
                </p>
            </div>

            <div class="success-message" id="successMessage">
                <div class="success-icon">✓</div>
                <h3>Welcome back!</h3>
                <p>Redirecting to your dashboard...</p>
            </div>
        </div>
    </div>

    <script src="../../shared/js/form-utils.js"></script>
    <script src="loginscript.js"></script>
</body>
</html>