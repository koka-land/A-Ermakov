<?php
require_once __DIR__ . '/config.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) {
    die('Статья не указана');
}

$stmt = $pdo->prepare("SELECT * FROM materials WHERE slug = ? AND status = 'published'");
$stmt->execute([$slug]);
$article = $stmt->fetch();

if (!$article) {
    http_response_code(404);
    die('Статья не найдена');
}

$content = json_decode($article['content'], true);

function renderBlock(array $block): string
{
    $type = $block['type'];
    $data = $block['data'];

    switch ($type) {
        case 'header':
            $level = (int) ($data['level'] ?? 2);
            return "<h{$level}>" . $data['text'] . "</h{$level}>";

        case 'paragraph':
            return "<p>" . $data['text'] . "</p>";

        case 'list':
            $tag = ($data['style'] ?? 'unordered') === 'ordered' ? 'ol' : 'ul';
            $items = '';
            foreach ($data['items'] as $item) {
                $items .= "<li>{$item}</li>";
            }
            return "<{$tag}>{$items}</{$tag}>";

        case 'code':
            $escaped = htmlspecialchars($data['code'] ?? '', ENT_QUOTES);
            return "<pre class=\"article-code\"><code>{$escaped}</code></pre>";

        default:
            return '';
    }
}

$bodyHtml = '';
foreach ($content['blocks'] ?? [] as $block) {
    $bodyHtml .= renderBlock($block) . "\n";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($article['title']) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Roboto:wght@100;300;400;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/articles.css">
</head>
<body>
  <div class="article-wrap">
    <h1><?= htmlspecialchars($article['title']) ?></h1>
    <div class="article-body">
      <?= $bodyHtml ?>
    </div>
  </div>
</body>
</html>