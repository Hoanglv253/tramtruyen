<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
$story = find_story(max(0, (int)($_GET['id'] ?? 0)));
if (!$story) {
    http_response_code(404);
    $pageTitle = 'Không tìm thấy truyện — Trạm Truyện';
    $activeNav = 'home';
    require __DIR__ . '/includes/header.php';
    echo '<section class="empty-state page-empty"><span>⌕</span><h3>Không tìm thấy truyện này</h3><p>Câu chuyện có thể đã được chuyển đi mất rồi.</p><a class="button button-dark" href="index.php">Về trang chủ</a></section>';
    require __DIR__ . '/includes/footer.php';
    exit;
}
$chapters = story_chapters((int)$story['id']);
$pageTitle = $story['title'] . ' — Trạm Truyện';
$activeNav = 'home';
require __DIR__ . '/includes/header.php';
?>
<div class="breadcrumb"><a href="index.php">Khám phá</a><span>/</span><span><?= e($story['title']) ?></span></div>
<section class="story-detail">
    <div class="detail-cover-wrap"><img src="<?= e($story['cover']) ?>" alt="Bìa truyện <?= e($story['title']) ?>" class="detail-cover"><span class="cover-badge"><?= e($story['status']) ?></span></div>
    <div class="detail-copy"><span class="eyebrow"><?= e($story['category'] ?: 'TRUYỆN DÀI KỲ') ?></span><h1><?= e($story['title']) ?></h1><p class="detail-author">Tác giả <strong><?= e($story['author']) ?></strong></p><div class="detail-stats"><span><strong><?= (int)$story['chapters'] ?></strong> chương</span><span><strong><?= number_format((int)$story['views']) ?></strong> lượt đọc</span><span><strong>4.9</strong> ★ yêu thích</span></div><p class="detail-description"><?= e($story['description']) ?></p><div class="detail-actions"><a class="button button-dark" href="chapter.php?story=<?= (int)$story['id'] ?>&chapter=1">Đọc từ đầu <span>↗</span></a><a class="button button-outline" href="#chapter-list">Danh sách chương</a></div><div class="detail-note"><span>✦</span> Cập nhật gần đây · Thời gian đọc khoảng 5 phút mỗi chương</div></div>
</section>
<section class="chapter-section" id="chapter-list"><div class="section-heading"><div><span class="eyebrow">MỞ TRANG TIẾP THEO</span><h2>Danh sách <em>chương</em></h2></div><span class="chapter-count"><?= count($chapters) ?> chương</span></div><div class="chapter-list"><?php foreach ($chapters as $chapter): ?><a class="chapter-row" href="chapter.php?story=<?= (int)$story['id'] ?>&chapter=<?= (int)$chapter['chapter_number'] ?>"><span class="chapter-number"><?= str_pad((string)$chapter['chapter_number'], 2, '0', STR_PAD_LEFT) ?></span><span class="chapter-title"><?= e($chapter['title']) ?></span><span class="chapter-date">Vừa cập nhật</span><span class="chapter-arrow">↗</span></a><?php endforeach; ?></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
