<?php
require_once __DIR__ . '/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$material = null;

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM materials WHERE id = ?");
    $stmt->execute([$id]);
    $material = $stmt->fetch();
    if (!$material) {
        die('Материал не найден');
    }
}

// --- Категории материала (чекбоксы, с отступом по вложенности) ---
$allCategories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$byParent = [];
foreach ($allCategories as $cat) {
    $byParent[$cat['parent_id']][] = $cat;
}

function flattenCategories(array $byParent, $parentId, int $depth = 0): array
{
    $result = [];
    foreach ($byParent[$parentId] ?? [] as $cat) {
        $cat['depth'] = $depth;
        $result[] = $cat;
        $result = array_merge($result, flattenCategories($byParent, $cat['id'], $depth + 1));
    }
    return $result;
}
$flatCategories = flattenCategories($byParent, null);

$selectedCategoryIds = [];
if ($material) {
    $stmt = $pdo->prepare("SELECT category_id FROM material_categories WHERE material_id = ?");
    $stmt->execute([$material['id']]);
    $selectedCategoryIds = array_column($stmt->fetchAll(), 'category_id');
} elseif (isset($_GET['category'])) {
    // Новый материал, открытый из конкретной категории — сразу отмечаем её
    $selectedCategoryIds = [(int) $_GET['category']];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $material ? 'Редактирование' : 'Новая статья' ?></title>
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
  <div class="editor-topbar">
    <div style="display:flex;align-items:center;">
      <a class="back" href="/admin/materials.php">← Материалы</a>
      <input type="text" id="material-title" placeholder="Заголовок статьи…"
             value="<?= $material ? htmlspecialchars($material['title']) : '' ?>">
    </div>
    <div class="actions">
      <span id="save-status"></span>
      <select id="material-status">
        <option value="draft" <?= (!$material || $material['status'] === 'draft') ? 'selected' : '' ?>>Черновик</option>
        <option value="published" <?= ($material && $material['status'] === 'published') ? 'selected' : '' ?>>Опубликовано</option>
      </select>
      <button class="primary" id="save-btn">Сохранить</button>
    </div>
  </div>

  <div class="full-page-scroll">
    <div class="editor-wrap">

      <div class="cat-picker">
        <span class="cat-picker-label">Категории:</span>
        <?php if (!$flatCategories): ?>
          <span class="cat-hint">Категорий пока нет — создайте их на странице «Категории».</span>
        <?php else: ?>
          <?php foreach ($flatCategories as $cat): ?>
            <label class="cat-checkbox" style="margin-left:<?= $cat['depth'] * 16 ?>px;">
              <input type="checkbox" name="categories[]" value="<?= $cat['id'] ?>"
                <?= in_array($cat['id'], $selectedCategoryIds) ? 'checked' : '' ?>>
              <span class="material-symbols-rounded cat-checkbox-icon"><?= htmlspecialchars($cat['icon']) ?></span>
              <?= htmlspecialchars($cat['name']) ?>
            </label>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <div id="editorjs"></div>
    </div>
  </div>
</div>
</div>
</div>

<!-- Editor.js и нужные блоки — только текст/код/списки, без загрузки картинок (пока) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/editorjs/2.29.1/editorjs.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/editorjs-header/2.8.1/header.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/editorjs-list/1.9.0/list.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/editorjs-code/2.9.0/code.umd.min.js"></script>

<script>
  const existingContent = <?= $material ? $material['content'] : 'null' ?>;

  const editor = new EditorJS({
    holder: 'editorjs',
    placeholder: 'Начните писать статью…',
    data: existingContent || undefined,
    tools: {
      header: { class: Header, config: { levels: [2, 3], defaultLevel: 2 } },
      list: { class: List, inlineToolbar: true },
      code: { class: CodeTool }
    }
  });

  const saveBtn = document.getElementById('save-btn');
  const statusEl = document.getElementById('save-status');
  const materialId = <?= $material ? $material['id'] : 'null' ?>;

  saveBtn.disabled = true;
  editor.isReady
    .then(() => { saveBtn.disabled = false; })
    .catch((err) => { statusEl.textContent = 'Ошибка загрузки редактора'; console.error(err); });

  saveBtn.addEventListener('click', async () => {
    const title = document.getElementById('material-title').value.trim();
    if (!title) {
      alert('Добавьте заголовок статьи');
      return;
    }

    statusEl.textContent = 'Сохранение…';

    try {
      const content = await editor.save(); // теперь внутри try — ошибка не исчезает молча
      const categories = Array.from(
        document.querySelectorAll('input[name="categories[]"]:checked')
      ).map(cb => parseInt(cb.value, 10));

      const res = await fetch('/admin/api/save.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          id: materialId,
          title,
          status: document.getElementById('material-status').value,
          content,
          categories
        })
      });
      const data = await res.json();

      if (data.ok) {
        statusEl.textContent = 'Сохранено';
        if (!materialId) {
          // Новый материал — переходим в режим редактирования с полученным id
          window.location.href = '/admin/editor.php?id=' + data.id;
        }
      } else {
        statusEl.textContent = '';
        alert('Ошибка сохранения: ' + (data.error || 'неизвестная'));
      }
    } catch (err) {
      statusEl.textContent = '';
      alert('Не удалось сохранить: ' + err.message);
    }
  });
</script>
</body>
</html>