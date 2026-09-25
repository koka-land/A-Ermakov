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
<link rel="stylesheet" href="/css/style.css">
<style>
  body{padding:40px;}
  .wrap{max-width:900px;margin:0 auto;}
  .top{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;}
  h1{font-size:1.5rem;margin:0;}
  .btn{
    background:var(--text-primary);color:#fff;padding:10px 18px;border-radius:10px;
    text-decoration:none;font-weight:600;font-size:.9rem;
  }
  table{width:100%;border-collapse:collapse;background:#fff;border-radius:14px;overflow:hidden;}
  th,td{text-align:left;padding:14px 16px;border-bottom:1px solid rgba(12,42,54,.06);font-size:.92rem;}
  th{color:var(--text-secondary);font-weight:600;font-size:.8rem;text-transform:uppercase;letter-spacing:.03em;}
  .status{padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;}
  .status.draft{background:rgba(244,162,97,.15);color:#f4a261;}
  .status.published{background:rgba(42,157,143,.15);color:#2a9d8f;}
  a.row-link{color:var(--text-primary);text-decoration:none;font-weight:600;}
  .empty{padding:40px;text-align:center;color:var(--text-secondary);}
  .logout{color:var(--text-secondary);font-size:.85rem;text-decoration:none;margin-left:16px;}
</style>
</head>
<body>
<div class="wrap">
  <div class="top">
    <h1>Материалы</h1>
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
</body>
</html>
