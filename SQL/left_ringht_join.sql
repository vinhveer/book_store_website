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