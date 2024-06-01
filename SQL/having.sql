SELECT TOP 6 * 
FROM(
        SELECT od.others_product_name, p.product_image, p.product_price, p.product_id
        FROM others_products  od
            JOIN products p ON od.product_id = p.product_id 
        GROUP BY od.others_product_name, p.product_image, p.product_price, p.product_id
        HAVING p.product_price = '20000'
    ) AS cheap

SELECT category_id, AVG(product_price) AS avg_price
FROM products
GROUP BY category_id
HAVING AVG(product_price) > 100

SELECT supplier_id, COUNT(product_id) AS product_count
FROM products
GROUP BY supplier_id
HAVING COUNT(product_id) > 50;

SELECT category_id, SUM(product_quantity) AS total_quantity
FROM products
GROUP BY category_id
HAVING SUM(product_quantity) < 1000;

SELECT supplier_id, AVG(product_price) AS avg_price
FROM products
GROUP BY supplier_id
HAVING AVG(product_price) BETWEEN 50 AND 200;
