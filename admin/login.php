<?php
require_once __DIR__ . '/../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['is_admin'] = true;
        header('Location: /admin/dashboard.php');
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
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Roboto:wght@100;300;400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/admin.css">
</head>
<body>
  <div class="page-frame">
      <div class="login-box">
        <h1>Вход в админку</h1>
        <?php if ($error): ?><p class="login-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form method="post">
          <input type="text" name="username" placeholder="Логин" required autofocus>
          <input type="password" name="password" placeholder="Пароль" required>
          <button type="submit">Войти</button>
        </form>
        <a class="back-to-site" href="/">← Вернуться на сайт</a>
      </div>
  </div>
</body>
</html>