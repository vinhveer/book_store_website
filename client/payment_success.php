<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 56px;
        }
    </style>
</head>

<body data-bs-theme="light">

    <?php
    // include 'connect.php';
    // include("components/navbar/navbar.php");

    //     if (isset($_POST['payment_ok'])) {
    //         if (isset($_SESSION['user_id']) && isset($_SESSION['selected_products'])) {
    //             // Retrieve user ID and selected products from session
    //             $user_id = 8;
    //             $selected_products = $_SESSION['selected_products'];

    //             // Ensure $selected_products is an array
    //             if (is_array($selected_products)) {
    //                 // Update selected products with quantity from carts and product_price from products
    //                 foreach ($selected_products as $product) {
    //                     $product_id = $product['product_id'];

    //                     // Get quantity from carts
    //                     $sql_quantity = "SELECT quantity FROM carts WHERE product_id = ? AND user_id = ?";
    //                     $params_quantity = array($product_id, $user_id);
    //                     $stmt_quantity = sqlsrv_query($conn, $sql_quantity, $params_quantity);

    //                     if ($stmt_quantity === false || !sqlsrv_has_rows($stmt_quantity)) {
    //                         throw new Exception('Error fetching quantity from carts');
    //                     }
    //                     sqlsrv_fetch($stmt_quantity);
    //                     $product['quantity'] = sqlsrv_get_field($stmt_quantity, 0);

    //                     // Get product_price from products
    //                     $sql_price = "SELECT product_price FROM products WHERE product_id = ?";
    //                     $params_price = array($product_id);
    //                     $stmt_price = sqlsrv_query($conn, $sql_price, $params_price);

    //                     if ($stmt_price === false || !sqlsrv_has_rows($stmt_price)) {
    //                         throw new Exception('Error fetching product price from products');
    //                     }
    //                     sqlsrv_fetch($stmt_price);
    //                     $product['price'] = sqlsrv_get_field($stmt_price, 0);
    //                 }
    //                 unset($product); // Unset reference to avoid accidental modification

    //                 // Store updated selected products in session
    //                 $_SESSION['selected_products'] = $selected_products;

    //                 // Begin a transaction
    //                 sqlsrv_begin_transaction($conn);

    //                 try {
    //                     // Insert into orders_online
    //                     $order_date = date('Y-m-d');
    //                     $total_amount = 0; // Initialize total amount, it will be calculated below
    //                     $status = 'Pending'; // Initial status of the order

    //                     // Calculate the total amount
    //                     foreach ($selected_products as $product) {
    //                         $product_total = $product['price'] * $product['quantity'];
    //                         $discounted_total = $product_total - $product['discount'];
    //                         $total_amount += $discounted_total;
    //                     }

    //                     // Insert order into orders_online
    //                     $sql_order = "INSERT INTO orders_online (customer_id, order_date_on, total_amount_on, status_on) OUTPUT INSERTED.order_id VALUES (?, ?, ?, ?)";
    //                     $params_order = array($user_id, $order_date, $total_amount, $status);
    //                     $stmt_order = sqlsrv_query($conn, $sql_order, $params_order);

    //                     if ($stmt_order === false) {
    //                         throw new Exception('Error inserting order');
    //                     }

    //                     // Get the generated order_id
    //                     sqlsrv_fetch($stmt_order);
    //                     $order_id = sqlsrv_get_field($stmt_order, 0);

    //                     // Insert each selected product into order_details_on
    //                     foreach ($selected_products as $product) {
    //                         $sql_order_details = "INSERT INTO order_details_on (order_id, product_id, quantity, discount) VALUES (?, ?, ?, ?)";
    //                         $params_order_details = array($order_id, $product['product_id'], $product['quantity'], $product['discount']);
    //                         $stmt_order_details = sqlsrv_query($conn, $sql_order_details, $params_order_details);

    //                         if ($stmt_order_details === false) {
    //                             throw new Exception('Error inserting order details');
    //                         }
    //                     }

    //                     // Insert payment into payments_on
    //                     $payment_date = date('Y-m-d');
    //                     $payment_method = 'Credit Card'; // This should be retrieved from form input in a real scenario
    //                     $amount = $total_amount;
    //                     $status_pay = 'Completed'; // Initial status of the payment

    //                     $sql_payment = "INSERT INTO payments_on (order_id, payment_date, payment_method, amount, status_pay) VALUES (?, ?, ?, ?, ?)";
    //                     $params_payment = array($order_id, $payment_date, $payment_method, $amount, $status_pay);
    //                     $stmt_payment = sqlsrv_query($conn, $sql_payment, $params_payment);

    //                     if ($stmt_payment === false) {
    //                         throw new Exception('Error inserting payment');
    //                     }

    //                     // Commit the transaction
    //                     sqlsrv_commit($conn);

    //                     // Payment and order processing successful
    //                     echo "Payment and order processed successfully.";
    //                 } catch (Exception $e) {
    //                     // Rollback the transaction in case of an error
    //                     sqlsrv_rollback($conn);
    //                     echo "Failed to process payment and order: " . $e->getMessage();
    //                 }
    //             } else {
    //                 echo "Selected products data is not valid.";
    //             }
    //         } else {
    //             echo "User ID or selected products not set in session.";
    //         }
    //     }
    ?>

    <div class="container-fluid ps-4 pe-4 mt-4">
        <h6 class="display-5">Thanh toán thành công</h6>
        <p>Cảm ơn bạn đã mua hàng tại cửa hàng chúng tôi. Chúng tôi sẽ giao hàng cho bạn trong thời gian sớm nhất.</p>
        <a class="btn btn-primary" href="index.php">Quay về trang chủ</a>
    </div>

    <?php
    include("components/footer/footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>
