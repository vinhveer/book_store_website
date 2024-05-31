<?php
session_start();
include '../../connect.php';
if (isset($_GET['product_id']) && isset($_SESSION['user_id']) && isset($_GET['delete'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM carts WHERE product_id = ? AND user_id = ? AND status = 1";
    $params = array($product_id, $user_id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_close($conn);
    header('Location: ../../cart.php'); // Redirect to the cart page after deletion
    exit();
}


if (isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_SESSION['user_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE carts SET quantity = ? WHERE product_id = ? AND user_id = ?";
    $params = array($quantity, $product_id, $user_id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_close($conn);
    header('Location: ../../cart.php'); // Redirect to the cart page after updating
    exit();
} else {
    echo "Invalid request.";
}

?>
