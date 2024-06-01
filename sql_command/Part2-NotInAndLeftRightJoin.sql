SELECT
    CASE
        WHEN b.product_id IS NOT NULL THEN 'Book'
        ELSE 'Stationery'
    END AS product_type,
    CAST(p.product_price AS INT) AS PricePerUnit,
    p.product_image,
    p.product_status,
    COALESCE(b.product_id, op.product_id) AS product_id,
    COALESCE(b.book_name, op.others_product_name) AS product_name,
    COALESCE(b.book_description, op.others_product_description) AS product_description,
    COALESCE(bc.book_category_name, NULL) AS category_name,
    COALESCE(bl.book_language, NULL) AS language,
    COALESCE(b.book_publication_year, NULL) AS publication_year,
    COALESCE(b.book_packaging_size, op.others_product_size) AS packaging_size,
    COALESCE(b.book_format, NULL) AS book_format,
    COALESCE(b.book_ISBN, NULL) AS ISBN,
    COALESCE(bp.book_publisher_name, NULL) AS publisher_name,
    COALESCE(op.others_product_brand_id, NULL) AS brand_id,
    COALESCE(br.brand_name, NULL) AS brand_name,
    COALESCE(op.others_product_color, NULL) AS color,
    COALESCE(op.others_product_material, NULL) AS material,
    COALESCE(op.others_product_weight, NULL) AS weight
    FROM
        products p
    LEFT JOIN books b ON p.product_id = b.product_id
    LEFT JOIN others_products op ON p.product_id = op.product_id
    LEFT JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    LEFT JOIN book_languages bl ON b.book_language_id = bl.book_language_id
    LEFT JOIN book_publishers bp ON b.book_publisher_id = bp.book_publisher_id
    LEFT JOIN brands br ON op.others_product_brand_id = br.brand_id
    WHERE
        p.product_id = $product_id

SELECT oo.order_id, oo.order_date_on,
                    COALESCE(s.delivery_status, 'Scheduled') AS delivery_status,
                    u.full_name, ue.full_name as employee_name,
                    oo.status_on, oo.note_on
                    FROM orders_online AS oo
                    JOIN customers AS c ON oo.customer_id = c.customer_id
                    JOIN users AS u ON c.user_id = u.user_id
                    LEFT JOIN shipper AS s ON oo.order_id = s.order_id
                    LEFT JOIN employees AS e ON s.employee_id = e.employee_id
                    LEFT JOIN users AS ue ON e.user_id = ue.user_id
                    ORDER BY oo.order_date_on DESC

SELECT b.*
FROM books b
RIGHT JOIN book_author ba ON b.product_id = ba.product_id
WHERE ba.author_id IS NULL;

SELECT p.*
FROM products p
RIGHT JOIN product_categories pc ON p.category_id = pc.category_id
WHERE p.category_id IS NULL;

SELECT op.*
FROM others_products op
RIGHT JOIN brands b ON op.others_product_brand_id = b.brand_id
WHERE op.others_product_brand_id IS NULL;

SELECT b.*
FROM books b
RIGHT JOIN book_publishers bp ON b.book_publisher_id = bp.book_publisher_id
WHERE b.book_publisher_id IS NULL;

SELECT *
FROM books
WHERE product_id NOT IN (
    SELECT product_id
    FROM book_author
);

SELECT *
FROM products
WHERE category_id NOT IN (
    SELECT category_id
    FROM product_categories
);
