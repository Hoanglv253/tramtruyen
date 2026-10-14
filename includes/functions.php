<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function demo_stories(): array
{
    return [
        ['id' => 1, 'title' => 'Tiệm sách cuối con hẻm', 'author' => 'An Nhiên', 'category' => 'Đời thường', 'description' => 'Một tiệm sách nhỏ, một thành phố nhiều mưa và những cuộc gặp gỡ làm cuộc sống dịu dàng hơn.', 'cover' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=700&q=85', 'status' => 'Đang ra', 'views' => 18420, 'chapters' => 18],
        ['id' => 2, 'title' => 'Mùa hè năm ấy có cậu', 'author' => 'Lam Hạ', 'category' => 'Thanh xuân', 'description' => 'Tình bạn, những lá thư chưa gửi và một mùa hè mà cả hai đều không muốn quên.', 'cover' => 'https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?auto=format&fit=crop&w=700&q=85', 'status' => 'Hoàn thành', 'views' => 26300, 'chapters' => 32],
        ['id' => 3, 'title' => 'Người giữ giấc mơ', 'author' => 'Minh Khuê', 'category' => 'Kỳ ảo', 'description' => 'Ở nơi giấc mơ có thể được cất giữ, cô gái trẻ đi tìm ký ức đã mất của mình.', 'cover' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=700&q=85', 'status' => 'Đang ra', 'views' => 31500, 'chapters' => 24],
        ['id' => 4, 'title' => 'Bếp nhỏ ngày mưa', 'author' => 'Mộc Miên', 'category' => 'Chữa lành', 'description' => 'Những món ăn đơn giản và câu chuyện của những người ghé qua căn bếp nhỏ.', 'cover' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=700&q=85', 'status' => 'Hoàn thành', 'views' => 12800, 'chapters' => 15],
        ['id' => 5, 'title' => 'Thành phố trên mây', 'author' => 'Dạ Vũ', 'category' => 'Kỳ ảo', 'description' => 'Một chuyến tàu đêm đưa Linh đến thành phố lơ lửng giữa những tầng mây.', 'cover' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=700&q=85', 'status' => 'Đang ra', 'views' => 9700, 'chapters' => 11],
        ['id' => 6, 'title' => 'Gửi cậu của ngày mai', 'author' => 'Hạ Vy', 'category' => 'Thanh xuân', 'description' => 'Mỗi ngày một bức thư. Mỗi bức thư là một cơ hội để bắt đầu lại.', 'cover' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=700&q=85', 'status' => 'Hoàn thành', 'views' => 22100, 'chapters' => 27],
    ];
}

function all_stories(): array
{
    $pdo = db();
    if (!$pdo) {
        return demo_stories();
    }
    try {
        $query = $pdo->query(
            'SELECT s.id, s.title, s.author, s.description, s.cover, s.status, s.views,
                    (SELECT c.name FROM categories c JOIN story_categories sc ON sc.category_id = c.id WHERE sc.story_id = s.id LIMIT 1) AS category,
                    (SELECT COUNT(*) FROM chapters ch WHERE ch.story_id = s.id) AS chapters
             FROM stories s ORDER BY s.updated_at DESC, s.id DESC'
        );
        $stories = $query->fetchAll();
        return $stories ?: demo_stories();
    } catch (PDOException $exception) {
        error_log('Tram Truyen story query failed: ' . $exception->getMessage());
        return demo_stories();
    }
}

function find_story(int $id): ?array
{
    $pdo = db();
    if ($pdo) {
        try {
            $statement = $pdo->prepare(
                'SELECT s.id, s.title, s.author, s.description, s.cover, s.status, s.views,
                        (SELECT c.name FROM categories c JOIN story_categories sc ON sc.category_id = c.id WHERE sc.story_id = s.id LIMIT 1) AS category,
                        (SELECT COUNT(*) FROM chapters ch WHERE ch.story_id = s.id) AS chapters
                 FROM stories s WHERE s.id = :id LIMIT 1'
            );
            $statement->execute(['id' => $id]);
            $story = $statement->fetch();
            if ($story) {
                return $story;
            }
        } catch (PDOException $exception) {
            error_log('Tram Truyen story lookup failed: ' . $exception->getMessage());
        }
    }
    foreach (demo_stories() as $story) {
        if ((int)$story['id'] === $id) {
            return $story;
        }
    }
    return null;
}

function story_chapters(int $storyId): array
{
    $pdo = db();
    if ($pdo) {
        try {
            $statement = $pdo->prepare('SELECT id, chapter_number, title FROM chapters WHERE story_id = :id ORDER BY chapter_number ASC');
            $statement->execute(['id' => $storyId]);
            $chapters = $statement->fetchAll();
            if ($chapters) {
                return $chapters;
            }
        } catch (PDOException $exception) {
            error_log('Tram Truyen chapter query failed: ' . $exception->getMessage());
        }
    }
    return [
        ['id' => 1, 'chapter_number' => 1, 'title' => 'Ngày đầu tiên'],
        ['id' => 2, 'chapter_number' => 2, 'title' => 'Một cuộc gặp tình cờ'],
        ['id' => 3, 'chapter_number' => 3, 'title' => 'Lời hẹn bên cửa sổ'],
    ];
}

function chapter_content(int $storyId, int $chapterNumber): ?array
{
    $pdo = db();
    if ($pdo) {
        try {
            $statement = $pdo->prepare('SELECT id, chapter_number, title, content FROM chapters WHERE story_id = :story_id AND chapter_number = :chapter_number LIMIT 1');
            $statement->execute(['story_id' => $storyId, 'chapter_number' => $chapterNumber]);
            $chapter = $statement->fetch();
            if ($chapter) {
                return $chapter;
            }
        } catch (PDOException $exception) {
            error_log('Tram Truyen chapter lookup failed: ' . $exception->getMessage());
        }
    }

    $titles = [1 => 'Ngày đầu tiên', 2 => 'Một cuộc gặp tình cờ', 3 => 'Lời hẹn bên cửa sổ'];
    if (!isset($titles[$chapterNumber])) {
        return null;
    }
    return [
        'id' => $chapterNumber,
        'chapter_number' => $chapterNumber,
        'title' => $titles[$chapterNumber],
        'content' => "Chiều hôm ấy, thành phố vừa kịp tạnh mưa. Những giọt nước còn đọng trên ô cửa kính, phản chiếu ánh đèn vàng ấm áp từ con phố bên ngoài.\n\nCô đặt cuốn sách lên quầy, khẽ phủi vài hạt mưa trên bìa. Mùi giấy cũ và cà phê mới pha quyện vào nhau, thân thuộc như thể nơi này đã chờ cô từ rất lâu.\n\n“Bạn đang tìm một câu chuyện để đọc, hay một nơi để nghỉ chân?” người chủ tiệm hỏi.\n\nCô ngẫm nghĩ. Có lẽ câu trả lời là cả hai. Ngoài kia, thành phố vẫn vội vã trôi qua, còn trong căn phòng nhỏ này, thời gian dường như chậm lại vừa đủ để người ta lắng nghe lòng mình.\n\nVà đôi khi, một khởi đầu mới chỉ cần như thế: một buổi chiều dịu mát, một trang sách đang mở, cùng lời chào của một người xa lạ."
    ];
}
