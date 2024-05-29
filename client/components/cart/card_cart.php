<?php
$user_id = $_SESSION['user_id'];
$sql = "SELECT p.product_id, p.product_image, p.product_price, c.quantity
        FROM carts c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = ? AND c.status = 1";

$params = array($user_id);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$cart_items = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $cart_items[] = $row;
}
sqlsrv_close($conn);
?>

<div class="container-fluid ms-4 me-4">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <?php foreach ($cart_items as $item): ?>
                    <div class="card mb-4">
                        <div class="row no-gutters">
                            <div class="col-md-2">
                                <img src="<?php echo $item['product_image']; ?>" class="card-img" alt="Product Image">
                            </div>
                            <div class="col-md-10">
                                <div class="card-body">
                                    <h5 class="card-title">Product ID: <?php echo $item['product_id']; ?></h5>
                                    <p class="card-text">Quantity: <?php echo $item['quantity']; ?></p>
                                    <p class="card-text">Price: $<?php echo number_format($item['product_price'], 2); ?></p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-4">
            <!-- You can add other content here -->
        </div>
    </div>
</div>