<?php
require_once __DIR__ . '/auth.php';

$total     = (int) $pdo->query("SELECT COUNT(*) AS c FROM materials")->fetch()['c'];
$published = (int) $pdo->query("SELECT COUNT(*) AS c FROM materials WHERE status = 'published'")->fetch()['c'];
$drafts    = (int) $pdo->query("SELECT COUNT(*) AS c FROM materials WHERE status = 'draft'")->fetch()['c'];

$recent = $pdo->query(
    "SELECT id, title, status, updated_at FROM materials ORDER BY updated_at DESC LIMIT 5"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Дашборд — админка</title>
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
        <h1>Дашборд</h1>
        <a class="logout" href="/admin/logout.php">Выйти</a>
      </div>

      <div class="dashboard-grid" style="margin-bottom:32px;">
        <div class="stat-card">
          <span class="stat-value"><?= $total ?></span>
          <span class="stat-label">Всего материалов</span>
        </div>
        <div class="stat-card">
          <span class="stat-value published"><?= $published ?></span>
          <span class="stat-label">Опубликовано</span>
        </div>
        <div class="stat-card">
          <span class="stat-value draft"><?= $drafts ?></span>
          <span class="stat-label">Черновики</span>
        </div>
      </div>

      <div class="quick-actions">
        <a class="btn" href="/admin/editor.php">+ Новая статья</a>
        <a class="btn secondary" href="/admin/materials.php">Все материалы →</a>
      </div>

      <h2 class="section-title">Недавно изменённые</h2>

      <?php if (!$recent): ?>
        <div class="empty">Материалов пока нет — начните с «+ Новая статья».</div>
      <?php else: ?>
      <table>
        <tr><th>Заголовок</th><th>Статус</th><th>Обновлено</th></tr>
        <?php foreach ($recent as $m): ?>
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