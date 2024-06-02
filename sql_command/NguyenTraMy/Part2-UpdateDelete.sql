-- client > components > add_to_card
// Construct SQL query
IF EXISTS (SELECT 1 FROM carts WHERE user_id = ? AND product_id = ?)
            BEGIN
                UPDATE carts SET quantity = quantity + ?, created_at = ?, status = ? WHERE user_id = ? AND product_id = ?
            END
            ELSE
            BEGIN
                INSERT INTO carts (user_id, product_id, quantity, created_at, status) VALUES (?, ?, ?, ?, ?)
            END;
-- client > components > process --
    // Tạo câu lệnh UPDATE dựa trên giá trị mới
UPDATE user_accounts
                SET 
                    username = ISNULL(?, username),
                    password = ISNULL(?, password)
                WHERE user_role_id IN (
                    SELECT user_role_id
                    FROM user_roles
                    WHERE user_id = ?
                );
    // Câu lệnh SQL UPDATE
UPDATE users 
            SET 
                .(!empty($full_name) ? "last_name = '$full_name'," : "").
                .(!empty($email) ? "email = '$email'," : "").
                .(!empty($phone) ? "phone = '$phone'," : "").
                .(!empty($dob) ? "date_of_birth = '$dob'," : "").
                .(!empty($gender) ? "gender = '$gender'," : "")."
                .(!empty($address) ? "address = '$address'," : "").
                .(isset($avatar_image) ? "image_user = '$avatar_image'," : "").
            WHERE user_id = ".$_SESSION['user_id'];

-- client > add_to_card --
IF EXISTS (SELECT 1 FROM carts WHERE user_id = ? AND product_id = ?)
            BEGIN
                UPDATE carts SET quantity = quantity + ?, created_at = ?, status = ? WHERE user_id = ? AND product_id = ?
            END
            ELSE
            BEGIN
                INSERT INTO carts (user_id, product_id, quantity, created_at, status) VALUES (?, ?, ?, ?, ?)
            END;

-- admin > components > accounts > process --
UPDATE users
    SET full_name = N'$full_name',
        date_of_birth = '$birth',
        gender = $gender,
        address = '$address',
        phone = '$phone',
        email = '$email',
        image_user = '$image'
    WHERE user_id = $user_id;
    $query_update_user = sqlsrv_query($conn, $sql_edit_user);
    if ($query_update_user === false) {
        die( print_r( sqlsrv_errors(), true));
    } else {
        $page = $_GET['page'];
        $edit = $_GET['edit'];
        $username = $_POST['username'];
        $password = $_POST['password'];
UPDATE user_accounts
        SET username = '$username',
            password = '$password'
        WHERE user_role_id IN (SELECT user_role_id FROM user_roles WHERE user_id = $user_id);
        $result_update_account = sqlsrv_query($conn, $sql_upadte_account);
        if ($result_update_account === false) {
            die( print_r( sqlsrv_errors(), true));
        }else{
            if ($edit == 1) header(location: ../../account_customer.php?page_layout=customer&page=$page);/-strong/-heart:>:o:-((:-helse if($edit == 2) header(location: ../../account_admin.php?page_layout=admin&page=$page);
            else if($edit == 3 )  header(location: ../../account_employee.php?page_layout=employee&page=$page);
            else  echo "Lỗi role không tồn tại": . sqlsrv_errors($dbconnect);
        }
    }

DELETE FROM users where user_id = $user_id;

DELETE FROM order_details_on where product_id = $product_id;

DELETE FROM products where product_id = $product_id

-- Lệnh SQL để xóa đơn hàng trực tuyến
DELETE FROM orders_online WHERE order_id = :order_id;

-- Lệnh SQL để xóa đơn hàng ngoại tuyến
DELETE FROM orders_offline WHERE order_id = :order_id;

-- Lệnh SQL để xóa sản phẩm khỏi chi tiết đơn hàng trực tuyến
DELETE FROM order_details_on WHERE product_id = :product_id;

-- Lệnh SQL để xóa sản phẩm khỏi chi tiết đơn hàng ngoại tuyến
DELETE FROM order_details_off WHERE product_id = :product_id;

-- Lệnh SQL để cập nhật thông tin sản phẩm và chi tiết đơn hàng trực tuyến
UPDATE products SET product_price = :price_unit WHERE product_id = :product_id;
UPDATE order_details_on SET quantity = :quantity, discount = :discount WHERE product_id = :product_id;

-- Lệnh SQL để cập nhật thông tin sản phẩm và chi tiết đơn hàng ngoại tuyến
UPDATE products SET product_price = :price_unit WHERE product_id = :product_id;
UPDATE order_details_off SET quantity = :quantity, discount = :discount WHERE product_id = :product_id;

-- Lệnh SQL để cập nhật thông tin đơn hàng trực tuyến
UPDATE orders_online SET
    order_date_on = :date_order,
    customer_id = :customer,
    status_on = :status,
    note_on = :note,
    total_amount_on = :total
WHERE order_id = :order_id;

-- Lệnh SQL để thêm hoặc cập nhật thông tin người giao hàng cho đơn hàng trực tuyến
INSERT INTO shipper (order_id, employee_id, delivery_status)
VALUES (:order_id, :employee_id, :delivery_status);
-- Hoặc nếu đã tồn tại
UPDATE shipper SET
    employee_id = :employee_id,
    delivery_status = :delivery_status
WHERE order_id = :order_id;

-- Lệnh SQL để cập nhật thông tin đơn hàng ngoại tuyến
UPDATE orders_offline SET
    order_date_off = :date_order,
    note_off = :note,
    total_amount_off = :total
WHERE order_id = :order_id;
