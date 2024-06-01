<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 56px;
        }
    </style>
</head>

<body data-bs-theme="light">

    <?php
    $path = "";

    include 'connect.php';
    include("components/navbar/navbar.php");
    include("login.php");
    ?>


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
    ?>
    <form action="placeorder.php" method="post">
        <div class="container-fluid ps-4 pe-4">
            <div class="row">
                <div class="col-md-8">
                    <h3>Giỏ hàng của tôi</h3>
                    <p>Chọn các sản phẩm dưới đây để tiếp tục mua hàng</p>
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                    <div class="d-flex justify-content-end">
                        <button type="submit" name="sbm_order" class="btn btn-primary">Mua hàng với các sản phẩm đã chọn</button>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
                        <label for="selectAll">Select All</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid ms-4 me-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <?php foreach ($cart_items as $item) { 
                            $product_id = $item['product_id'];
                            $sql_item = "SELECT * FROM GetProductDetails($product_id)";

                            $result = sqlsrv_query($conn, $sql_item);
                            $row_item = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                            ?>
                            <div class="card mb-4" data-id="<?php echo $item['product_id']; ?>" onclick="toggleCheckbox(<?php echo $item['product_id']; ?>)">
                                <div class="row no-gutters">
                                    <div class="col-md-2">
                                        <img src="<?php echo $item['product_image']; ?>" class="card-img" alt="Product Image">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body row">
                                            <div class="col-md-1">
                                                <input type="checkbox" name="selected_products[]" value="<?php echo $item['product_id']; ?>" id="checkbox-<?php echo $item['product_id']; ?>">
                                            </div>
                                            <div class="col-md-9">
                                                <h5 class="card-title"><?php echo $row_item["Product Name"]; ?></h5>
                                                <p class="card-text"><?php echo $item['quantity']; ?></p>
                                                <p class="card-text"><?php echo number_format($item['product_price'], 2); ?></p>
                                                <a href="#" class="btn btn-primary">Go somewhere</a>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-success"><i class='bx bx-edit'></i></button>
                                                <button class="btn btn-warning"><i class='bx bx-trash'></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- You can add other content here -->
                </div>
            </div>
        </div>
    </form>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item from your cart?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Quantity Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Quantity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="components/cart/process.php" method="post">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <input type="hidden" id="editProductId" name="product_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmEditBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleCheckbox(productId) {
            const checkbox = document.getElementById('checkbox-' + productId);
            checkbox.checked = !checkbox.checked;
        }

        // Toggle all checkboxes
        function toggleSelectAll(selectAllCheckbox) {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }

        // Prevent event from bubbling to card when clicking on checkbox
        document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });

        let productIdToDelete;
        let productIdToEdit;

        document.querySelectorAll('.btn-warning').forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
                productIdToDelete = this.closest('.card').dataset.id;
                new bootstrap.Modal(document.getElementById('deleteModal')).show();
            });
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            window.location.href = `components/cart/process.php?product_id=${productIdToDelete}&delete=1`;
        });

        document.querySelectorAll('.btn-success').forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
                productIdToEdit = this.closest('.card').dataset.id;
                const quantity = this.closest('.card').querySelector('.card-text').innerText.split(': ')[1];
                document.getElementById('quantity').value = quantity;
                document.getElementById('editProductId').value = productIdToEdit;
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });

        document.getElementById('confirmEditBtn').addEventListener('click', function() {
            document.getElementById('editForm').submit();
        });
    </script>


    <?php
    include("components/footer/footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
