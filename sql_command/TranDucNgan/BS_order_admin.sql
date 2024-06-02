-- Lệnh SQL lấy thông tin chi tiết đơn hàng trực tuyến
SELECT
    c.customer_id,
    o.order_id AS OrderID,
    od.product_id AS ProductID,
    CASE
        WHEN b.book_name IS NOT NULL THEN b.book_name
        WHEN op.others_product_name IS NOT NULL THEN op.others_product_name
        ELSE 'Unknown Product'
    END AS ProductName,
    od.quantity AS Quantity,
    CAST(od.discount AS INT) AS Discount,
    CAST(p.product_price AS INT) AS PricePerUnit,
    CAST(od.quantity * p.product_price - (od.discount/100)*(od.quantity * p.product_price) AS DECIMAL(10,0)) AS TotalPrice,
    o.order_date_on AS OrderDate,
    o.note_on AS Note,
    o.status_on AS Status,
    u.full_name,
    ue.full_name AS employee_delivery,
    COALESCE(s.delivery_status, 'Scheduled') AS delivery_status,
    s.employee_id
FROM orders_online o
LEFT JOIN order_details_on od ON o.order_id = od.order_id
LEFT JOIN products p ON od.product_id = p.product_id
LEFT JOIN books b ON p.product_id = b.product_id
LEFT JOIN others_products op ON p.product_id = op.product_id
LEFT JOIN shipper s ON o.order_id = s.order_id
JOIN customers c ON o.customer_id = c.customer_id
JOIN users u ON c.user_id = u.user_id
LEFT JOIN employees e ON s.employee_id = e.employee_id
LEFT JOIN users ue ON e.user_id = ue.user_id
WHERE o.order_id = @order_id;

-- Lệnh SQL lấy thông tin chi tiết đơn hàng ngoại tuyến
SELECT
    o.order_id AS OrderID,
    od.product_id AS ProductID,
    CASE
        WHEN b.book_name IS NOT NULL THEN b.book_name
        WHEN op.others_product_name IS NOT NULL THEN op.others_product_name
        ELSE 'Unknown Product'
    END AS ProductName,
    od.quantity AS Quantity,
    CAST(p.product_price AS INT) AS PricePerUnit,
    CAST(od.discount AS INT) AS Discount,
    CAST(od.quantity * p.product_price - (od.discount/100)*(od.quantity * p.product_price) AS DECIMAL(10,0)) AS TotalPrice,
    o.order_date_off AS OrderDate,
    o.employee_id,
    ue.full_name AS employee,
    o.note_off AS Note
FROM orders_offline o
LEFT JOIN order_details_off od ON o.order_id = od.order_id
LEFT JOIN products p ON od.product_id = p.product_id
LEFT JOIN books b ON p.product_id = b.product_id
LEFT JOIN others_products op ON p.product_id = op.product_id
JOIN employees AS e ON o.employee_id = e.employee_id
JOIN users AS ue ON e.user_id = ue.user_id
WHERE o.order_id = @order_id;

-- Lệnh SQL để lấy danh sách đơn hàng trực tuyến với phân trang và tìm kiếm
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
WHERE LOWER(CONCAT('DH00', CAST(oo.order_id AS NVARCHAR(MAX)))) LIKE '%' + :keyword + '%'
ORDER BY oo.order_date_on DESC
OFFSET :start_from ROWS FETCH NEXT :results_per_page ROWS ONLY;

-- Lệnh SQL để lấy danh sách đơn hàng ngoại tuyến với phân trang và tìm kiếm
SELECT ue.full_name as employee_name, o.order_id, o.order_date_off, o.note_off
FROM orders_offline AS o
JOIN employees AS e ON o.employee_id = e.employee_id
JOIN users AS ue ON e.user_id = ue.user_id
WHERE LOWER(CONCAT('DH00', CAST(order_id AS NVARCHAR(MAX)))) LIKE '%' + :keyword + '%'
ORDER BY o.order_date_off DESC
OFFSET :start_from ROWS FETCH NEXT :results_per_page ROWS ONLY;

-- Lệnh SQL để lấy tổng số lượng đơn hàng trực tuyến
SELECT COUNT(*) AS total FROM orders_online;

-- Lệnh SQL để lấy tổng số lượng đơn hàng ngoại tuyến
SELECT COUNT(*) AS total FROM orders_offline;

-- Lệnh SQL để lấy danh sách đơn hàng trực tuyến với phân trang và tìm kiếm
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
WHERE LOWER(CONCAT('DH00', CAST(oo.order_id AS NVARCHAR(MAX)))) LIKE '%' + :keyword + '%'
ORDER BY oo.order_date_on DESC
OFFSET :start_from ROWS FETCH NEXT :results_per_page ROWS ONLY;

-- Lệnh SQL để lấy danh sách đơn hàng ngoại tuyến với phân trang và tìm kiếm
SELECT ue.full_name as employee_name, o.order_id, o.order_date_off, o.note_off
FROM orders_offline AS o
JOIN employees AS e ON o.employee_id = e.employee_id
JOIN users AS ue ON e.user_id = ue.user_id
WHERE LOWER(CONCAT('DH00', CAST(order_id AS NVARCHAR(MAX)))) LIKE '%' + :keyword + '%'
ORDER BY o.order_date_off DESC
OFFSET :start_from ROWS FETCH NEXT :results_per_page ROWS ONLY;

