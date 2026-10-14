<?php
$pageTitle = $pageTitle ?? 'Trạm Truyện — chạm vào thế giới của riêng bạn';
$activeNav = $activeNav ?? 'home';
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f8f7f3">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="header-inner">
        <a class="brand" href="index.php" aria-label="Trạm Truyện, trang chủ"><span class="brand-mark">t.</span><span>trạm truyện</span></a>
        <nav class="main-nav" aria-label="Điều hướng chính">
            <a class="<?= $activeNav === 'home' ? 'active' : '' ?>" href="index.php">Khám phá</a>
            <a href="index.php#catalog">Thể loại</a>
            <a href="index.php#new">Mới cập nhật</a>
        </nav>
        <a class="header-action" href="index.php#catalog"><span class="search-icon">⌕</span><span>Tìm truyện</span></a>
        <button class="menu-toggle" type="button" aria-label="Mở menu" aria-expanded="false"><span></span><span></span></button>
    </div>
</header>
<main>
