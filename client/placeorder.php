<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 80px;
        }
    </style>
</head>

<body data-bs-theme="light">

    <?php
    $path = "";
    include 'connect.php';


    include ("components/navbar/navbar.php");
    ?>
    <div class="container-fluid ps-4 pe-4">
        <div class="row">
            <div class="col-md-8">
                <h3>Thông tin đơn hàng</h3>
                <p>Kiểm tra thông tin trước khi thanh toán</p>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-end">
                    <a href="payment.php" class="btn btn-primary">Thanh toán</a>
                </div>
            </div>
        </div>
    </div>

    <?php
    $total_price = 0;

    // Check if selected_products is set and is an array
    if (isset($_POST['selected_products']) && is_array($_POST['selected_products'])) {
        $selected_products = $_POST['selected_products'];
        $user_id = $_POST['user_id'];

        // Start table
        echo "<div class='container-fluid mt-4 ps-4 pe-4'>
                <div class='row'>
                    <div class='col-md-8'>
                        <h5>Danh sách sản phẩm</h5>
                        <table class='table'>
                            <thead>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                            </thead>
                            <tbody>";

        // Counter for displaying product number
        $counter = 1;

        // Loop through each selected product
        foreach ($selected_products as $product) {
            // Query to fetch product details
            $sql_order = "SELECT
            CAST(p.product_price AS INT) AS PricePerUnit,
            p.product_image,
            p.product_status,
            c.quantity,
            COALESCE(b.product_id, op.product_id) AS product_id,
            COALESCE(b.book_name, op.others_product_name) AS product_name
            FROM products p
            LEFT JOIN books b ON p.product_id = b.product_id
            LEFT JOIN others_products op ON p.product_id = op.product_id
            JOIN carts c ON p.product_id = c.product_id
            JOIN users u ON u.user_id = c.user_id
            WHERE
                p.product_id =  $product AND c.user_id=$user_id";

            $query = sqlsrv_query($conn, $sql_order);

            // Fetch product details
            $row = sqlsrv_fetch_array($query);

            // Display product details in table row
            echo "<tr>";
            echo "<td>" . $counter++ . "</td>";
            echo "<td>" . $row['product_name'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['PricePerUnit'] ." VND". "</td>";
            echo "</tr>";

            // Calculate total price
            $total_price += $row['PricePerUnit'] * $row['quantity'];
        }

        // End table and display total price
        echo "</tbody></table></div><div class='col-md-4 ps-4'><h5>Thành tiền</h5><p>" . number_format($total_price, 0, ',', '.') . " VND</p></div></div></div>";
    } else {
        // If no products are selected
        echo "<p class='text-center'>Không có sản phẩm nào được chọn.</p>";
    }
    ?>

    <?php
    include ("components/footer/footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>
