<?php
require_once __DIR__ . '/../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['is_admin'] = true;
        header('Location: /admin/materials.php');
        exit;
    }

    $error = 'Неверный логин или пароль';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Вход в админку</title>
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/dashboard.css">
<style>
  .login-box{
    max-width:360px;width:90%;background:#fff;border-radius:16px;
    padding:36px 32px;box-shadow:0 10px 30px rgba(12,42,54,.08);
  }
  .login-box h1{font-size:1.3rem;margin:0 0 20px;color:var(--text-primary);}
  .login-box input{
    width:100%;padding:12px 14px;margin-bottom:14px;border:1px solid rgba(12,42,54,.15);
    border-radius:10px;font-family:var(--font-main);font-size:.95rem;box-sizing:border-box;
  }
  .login-box button{
    width:100%;padding:12px;border:none;border-radius:10px;background:var(--text-primary);
    color:#fff;font-weight:700;font-size:.95rem;cursor:pointer;
  }
  .login-error{color:#e76f51;font-size:.85rem;margin:-6px 0 14px;}
</style>
</head>
<body>
  <div class="page-frame">
    <div class="dashboard-container centered">
      <div class="login-box">
        <h1>Вход в админку</h1>
        <?php if ($error): ?><p class="login-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form method="post">
          <input type="text" name="username" placeholder="Логин" required autofocus>
          <input type="password" name="password" placeholder="Пароль" required>
          <button type="submit">Войти</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>