CREATE DATABASE IF NOT EXISTS tram_truyen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tram_truyen;

CREATE TABLE IF NOT EXISTS stories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(120) NOT NULL,
    description TEXT NOT NULL,
    cover VARCHAR(500) NOT NULL,
    status ENUM('Đang ra', 'Hoàn thành', 'Tạm ngưng') NOT NULL DEFAULT 'Đang ra',
    views INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS story_categories (
    story_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (story_id, category_id),
    CONSTRAINT fk_story_categories_story FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
    CONSTRAINT fk_story_categories_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS chapters (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    story_id INT UNSIGNED NOT NULL,
    chapter_number INT UNSIGNED NOT NULL,
    title VARCHAR(200) NOT NULL,
    content LONGTEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_story_chapter (story_id, chapter_number),
    CONSTRAINT fk_chapters_story FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT IGNORE INTO categories (id, name) VALUES
(1, 'Đời thường'), (2, 'Thanh xuân'), (3, 'Kỳ ảo'), (4, 'Chữa lành');

INSERT IGNORE INTO stories (id, title, author, description, cover, status, views) VALUES
(1, 'Tiệm sách cuối con hẻm', 'An Nhiên', 'Một tiệm sách nhỏ, một thành phố nhiều mưa và những cuộc gặp gỡ làm cuộc sống dịu dàng hơn.', 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=700&q=85', 'Đang ra', 18420),
(2, 'Mùa hè năm ấy có cậu', 'Lam Hạ', 'Tình bạn, những lá thư chưa gửi và một mùa hè mà cả hai đều không muốn quên.', 'https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?auto=format&fit=crop&w=700&q=85', 'Hoàn thành', 26300),
(3, 'Người giữ giấc mơ', 'Minh Khuê', 'Ở nơi giấc mơ có thể được cất giữ, cô gái trẻ đi tìm ký ức đã mất của mình.', 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=700&q=85', 'Đang ra', 31500),
(4, 'Bếp nhỏ ngày mưa', 'Mộc Miên', 'Những món ăn đơn giản và câu chuyện của những người ghé qua căn bếp nhỏ.', 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=700&q=85', 'Hoàn thành', 12800),
(5, 'Thành phố trên mây', 'Dạ Vũ', 'Một chuyến tàu đêm đưa Linh đến thành phố lơ lửng giữa những tầng mây.', 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=700&q=85', 'Đang ra', 9700),
(6, 'Gửi cậu của ngày mai', 'Hạ Vy', 'Mỗi ngày một bức thư. Mỗi bức thư là một cơ hội để bắt đầu lại.', 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=700&q=85', 'Hoàn thành', 22100);

INSERT IGNORE INTO story_categories (story_id, category_id) VALUES (1,1),(2,2),(3,3),(4,4),(5,3),(6,2);

INSERT IGNORE INTO chapters (story_id, chapter_number, title, content) VALUES
(1,1,'Ngày đầu tiên','Chiều hôm ấy, thành phố vừa kịp tạnh mưa. Những giọt nước còn đọng trên ô cửa kính, phản chiếu ánh đèn vàng ấm áp từ con phố bên ngoài.\n\nCô đặt cuốn sách lên quầy, khẽ phủi vài hạt mưa trên bìa. Mùi giấy cũ và cà phê mới pha quyện vào nhau, thân thuộc như thể nơi này đã chờ cô từ rất lâu.\n\n“Bạn đang tìm một câu chuyện để đọc, hay một nơi để nghỉ chân?” người chủ tiệm hỏi.\n\nCô ngẫm nghĩ. Có lẽ câu trả lời là cả hai. Ngoài kia, thành phố vẫn vội vã trôi qua, còn trong căn phòng nhỏ này, thời gian dường như chậm lại vừa đủ để người ta lắng nghe lòng mình.\n\nVà đôi khi, một khởi đầu mới chỉ cần như thế: một buổi chiều dịu mát, một trang sách đang mở, cùng lời chào của một người xa lạ.'),
(1,2,'Một cuộc gặp tình cờ','Buổi sáng hôm sau, chiếc chuông nhỏ trên cửa tiệm lại khẽ reo. Nắng len qua khung cửa, nằm yên trên chiếc bàn gỗ cạnh giá sách.\n\nCô quay lại, lần này không phải vì trú mưa. Cô mang theo một cuốn sổ, một chiếc bút và câu hỏi vẫn còn dang dở từ hôm qua.\n\n“Có cuốn sách nào khiến người ta muốn bắt đầu lại không?” cô hỏi.\n\nNgười chủ tiệm mỉm cười, dẫn cô đến chiếc kệ cuối cùng. Có những câu trả lời không nằm trong sách, nhưng đôi khi một câu chuyện hay sẽ giúp ta tìm được đường đến đó.'),
(1,3,'Lời hẹn bên cửa sổ','Mưa trở lại vào cuối tuần. Cô nhìn những vệt nước chạy dài trên kính và nhận ra mình đã bắt đầu quen với âm thanh ấy.\n\nTrên bàn là hai tách trà còn ấm. Người chủ tiệm đặt xuống một cuốn sách bìa xanh, bên trong có một mảnh giấy nhỏ: “Nếu ngày nào cũng ghé qua, tôi sẽ dành cho bạn chỗ ngồi cạnh cửa sổ.”\n\nCô bật cười. Ngoài trời, mưa vẫn rơi, nhưng dường như con hẻm nhỏ đã sáng hơn một chút.');
