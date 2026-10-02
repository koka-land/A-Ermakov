<?php
require_once __DIR__ . '/auth.php';

$materials = $pdo->query(
    "SELECT id, title, slug, status, updated_at FROM materials ORDER BY updated_at DESC"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Материалы — админка</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Roboto:wght@100;300;400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="/css/admin.css">
</head>
<body>
<div class="page-frame">
<div class="dashboard-container">
  <div class="full-page">
  <div class="full-page-scroll">
    <div class="wrap">
      <div class="top">
        <div>
          <a class="back" href="/admin/dashboard.php">← Дашборд</a>
          <h1 style="display:inline;">Материалы</h1>
        </div>
        <div>
          <a class="btn" href="/admin/editor.php">+ Новая статья</a>
          <a class="logout" href="/admin/logout.php">Выйти</a>
        </div>
      </div>

      <?php if (!$materials): ?>
        <div class="empty">Материалов пока нет — начните с «+ Новая статья».</div>
      <?php else: ?>
      <table>
        <tr><th>Заголовок</th><th>Статус</th><th>Обновлено</th></tr>
        <?php foreach ($materials as $m): ?>
        <tr>
          <td><a class="row-link" href="/admin/editor.php?id=<?= $m['id'] ?>"><?= htmlspecialchars($m['title']) ?></a></td>
          <td><span class="status <?= $m['status'] ?>"><?= $m['status'] === 'published' ? 'Опубликовано' : 'Черновик' ?></span></td>
          <td><?= htmlspecialchars($m['updated_at']) ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php endif; ?>
    </div>
  </div>
  </div>
</div>
</div>
</body>
</html>