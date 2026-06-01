<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Alumni</title>
    <link rel="stylesheet" href="loginadmin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Login Admin</h2>
                <p>Masukan Akun Anda</p>
            </div>
            
            <form class="login-form" id="loginForm" method="POST" action="proses_login_admin.php">
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
                    </div>
                </div>
                <button type="submit" class="login-btn">
                    <span class="btn-text">Login</span>
                    <span class="btn-loader"></span>
                </button>
            </form>
        </div>
    </div>
    
</body>
</html>