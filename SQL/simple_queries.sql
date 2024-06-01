SELECT * FROM users WHERE user_id = $user_id

SELECT ua.username, ua.password FROM users us
    INNER JOIN user_roles ur ON us.user_id = ur.user_id
    INNER JOIN user_accounts ua ON ua.user_role_id = ur.user_role_id
    WHERE us.user_id = . $_SESSION['user_id']

SELECT * FROM products WHERE product_id = $id

SELECT * FROM books WHERE product_id = $id

SELECT *
        FROM books bo
        INNER JOIN products pr ON bo.product_id = pr.product_id
        INNER JOIN book_author ba ON bo.product_id = ba.product_id
        INNER JOIN author au ON au.author_id = ba.author_id
        INNER JOIN book_categories bc ON bc.book_category_id = bo.book_category_id
        INNER JOIN book_languages bl ON bl.book_language_id = bo.book_language_id
        INNER JOIN book_publishers pb ON pb.book_publisher_id = bo.book_publisher_id
        WHERE bo.product_id = $id

SELECT ot.others_product_name, pr.product_image, pr.product_price, pr.product_quantity, pr.product_status,
       pc.category_name, su.supplier_name, su.supplier_origin, br.brand_name
        FROM products pr
        INNER JOIN others_products ot ON pr.product_id = ot.product_id
        INNER JOIN brands br ON ot.others_product_brand_id = br.brand_id
        INNER JOIN product_categories pc ON pr.category_id = pc.category_id
        INNER JOIN suppliers su ON pr.supplier_id = su.supplier_id
        WHERE pr.product_id = $id

SELECT * FROM LoginUser(?, ?)

SELECT p.product_id, p.product_image, p.product_price, c.quantity
        FROM carts c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = ? AND c.status = 1

SELECT image_user FROM users WHERE user_id = ?

SELECT * FROM user_accounts WHERE username='$username'

SELECT *
    FROM users u
    INNER JOIN user_roles ur ON u.user_id = ur.user_id
    INNER JOIN roles r ON ur.role_id = r.role_id
    INNER JOIN user_accounts ua on ua.user_role_id = ur.user_role_id
    where u.user_id=$user_id

SELECT ue.full_name as employee_name, o.order_id, o.order_date_off, o.note_off
    FROM orders_offline AS o
    JOIN employees AS e ON o.employee_id = e.employee_id
    JOIN users AS ue ON e.user_id = ue.user_id
    WHERE LOWER(CONCAT('DH00', CAST(order_id AS NVARCHAR(MAX)))) LIKE '%' + '$keyword' + '%'
    ORDER BY o.order_date_off DESC
    OFFSET $start_from ROWS FETCH NEXT $results_per_page ROWS ONLY

SELECT ue.full_name as employee_name, o.order_id, o.order_date_off, o.note_off
    FROM orders_offline o
    JOIN employees e ON o.employee_id = e.employee_id
    JOIN users AS ue ON e.user_id = ue.user_id
    ORDER BY o.order_date_off DESC
    OFFSET $start_from ROWS FETCH NEXT $results_per_page ROWS ONLY

SELECT ue.full_name as employee_name, o.order_id, o.order_date_off, o.note_off
    FROM orders_offline o
    JOIN employees e ON o.employee_id = e.employee_id
    JOIN users AS ue ON e.user_id = ue.user_id
    ORDER BY o.order_date_off DESC
    OFFSET $start_from ROWS FETCH NEXT $results_per_page ROWS ONLY

