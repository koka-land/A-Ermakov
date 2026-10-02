<?php
require_once __DIR__ . '/auth.php';

$categoryId = isset($_GET['category']) ? (int) $_GET['category'] : null;

// --- Текущая категория + хлебные крошки ---
$breadcrumb = [];
$currentCategory = null;

if ($categoryId) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$categoryId]);
    $currentCategory = $stmt->fetch();

    if (!$currentCategory) {
        $categoryId = null;
    } else {
        $node = $currentCategory;
        while ($node) {
            array_unshift($breadcrumb, $node);
            if (!$node['parent_id']) break;
            $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
            $stmt->execute([$node['parent_id']]);
            $node = $stmt->fetch();
        }
    }
}

// --- Подкатегории текущего уровня ---
if ($categoryId) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = ? ORDER BY name");
    $stmt->execute([$categoryId]);
} else {
    $stmt = $pdo->query("SELECT * FROM categories WHERE parent_id IS NULL ORDER BY name");
}
$subcategories = $stmt->fetchAll();

// --- Материалы текущего уровня ---
if ($categoryId) {
    $stmt = $pdo->prepare(
        "SELECT m.* FROM materials m
         JOIN material_categories mc ON mc.material_id = m.id
         WHERE mc.category_id = ?
         ORDER BY m.updated_at DESC"
    );
    $stmt->execute([$categoryId]);
} else {
    // На верхнем уровне — материалы без единой категории
    $stmt = $pdo->query(
        "SELECT m.* FROM materials m
         LEFT JOIN material_categories mc ON mc.material_id = m.id
         WHERE mc.material_id IS NULL
         ORDER BY m.updated_at DESC"
    );
}
$materials = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Материалы — админка</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Roboto:wght@100;300;400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="/css/admin.css">
</head>
<body>
<div class="page-frame">
<div class="dashboard-container">
<?php include __DIR__ . '/includes/sidebar.php'; ?>
  <div class="full-page">
  <div class="full-page-scroll">
    <div class="wrap wrap-full">

      <div class="top">
        <h1>Материалы</h1>
        <div>
          <a class="btn" href="/admin/editor.php<?= $categoryId ? '?category=' . $categoryId : '' ?>">+ Новая статья</a>
          <a class="logout" href="/admin/logout.php">Выйти</a>
        </div>
      </div>

      <div class="breadcrumb">
        <a href="/admin/materials.php">Все материалы</a>
        <?php foreach ($breadcrumb as $node): ?>
          <span>/</span>
          <a href="/admin/materials.php?category=<?= $node['id'] ?>"><?= htmlspecialchars($node['name']) ?></a>
        <?php endforeach; ?>
      </div>

      <?php if ($subcategories): ?>
        <h2 class="section-title">Разделы</h2>
        <div class="box-grid">
          <?php foreach ($subcategories as $cat): ?>
            <a class="box-card" href="/admin/materials.php?category=<?= $cat['id'] ?>">
              <span class="material-symbols-rounded box-icon"><?= htmlspecialchars($cat['icon']) ?></span>
              <span class="box-title"><?= htmlspecialchars($cat['name']) ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <h2 class="section-title">Материалы<?= $categoryId ? '' : ' без категории' ?></h2>
      <?php if (!$materials): ?>
        <div class="empty">Материалов здесь пока нет.</div>
      <?php else: ?>
        <div class="box-grid">
          <?php foreach ($materials as $m): ?>
            <a class="box-card material" href="/admin/editor.php?id=<?= $m['id'] ?>">
              <span class="material-symbols-rounded box-icon">description</span>
              <span class="box-title"><?= htmlspecialchars($m['title']) ?></span>
              <span class="status <?= $m['status'] ?>"><?= $m['status'] === 'published' ? 'Опубликовано' : 'Черновик' ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
  </div>
</div>
</div>
</body>
</html>