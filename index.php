<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

$stories = all_stories();
$categories = array_values(array_unique(array_filter(array_column($stories, 'category'))));
$query = trim((string)($_GET['q'] ?? ''));
$category = trim((string)($_GET['category'] ?? ''));
$filtered = array_values(array_filter($stories, static function (array $story) use ($query, $category): bool {
    $haystack = $story['title'] . ' ' . $story['author'] . ' ' . $story['description'];
    $matchesQuery = $query === '' || (function_exists('mb_stripos') ? mb_stripos($haystack, $query) !== false : stripos($haystack, $query) !== false);
    $matchesCategory = $category === '' || $story['category'] === $category;
    return $matchesQuery && $matchesCategory;
}));
$pageTitle = 'Trạm Truyện — chạm vào thế giới của riêng bạn';
$activeNav = 'home';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div class="hero-copy">
        <span class="eyebrow"><span class="eyebrow-dot"></span> MỘT GÓC NHỎ CHO TÂM HỒN</span>
        <h1>Rời phố thị.<br><em>Ghé vào</em> một câu chuyện.</h1>
        <p>Chậm lại một chút, chọn một câu chuyện và để trí tưởng tượng đưa bạn đi thật xa.</p>
        <a class="button button-dark" href="#catalog">Khám phá truyện <span aria-hidden="true">↗</span></a>
        <div class="reader-note"><div class="reader-avatars"><span>H</span><span>M</span><span>A</span><span>+</span></div><span><strong>2.4k+</strong> độc giả đang đọc</span></div>
    </div>
    <div class="hero-art" aria-label="Những cuốn sách trên bàn cạnh cửa sổ">
        <div class="hero-image"></div><div class="hero-label"><span class="label-star">✳</span><div><strong>Chuyện hay, mỗi ngày</strong><small>Thế giới của bạn bắt đầu từ đây</small></div><span class="label-arrow">↗</span></div>
        <div class="hero-sticker">READ<br>YOUR<br>STORY</div>
    </div>
</section>

<section class="category-strip" aria-label="Thể loại phổ biến">
    <span class="strip-label">TÂM TRẠNG HÔM NAY</span>
    <a href="?category=Chữa%20lành">☼ &nbsp;Chữa lành</a><a href="?category=Thanh%20xuân">✿ &nbsp;Thanh xuân</a><a href="?category=Kỳ%20ảo">✳ &nbsp;Kỳ ảo</a><a href="?category=Đời%20thường">⌂ &nbsp;Đời thường</a>
</section>

<section class="catalog-section" id="catalog">
    <div class="section-heading"><div><span class="eyebrow">TỦ SÁCH CỦA BẠN</span><h2>Những câu chuyện <em>đáng đọc</em></h2></div><a class="text-link" href="#new">Xem truyện mới <span>↗</span></a></div>
    <form class="filter-bar" action="index.php" method="get">
        <label class="search-box"><span>⌕</span><input type="search" name="q" value="<?= e($query) ?>" placeholder="Tìm tên truyện, tác giả..."></label>
        <label class="select-wrap"><span class="sr-only">Chọn thể loại</span><select name="category"><option value="">Tất cả thể loại</option><?php foreach ($categories as $item): ?><option value="<?= e($item) ?>" <?= $category === $item ? 'selected' : '' ?>><?= e($item) ?></option><?php endforeach; ?></select></label>
        <button class="button button-dark filter-button" type="submit">Tìm kiếm</button>
    </form>
    <div class="story-grid">
        <?php foreach ($filtered as $index => $story): ?>
            <article class="story-card" style="--card-delay: <?= $index * 50 ?>ms">
                <a class="cover-link" href="story.php?id=<?= (int)$story['id'] ?>" aria-label="Đọc <?= e($story['title']) ?>"><img class="story-cover" src="<?= e($story['cover']) ?>" alt="Bìa truyện <?= e($story['title']) ?>" loading="lazy"><span class="cover-badge"><?= e($story['status']) ?></span><span class="cover-open">↗</span></a>
                <div class="story-info"><div class="story-meta"><span><?= e($story['category'] ?: 'Truyện dài') ?></span><span><?= number_format((int)$story['views']) ?> lượt đọc</span></div><h3><a href="story.php?id=<?= (int)$story['id'] ?>"><?= e($story['title']) ?></a></h3><p><?= e($story['author']) ?> <span>·</span> <?= (int)$story['chapters'] ?> chương</p></div>
            </article>
        <?php endforeach; ?>
    </div>
    <?php if (!$filtered): ?><div class="empty-state"><span>⌕</span><h3>Chưa tìm thấy câu chuyện phù hợp</h3><p>Thử từ khóa khác hoặc chọn tất cả thể loại nhé.</p><a class="text-link" href="index.php">Xem toàn bộ truyện ↗</a></div><?php endif; ?>
</section>

<section class="reading-banner" id="new"><div class="banner-icon">✳</div><div><span class="eyebrow">GÓC ĐỌC CỦA BẠN</span><h2>Một chương thôi.<br><em>Rồi thêm một chương nữa.</em></h2><p>Những câu chuyện mới vẫn đang chờ bạn mở trang đầu tiên.</p></div><a class="button button-light" href="#catalog">Chọn truyện ngay <span>↗</span></a><div class="banner-decoration">READ<br>SLOWLY</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
