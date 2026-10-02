<?php
require_once __DIR__ . '/auth.php';

// --- Обработка форм ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $name     = trim($_POST['name'] ?? '');
        $icon     = trim($_POST['icon'] ?? '') ?: 'folder';
        $parentId = $_POST['parent_id'] !== '' ? (int) $_POST['parent_id'] : null;

        if ($name !== '') {
            // slug транслитом + проверка уникальности
            $translit = ['а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'zh','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'ts','ч'=>'ch','ш'=>'sh','щ'=>'sch','ъ'=>'','ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya'];
            $base = trim(preg_replace('/[^a-z0-9]+/', '-', strtr(mb_strtolower($name), $translit)), '-');
            if ($base === '') $base = 'category-' . time();
            $slug = $base;
            $i = 1;
            $check = $pdo->prepare("SELECT id FROM categories WHERE slug = ?");
            while (true) {
                $check->execute([$slug]);
                if (!$check->fetch()) break;
                $slug = $base . '-' . (++$i);
            }

            $stmt = $pdo->prepare("INSERT INTO categories (parent_id, name, slug, icon) VALUES (?, ?, ?, ?)");
            $stmt->execute([$parentId, $name, $slug, $icon]);
        }
        header('Location: /admin/categories.php');
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: /admin/categories.php');
        exit;
    }
}

// --- Загрузка всех категорий и построение дерева ---
$all = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

$byParent = [];
foreach ($all as $cat) {
    $byParent[$cat['parent_id']][] = $cat;
}

function renderTree(array $byParent, $parentId, int $depth = 0): string
{
    if (empty($byParent[$parentId])) return '';
    $html = '<ul class="cat-tree' . ($depth === 0 ? '' : ' nested') . '">';
    foreach ($byParent[$parentId] as $cat) {
        $html .= '<li>';
        $html .= '<div class="cat-row">';
        $html .= '<span class="material-symbols-rounded cat-icon">' . htmlspecialchars($cat['icon']) . '</span>';
        $html .= '<span class="cat-name">' . htmlspecialchars($cat['name']) . '</span>';
        $html .= '<form method="post" onsubmit="return confirm(\'Удалить категорию «' . htmlspecialchars($cat['name'], ENT_QUOTES) . '»? Подкатегории станут категориями верхнего уровня.\');">';
        $html .= '<input type="hidden" name="action" value="delete">';
        $html .= '<input type="hidden" name="id" value="' . $cat['id'] . '">';
        $html .= '<button type="submit" class="cat-delete" title="Удалить">&times;</button>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= renderTree($byParent, $cat['id'], $depth + 1);
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Категории — админка</title>
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
        <h1>Категории</h1>
        <a class="logout" href="/admin/logout.php">Выйти</a>
      </div>

      <div class="cat-layout">

        <div class="cat-tree-panel">
          <?php if (!$all): ?>
            <div class="empty">Категорий пока нет — создайте первую справа.</div>
          <?php else: ?>
            <?= renderTree($byParent, null) ?>
          <?php endif; ?>
        </div>

        <div class="cat-form-panel">
          <h2 class="section-title">Новая категория</h2>
          <form method="post" class="cat-form">
            <input type="hidden" name="action" value="create">

            <label>Название</label>
            <input type="text" name="name" placeholder="Например, Алгоритмы" required>

            <label>Иконка (Material Symbols)</label>
            <input type="text" name="icon" placeholder="Например: code, functions, memory">
            <p class="cat-hint">Название иконки с <a href="https://fonts.google.com/icons" target="_blank" rel="noopener">fonts.google.com/icons</a> — если оставить пустым, будет использована стандартная.</p>

            <label>Родительская категория</label>
            <select name="parent_id">
              <option value="">— Нет, категория верхнего уровня —</option>
              <?php foreach ($all as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
              <?php endforeach; ?>
            </select>

            <button type="submit" class="btn">+ Создать категорию</button>
          </form>
        </div>

      </div>

    </div>
  </div>
  </div>
</div>
</div>
</body>
</html>