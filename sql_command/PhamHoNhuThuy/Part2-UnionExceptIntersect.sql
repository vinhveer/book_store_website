-- Retrieves the top 2 books from the 'Comic Books' category
SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
FROM books b
JOIN products p ON b.product_id = p.product_id
JOIN book_categories bc ON b.book_category_id = bc.book_category_id
WHERE bc.book_category_name = 'Comic Books'
UNION
-- Retrieves the top 2 books from the 'Games & Activities' category
SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
FROM books b
JOIN products p ON b.product_id = p.product_id
JOIN book_categories bc ON b.book_category_id = bc.book_category_id
WHERE bc.book_category_name = 'Games & Activities'
UNION
-- Retrieves the top 2 books from the 'Home & Garden' category
SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
FROM books b
JOIN products p ON b.product_id = p.product_id
JOIN book_categories bc ON b.book_category_id = bc.book_category_id
WHERE bc.book_category_name = 'Home & Garden';

-- Retrieves the top 6 books from the 'Philosophy', 'History', and 'Social Sciences' categories
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
) AS book;

-- Retrieves the top 2 books from the 'Art', 'Cooking', and 'Computer Science' categories
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

-- Retrieves the top 6 other products excluding 'bút gel' but including other products starting with 'bút'
SELECT TOP 6 * FROM (
    SELECT od.others_product_name, p.product_image, p.product_price, p.product_id
    FROM others_products od
    JOIN products p ON od.product_id = p.product_id 
    WHERE od.others_product_name LIKE 'bút%'
    EXCEPT
    SELECT od.others_product_name, p.product_image, p.product_price, p.product_id
    FROM others_products od
    JOIN products p ON od.product_id = p.product_id 
    WHERE od.others_product_name LIKE 'bút gel%'
) AS othersproducts;

-- Retrieves the top 6 other products with the name containing 'Thiên Long'
SELECT TOP 6 od.others_product_name, p.product_image, p.product_price, p.product_id
FROM others_products od
JOIN products p ON od.product_id = p.product_id 
WHERE od.others_product_name LIKE '%Thiên Long%';

-- Retrieves the top 3 other products starting with 'máy tính' and those containing 'gel'
SELECT TOP 3 od.others_product_name, p.product_image, p.product_price, p.product_id
FROM others_products od
JOIN products p ON od.product_id = p.product_id 
WHERE od.others_product_name LIKE 'máy tính%'
UNION
SELECT TOP 3 od.others_product_name, p.product_image, p.product_price, p.product_id
FROM others_products od
JOIN products p ON od.product_id = p.product_id 
WHERE od.others_product_name LIKE '%gel%';

-- Retrieves the top 6 books without any category filter
SELECT TOP 6 b.book_name, p.product_image, p.product_price, p.product_id
FROM books b
JOIN products p ON b.product_id = p.product_id;

-- Retrieves the top 2 books from the 'Self-Help', 'Health & Wellness', and 'Mind & Body' categories
SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
FROM books b
JOIN products p ON b.product_id = p.product_id
JOIN book_categories bc ON b.book_category_id = bc.book_category_id
WHERE bc.book_category_name = 'Self-Help'
UNION
SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
FROM books b
JOIN products p ON b.product_id = p.product_id
JOIN book_categories bc ON b.book_category_id = bc.book_category_id
WHERE bc.book_category_name = 'Health & Wellness'
UNION
SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
FROM books b
JOIN products p ON b.product_id = p.product_id
JOIN book_categories bc ON b.book_category_id = bc.book_category_id
WHERE bc.book_category_name = 'Mind & Body';

-- Retrieves the top 6 cheapest other products with a price of '20000'
SELECT TOP 6 * FROM(
    SELECT od.others_product_name, p.product_image, p.product_price, p.product_id
    FROM others_products od
    JOIN products p ON od.product_id = p.product_id 
    GROUP BY od.others_product_name, p.product_image, p.product_price, p.product_id
    HAVING p.product_price = '20000'
) AS cheap;
