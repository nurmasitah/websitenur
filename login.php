<?php
session_start();

// Data login statis (contoh)
// Data Klien
$valid_client_email = "user@desainrumah.com";
$valid_client_phone = "08123456789";

// Data Admin
$valid_admin_email = "admin@desainrumah.com";
$valid_admin_password = "adminpass"; // Password statis untuk admin

$success = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $email    = isset($_POST['email']) ? $_POST['email'] : '';
    $phone    = isset($_POST['phone']) ? $_POST['phone'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // --- Logika Login Admin ---
    if ($email === $valid_admin_email && $password === $valid_admin_password) {
        $success = "🔑 Login berhasil sebagai **Admin**! Selamat datang di dashboard, $fullname.";
        $_SESSION['user_role'] = 'Admin';
        $_SESSION['user_name'] = $fullname;
    } 
    // --- Logika Login Klien Biasa ---
    else if ($email === $valid_client_email && $phone === $valid_client_phone) {
        // Asumsi klien tidak perlu memasukkan password dalam skenario ini,
        // tetapi skrip PHP menerima input password dari form.
        $success = "✅ Login berhasil! Selamat bergabung dengan kami, $fullname.";
        $_SESSION['user_role'] = 'Client';
        $_SESSION['user_name'] = $fullname;
    } 
    // --- Login Gagal ---
    else {
        $error = "❌ Login gagal! Data tidak sesuai. Pastikan Email, Nomor Telepon (untuk klien) atau Password (untuk Admin) Anda benar.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Klien/Admin - Modern Living Hub</title>
    <style>
        :root {
            --color-primary: #1f3a46;
            --color-secondary: #6f7577;
            --color-background: #eef1f5;
            --color-white: #ffffff;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 0;
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; background-color: var(--color-background);
        }
        .auth-card {
            width: 90%; max-width: 450px;
            background-color: var(--color-white);
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            overflow: hidden;
        }
        .auth-header {
            background-color: var(--color-primary);
            color: var(--color-white);
            padding: 30px 20px; text-align: center;
        }
        .auth-header h2 {margin:0; font-size:28px; font-weight:700;}
        .auth-header p {margin-top:5px; font-size:15px; opacity:0.9;}
        .auth-form-area {padding:30px;}
        .form-group {margin-bottom:20px;}
        label {display:block; margin-bottom:6px; font-weight:600; color:#333; font-size:14px;}
        /* Menambahkan input[type="password"] ke styling */
        input[type="text"], input[type="email"], input[type="tel"], input[type="password"] {
            width:100%; padding:12px; border:1px solid #c9d2db;
            border-radius:6px; box-sizing:border-box; font-size:16px;
        }
        .btn-submit {
            width:100%; padding:14px; background-color:var(--color-primary);
            color:var(--color-white); border:none; border-radius:6px;
            cursor:pointer; font-size:17px; font-weight:700; margin-top:15px;
        }
        .btn-submit:hover {background-color:#0d1e26;}
        .notification {
            margin-top:15px; padding:12px; border-radius:6px;
            text-align:center; font-weight:bold;
        }
        .success {background:#d4edda; color:#155724; border:1px solid #c3e6cb;}
        .error {background:#f8d7da; color:#721c24; border:1px solid #f5c6cb;}
        /* Catatan: Untuk login admin, pengguna dapat mengisi bidang telepon/password
           tetapi dalam contoh statis ini, hanya Email dan Password yang diperiksa untuk admin.
           Teks di bawah form akan menjelaskan ini.
        */
        .note {
            margin-top: 25px;
            font-size: 13px;
            color: var(--color-secondary);
            text-align: center;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }
        .note strong {color: var(--color-primary);}
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <h2>Masuk Klien & Admin</h2>
            <p>Akses akun Anda dan mulai.</p>
        </div>

        <div class="auth-form-area">
            <form id="login-form" action="" method="POST"> 
                <div class="form-group">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" id="fullname" name="fullname" required value="<?= isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon (Hanya untuk Klien)</label>
                    <input type="tel" id="phone" name="phone" placeholder="Contoh: 08123456789 (Kosongkan jika Admin)" value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password (Hanya untuk Admin)</label>
                    <input type="password" id="password" name="password" placeholder="Hanya diisi jika Login Admin">
                </div>
                <button type="submit" class="btn-submit">Login</button>
            </form>

            <?php if(isset($success)): ?>
                <div class="notification success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if(isset($error)): ?>
                <div class="notification error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="note">
                <p>Data Login Coba (Statis):</p>
                <p><strong>Klien:</strong> Email: `<?= $valid_client_email ?>`, Telepon: `<?= $valid_client_phone ?>`</p>
                <p><strong>Admin:</strong> Email: `<?= $valid_admin_email ?>`, Password: `<?= $valid_admin_password ?>` (Nomor Telepon diabaikan)</p>
            </div>
        </div>
    </div>
</body>
</html>