UPDATE books
SET book_category_id = FLOOR(RAND() * 14) + 1;


-- Tạo bảng tạm thời để lưu trữ product_id và giá trị book_category_id ngẫu nhiên
CREATE TABLE #TempBooks (
    product_id BIGINT,
    book_category_id INT
);

-- Chèn product_id và giá trị book_category_id ngẫu nhiên vào bảng tạm thời
INSERT INTO #TempBooks (product_id, book_category_id)
SELECT product_id, ABS(CHECKSUM(NEWID()) % 14) + 1
FROM books;

-- Cập nhật bảng books bằng cách sử dụng bảng tạm thời
UPDATE b
SET b.book_category_id = t.book_category_id
FROM books b
JOIN #TempBooks t ON b.product_id = t.product_id;

-- Xóa bảng tạm thời
DROP TABLE #TempBooks;