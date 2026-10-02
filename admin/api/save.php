<?php
require_once __DIR__ . '/../auth.php';

header('Content-Type: application/json; charset=utf-8');

$input = json_decode(file_get_contents('php://input'), true);

$id         = isset($input['id']) ? (int) $input['id'] : null;
$title      = trim($input['title'] ?? '');
$status     = in_array($input['status'] ?? '', ['draft', 'published'], true) ? $input['status'] : 'draft';
$content    = $input['content'] ?? null;
$categories = array_map('intval', $input['categories'] ?? []);

if ($title === '' || !$content) {
    echo json_encode(['ok' => false, 'error' => 'Не хватает заголовка или контента']);
    exit;
}

$contentJson = json_encode($content, JSON_UNESCAPED_UNICODE);

function makeSlug(string $title, PDO $pdo, ?int $excludeId): string
{
    $translit = [
        'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'zh','з'=>'z',
        'и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r',
        'с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'ts','ч'=>'ch','ш'=>'sh','щ'=>'sch',
        'ъ'=>'','ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya',
    ];
    $lower = mb_strtolower($title);
    $translitStr = strtr($lower, $translit);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $translitStr);
    $slug = trim($slug, '-');
    if ($slug === '') {
        $slug = 'material-' . time();
    }

    $base = $slug;
    $i = 1;
    while (true) {
        $sql = "SELECT id FROM materials WHERE slug = ?" . ($excludeId ? " AND id != ?" : "");
        $stmt = $pdo->prepare($sql);
        $excludeId ? $stmt->execute([$slug, $excludeId]) : $stmt->execute([$slug]);
        if (!$stmt->fetch()) break;
        $slug = $base . '-' . (++$i);
    }
    return $slug;
}

function syncCategories(PDO $pdo, int $materialId, array $categoryIds): void
{
    $pdo->prepare("DELETE FROM material_categories WHERE material_id = ?")->execute([$materialId]);
    if (!$categoryIds) return;

    $stmt = $pdo->prepare("INSERT IGNORE INTO material_categories (material_id, category_id) VALUES (?, ?)");
    foreach (array_unique($categoryIds) as $catId) {
        $stmt->execute([$materialId, $catId]);
    }
}

try {
    if ($id) {
        $stmt = $pdo->prepare(
            "UPDATE materials SET title = ?, content = ?, status = ? WHERE id = ?"
        );
        $stmt->execute([$title, $contentJson, $status, $id]);
        syncCategories($pdo, $id, $categories);
        echo json_encode(['ok' => true, 'id' => $id]);
    } else {
        $slug = makeSlug($title, $pdo, null);
        $stmt = $pdo->prepare(
            "INSERT INTO materials (type, title, slug, content, status) VALUES ('article', ?, ?, ?, ?)"
        );
        $stmt->execute([$title, $slug, $contentJson, $status]);
        $newId = (int) $pdo->lastInsertId();
        syncCategories($pdo, $newId, $categories);
        echo json_encode(['ok' => true, 'id' => $newId]);
    }
} catch (PDOException $e) {
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}