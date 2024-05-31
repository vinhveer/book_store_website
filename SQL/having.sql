SELECT TOP 6 * 
FROM(
        SELECT od.others_product_name, p.product_image, p.product_price, p.product_id
        FROM others_products  od
            JOIN products p ON od.product_id = p.product_id 
        GROUP BY od.others_product_name, p.product_image, p.product_price, p.product_id
        HAVING p.product_price = '20000'
    ) AS cheap