<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của tôi </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 60px;
        }
    </style>
</head>

<body data-bs-theme="light">

    <?php
    $path = "";

    include 'connect.php';
    include("components/navbar/navbar.php");
    include("login.php");


    // Assuming customer ID is known or fetched from session
    $customer_id = 8; // This should be dynamically set

    // Fetch orders for the customer
    $sql = "SELECT * FROM orders_online WHERE customer_id = ?";
    $params = array($customer_id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error in query preparation/execution.";
        die(print_r(sqlsrv_errors(), true));
    }
    ?>

    <div class="container-fluid ps-4 pe-4">
        <h4>Đơn hàng của tôi</h4>
        <p>Chọn vào mã đơn hàng để xem chi tiết</p>      
    </div>

    <div class="container-fluid ps-4 pe-4 mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng số tiền</th>
                    <th>Trạng thái giao hàng</th>
                    <th>Ngày đặt hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_amount_on']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status_on']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['order_date_on']->format('Y-m-d')) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>
