<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Alumni</title>
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">

        <div class="login-header">
            <h2>Buat Akun</h2>
            <p>Daftarkan akun alumni</p>
        </div>

        <form class="login-form" method="POST" action="proses_register.php">

            <!-- Nama -->
            <div class="form-group">
                <div class="input-wrapper">
                    <input type="text" name="username" required>
                    <label>Nama</label>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <div class="input-wrapper">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <div class="input-wrapper">
                    <input type="password" name="password" required minlength="6">
                    <label>Password</label>
                </div>
            </div>

            <button type="submit" class="login-btn">
                <span class="btn-text">Lanjutkan</span>
            </button>

        </form>

        <div class="signup-link">
            <p>Sudah punya akun?
                <a href="loginakun.php">Login</a>
            </p>
        </div>

    </div>
</div>

</body>
</html>
