<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
$story = find_story(max(0, (int)($_GET['story'] ?? 0)));
$chapterNumber = max(1, (int)($_GET['chapter'] ?? 1));
$chapter = $story ? chapter_content((int)$story['id'], $chapterNumber) : null;
if (!$story || !$chapter) {
    http_response_code(404);
    $pageTitle = 'Không tìm thấy chương — Trạm Truyện';
    $activeNav = 'home';
    require __DIR__ . '/includes/header.php';
    echo '<section class="empty-state page-empty"><span>⌕</span><h3>Không tìm thấy chương này</h3><p>Hãy quay lại danh sách truyện để chọn một chương khác.</p><a class="button button-dark" href="index.php">Về trang chủ</a></section>';
    require __DIR__ . '/includes/footer.php';
    exit;
}
$chapters = story_chapters((int)$story['id']);
$previous = $chapterNumber > 1 ? $chapterNumber - 1 : null;
$next = $chapterNumber < count($chapters) ? $chapterNumber + 1 : null;
$pageTitle = $chapter['title'] . ' — ' . $story['title'];
$activeNav = 'home';
require __DIR__ . '/includes/header.php';
?>
<section class="reader-page" data-reader>
    <div class="reader-top"><a class="reader-back" href="story.php?id=<?= (int)$story['id'] ?>">← <span><?= e($story['title']) ?></span></a><div class="reader-tools"><button type="button" data-font="down" aria-label="Giảm cỡ chữ">A−</button><button type="button" data-font="up" aria-label="Tăng cỡ chữ">A+</button><button type="button" data-theme aria-label="Đổi nền đọc">◐</button></div></div>
    <article class="reader-content"><div class="reader-heading"><span class="eyebrow"><?= e($story['title']) ?></span><h1>Chương <?= (int)$chapter['chapter_number'] ?></h1><p><?= e($chapter['title']) ?></p><div class="reader-divider"><span>✳</span></div></div><div class="chapter-body" data-chapter-body><?php foreach (preg_split('/\R\R+/', (string)$chapter['content']) as $paragraph): ?><p><?= e($paragraph) ?></p><?php endforeach; ?></div><div class="reader-end">✳ &nbsp; Hết chương <?= (int)$chapter['chapter_number'] ?> &nbsp; ✳</div><div class="reader-navigation"><?php if ($previous): ?><a class="button button-outline" href="chapter.php?story=<?= (int)$story['id'] ?>&chapter=<?= $previous ?>">← Chương trước</a><?php else: ?><span></span><?php endif; ?><?php if ($next): ?><a class="button button-dark" href="chapter.php?story=<?= (int)$story['id'] ?>&chapter=<?= $next ?>">Chương tiếp theo →</a><?php else: ?><a class="button button-dark" href="story.php?id=<?= (int)$story['id'] ?>">Về trang truyện ↗</a><?php endif; ?></div></article>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
