-- Counts the total number of users with role_id 2
SELECT COUNT(*) AS total_records FROM users u
    INNER JOIN user_roles ur ON u.user_id = ur.user_id
    INNER JOIN roles r ON ur.role_id = r.role_id
    WHERE r.role_id=2;

-- Counts the total number of users with role_id 1
SELECT COUNT(*) AS total_records FROM users u
    INNER JOIN user_roles ur ON u.user_id = ur.user_id
    INNER JOIN roles r ON ur.role_id = r.role_id
    WHERE r.role_id=1;

-- Counts the total number of users with role_id 3
SELECT COUNT(*) AS total_records FROM users u
    INNER JOIN user_roles ur ON u.user_id = ur.user_id
    INNER JOIN roles r ON ur.role_id = r.role_id
    WHERE r.role_id=3;

-- Counts the total number of online orders
SELECT COUNT(*) AS total FROM orders_online;

-- Counts the total number of offline orders
SELECT COUNT(*) AS total FROM orders_offline;

-- Counts the number of online orders by status and the number of shipments by delivery status
SELECT
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Pending') AS pending_orders,
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Confirmed') AS confirmed_orders,
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Deleted') AS deleted_orders,
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Completed') AS completed_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'In Transit') AS in_transit_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'Failed') AS failed_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'Delivered') AS delivered_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'Scheduled') AS scheduled_orders,
    (SELECT COUNT(*) FROM orders_offline) AS offline_orders;

-- Calculates the average publication year of books by category, only for categories with an average year after 2000
SELECT book_category_id, AVG(book_publication_year) AS avg_publication_year
FROM books
GROUP BY book_category_id
HAVING AVG(book_publication_year) > 2000;

-- Counts the total number of books by publisher, only for publishers with less than 100 books
SELECT book_publisher_id, COUNT(product_id) AS total_books
FROM books
GROUP BY book_publisher_id
HAVING COUNT(product_id) < 100;

-- Sums the total weight of other products by brand, only for brands with a total weight over 500
SELECT others_product_brand_id, SUM(others_product_weight) AS total_weight
FROM others_products
GROUP BY others_product_brand_id
HAVING SUM(others_product_weight) > 500;

-- Counts the total number of books by language, only for languages with more than 50 books
SELECT book_language_id, COUNT(product_id) AS total_books
FROM books
GROUP BY book_language_id
HAVING COUNT(product_id) > 50;
