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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $material ? 'Редактирование' : 'Новая статья' ?></title>
<link rel="stylesheet" href="/css/style.css">
<style>
  body{padding:0;}
  .editor-topbar{
    position:sticky;top:0;z-index:10;background:#fff;
    display:flex;justify-content:space-between;align-items:center;
    padding:16px 32px;border-bottom:1px solid rgba(12,42,54,.06);
  }
  .editor-topbar input[type="text"]{
    font-family:var(--font-main);font-size:1.1rem;font-weight:700;
    border:none;outline:none;color:var(--text-primary);width:60%;
  }
  .editor-topbar input[type="text"]::placeholder{color:rgba(12,42,54,.3);}
  .actions{display:flex;gap:10px;align-items:center;}
  .actions select, .actions button{
    font-family:var(--font-main);font-size:.85rem;padding:9px 14px;border-radius:8px;
    border:1px solid rgba(12,42,54,.15);background:#fff;cursor:pointer;
  }
  .actions button.primary{background:var(--text-primary);color:#fff;border:none;font-weight:600;}
  #save-status{font-size:.8rem;color:var(--text-secondary);margin-right:6px;}
  .editor-wrap{max-width:720px;margin:40px auto 100px;padding:0 20px;}
  .codex-editor{font-family:var(--font-main);}
  a.back{color:var(--text-secondary);text-decoration:none;font-size:.85rem;margin-right:16px;}
</style>
</head>
<body>

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

<div class="editor-wrap">
  <div id="editorjs"></div>
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

  saveBtn.addEventListener('click', async () => {
    const title = document.getElementById('material-title').value.trim();
    if (!title) {
      alert('Добавьте заголовок статьи');
      return;
    }

    statusEl.textContent = 'Сохранение…';
    const content = await editor.save();

    try {
      const res = await fetch('/admin/api/save.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          id: materialId,
          title,
          status: document.getElementById('material-status').value,
          content
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
