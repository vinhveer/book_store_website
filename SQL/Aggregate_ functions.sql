SELECT COUNT(*) AS total_records FROM users u
    INNER JOIN user_roles ur ON u.user_id = ur.user_id
    INNER JOIN roles r ON ur.role_id = r.role_id
    WHERE r.role_id=2

SELECT COUNT(*) AS total_records FROM users u
    INNER JOIN user_roles ur ON u.user_id = ur.user_id
    INNER JOIN roles r ON ur.role_id = r.role_id
    WHERE r.role_id=1

SELECT COUNT(*) AS total_records FROM users u
    INNER JOIN user_roles ur ON u.user_id = ur.user_id
    INNER JOIN roles r ON ur.role_id = r.role_id
    WHERE r.role_id=3

SELECT COUNT(*) AS total FROM orders_online

SELECT COUNT(*) AS total FROM orders_offline

SELECT
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Pending') AS pending_orders,
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Confirmed') AS confirmed_orders,
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Deleted') AS deleted_orders,
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Completed') AS completed_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'In Transit') AS in_transit_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'Failed') AS failed_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'Delivered') AS delivered_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'Scheduled') AS scheduled_orders,
    (SELECT COUNT(*) FROM orders_offline) AS offline_orders

SELECT book_category_id, AVG(book_publication_year) AS avg_publication_year
FROM books
GROUP BY book_category_id
HAVING AVG(book_publication_year) > 2000;

SELECT book_publisher_id, COUNT(product_id) AS total_books
FROM books
GROUP BY book_publisher_id
HAVING COUNT(product_id) < 100;

SELECT others_product_brand_id, SUM(others_product_weight) AS total_weight
FROM others_products
GROUP BY others_product_brand_id
HAVING SUM(others_product_weight) > 500;

SELECT book_language_id, COUNT(product_id) AS total_books
FROM books
GROUP BY book_language_id
HAVING COUNT(product_id) > 50;
