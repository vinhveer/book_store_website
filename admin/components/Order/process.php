<?php
include '../../config/connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_delete"])) {
     $order_id = $_POST['order_id'];
     $select = $_POST['select'];
     if($select == 1){
          $sql_delete_order = "DELETE FROM orders_online where order_id = $order_id";
          $query_order = sqlsrv_query($conn, $sql_delete_order);
     }
     if($select == 0){
          $sql_delete_order = "DELETE FROM orders_offline where order_id = $order_id";
          $query_order = sqlsrv_query($conn, $sql_delete_order);
     }
     header ("location: ../../order_list.php?select=$select");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_delete_product"])) {
    $order_id = $_POST['order_id'];
    $select = $_POST['select'];
    $product_id = $_POST['product_id'];
    if($select == 1){
         $sql_delete_product = "DELETE FROM order_details_on where product_id = $product_id";
         $query_order = sqlsrv_query($conn, $sql_delete_product);
    }
    if($select == 0){
         $sql_delete_product = "DELETE FROM order_details_off where product_id = $product_id";
         $query_order = sqlsrv_query($conn, $sql_delete_product);
    }
    header ("location: ../../order_detail.php?order_id=$order_id&select=$select");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_edit_product"])) {
    $order_id = $_POST['order_id'];
    $select = $_POST['select'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['edit_quantity'];
    $price_unit = $_POST['edit_price_unit'];
    $discount = $_POST['edit_discount'];
    if($select == 0){
    $sql_update_pro = "UPDATE products SET product_price='$price_unit' where product_id = $product_id;
         UPDATE order_details_off SET quantity='$quantity',discount='$discount' where product_id = $product_id;";
    }
    if($select == 1){
         $sql_update_pro = "UPDATE products SET product_price='$price_unit' where product_id = $product_id;
         UPDATE order_details_on SET quantity='$quantity',discount='$discount' where product_id = $product_id;";
    }
    $query_product = sqlsrv_query($conn, $sql_update_pro);
    header ("location: ../../order_detail.php?order_id=$order_id&select=$select");
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_add_product"])) {
    $order_id = $_GET['order_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $discount = $_POST['discount'];
    $select = $_POST['select'];
    if($select == 1){
         $sql_add_product = "INSERT INTO order_details_on (order_id, product_id, quantity, discount)
                             VALUES ($order_id,$product_id,$quantity,$discount)";
    }
    if($select == 0){
         $sql_add_product = "INSERT INTO order_details_off (order_id, product_id, quantity, discount)
                             VALUES ($order_id,$product_id,$quantity,$discount)";
    }
    $query_add_pro = sqlsrv_query($conn, $sql_add_product);
    header ("location: ../../order_detail.php?order_id=$order_id&select=$select");
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_edit_order"])) {
     $order_id = $_POST['order_id'];
     $select = $_POST['select'];
     $date_order = $_POST['order_date'];
     $note = $_POST['note'];
     $total = $_POST['total'];

     if ($select == 1) {
         $customer = $_POST['customer'];
         $status = $_POST['Status'];
         $delivery_status = $_POST['delivery_status'];
         if ($delivery_status == "Failed") {
             $status = "Deleted";
         } else if ($delivery_status == "Delivered") {
             $status = "Completed";
         } else if ($delivery_status == "In Transit") {
             $status = "Confirmed";
         } else if ($delivery_status == "Scheduled") {
             $status = "Pending";
         }
         $employee_id = $_POST['employee'];

         $sql_update_order = "UPDATE orders_online SET
             order_date_on = '$date_order',
             customer_id = '$customer',
             status_on = '$status',
             note_on = N'$note',
             total_amount_on = '$total'
             WHERE order_id = $order_id;";
         $query_update_order = sqlsrv_query($conn, $sql_update_order);

         $sql_check_shipper = "SELECT * FROM shipper WHERE order_id = $order_id";
         $query_check_shipper = sqlsrv_query($conn, $sql_check_shipper);
         $row_select = sqlsrv_fetch_array($query_check_shipper);

         if (!$row_select) {
             $sql_add_shipper = "INSERT INTO shipper (order_id, employee_id, delivery_status)
                 VALUES ($order_id, $employee_id, '$delivery_status');";
             $query_add_shipper = sqlsrv_query($conn, $sql_add_shipper);
         } else {
             $sql_update_shipper = "UPDATE shipper SET
                 employee_id = '$employee_id',
                 delivery_status = '$delivery_status'
                 WHERE order_id = $order_id;";
             $query_update_shipper = sqlsrv_query($conn, $sql_update_shipper);
         }

         header("Location: ../../order_detail.php?order_id=$order_id&select=$select");
     }

     if ($select == 0) {
         $employee_id = $_POST['employee'];
         $sql_update_order = "UPDATE orders_offline SET
             order_date_off = '$date_order',
             note_off = N'$note',
             total_amount_off = '$total'
             WHERE order_id = $order_id;";
         $query_update_order = sqlsrv_query($conn, $sql_update_order);
         header("Location: ../../order_detail.php?order_id=$order_id&select=$select");
     }
 }

?>
