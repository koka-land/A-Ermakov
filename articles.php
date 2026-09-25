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
<link rel="stylesheet" href="/css/style.css">
<style>
  .article-wrap{max-width:680px;margin:60px auto;padding:0 20px;}
  .article-wrap h1{font-family:'Montserrat',sans-serif;font-weight:700;font-size:2.1rem;margin-bottom:8px;}
  .article-body h2{font-size:1.4rem;margin-top:2em;}
  .article-body h3{font-size:1.15rem;margin-top:1.6em;}
  .article-body p{line-height:1.7;font-size:1.02rem;}
  .article-code{
    background:#0c2a36;color:#dce8ec;padding:16px 18px;border-radius:10px;
    overflow-x:auto;font-family:'JetBrains Mono',monospace;font-size:.88rem;line-height:1.6;
  }
</style>
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
