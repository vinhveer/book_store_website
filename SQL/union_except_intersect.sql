-- client > components > book.php --
SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Comic Books'
    UNION
    SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Games & Activities'
    UNION
    SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Home & Garden';
    card_display($sqlh7, "Giải trí và Giáo dục", $conn);

SELECT TOP 6 * FROM (
        SELECT b.book_name, p.product_image, p.product_price, p.product_id
            FROM books b
            JOIN products p ON b.product_id = p.product_id
            JOIN book_categories bc ON b.book_category_id = bc.book_category_id
            WHERE bc.book_category_name = 'Philosophy'
            UNION
            SELECT b.book_name, p.product_image, p.product_price, p.product_id
            FROM books b
            JOIN products p ON b.product_id = p.product_id
            JOIN book_categories bc ON b.book_category_id = bc.book_category_id
            WHERE bc.book_category_name = 'History'
            UNION
            SELECT b.book_name, p.product_image, p.product_price, p.product_id
            FROM books b
            JOIN products p ON b.product_id = p.product_id
            JOIN book_categories bc ON b.book_category_id = bc.book_category_id
            WHERE bc.book_category_name = 'Social Sciences'
        ) AS book      
    card_display($sqlh8, "Khoa học và Xã hội", $conn);

SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Art'
    UNION
    SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Cooking'
    UNION
    SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Computer Science';
    card_display($sqlh9, "Văn học và Nghệ thuật", $conn);
    
-- client > components > index --
 UNION
    SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b/-strong/-heart:>:o:-((:-hJOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Health & Wellness'
    UNION
    SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Mind & Body';
    card_display($sqlh2, "Phát triển bản thân", $conn);

-- client > components > stationery --
UNION
    SELECT TOP 3 od.others_product_name, p.product_image, p.product_price, p.product_id
    FROM others_products  od
    JOIN products p ON od.product_id = p.product_id 
    WHERE od.others_product_name LIKE '%gel%';
    card_display($sqlh6, "Đồ dùng văn phòng", $conn);