<?php
    include_once 'config/connect.php';
    $order_id = $_GET['order_id'];
    $select = $_GET['select'];
    if($select == 1){
        $sql_order_detail = "SELECT
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
    WHERE o.order_id = $order_id;
    ";
        $result_order_detail = sqlsrv_query($conn,$sql_order_detail);
        $row_order_detail = sqlsrv_fetch_array($result_order_detail);
    }else{
        $sql_order_detail = "SELECT
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
    WHERE o.order_id = $order_id;
    ";
        $result_order_detail = sqlsrv_query($conn,$sql_order_detail);
        $row_order_detail = sqlsrv_fetch_array($result_order_detail);
    }
?>
<div class="container">
    <div class="mb-2">
    <h4><a style="color:black;" href="order_list.php?select=<?php echo $select;?>"><i class='bx bxs-chevrons-left me-3' ></i></a>Thông tin hóa đơn</h4>
    </div>
  <div class="row mt-4">
    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          Thông tin đơn hàng
        </div>
            <div class="card-body" style="height: 500px; overflow-y: auto;">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 120px">Order ID:</strong>
                                    <p style="margin-bottom: 0px">DH00<?php echo $row_order_detail['OrderID']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 95px">Order Date:</strong>
                                    <?php
                                    $order_date_detail = $row_order_detail['OrderDate'];
                                    $formatted_date_detail = $order_date_detail->format('Y-m-d');
                                    ?>
                                    <p style="margin-bottom: 0px"><?php echo $formatted_date_detail; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 150px">Note:</strong>
                                        <p style="margin-bottom: 0px"><?php echo $row_order_detail['Note'] ?></p>
                                </div>
                            </li>
                            <?php if($select == 1) { ?>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Customer Name:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_order_detail['full_name'] ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 30px">Delivery Employee:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_order_detail['employee_delivery'] ?></p>
                                </div>
                            </li>
                             <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 60px">Delivery Status:</strong>
                                        <p style="margin-bottom: 0px"><?php echo $row_order_detail['delivery_status'] ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 130px"> Status:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_order_detail['Status'] ?></p>
                                </div>
                            </li>
                            <?php }else{ ?>
                                <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Employee Name:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_order_detail['employee'] ?></p>
                                </div>
                                </li>
                                <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 130px"> Status:</strong>
                                    <p style="margin-bottom: 0px">Completed</p>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editOrderModal">
                        <i class='bx bx-sm bx-edit-alt me-1'></i>Edit Information
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
    <div class="card">
        <div class="card-header">
            Danh sách sản phẩm
        </div>
        <div class="card-body" style="height: 500px; overflow-y: auto;">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Unit price</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Into money</th>
                        <th scope="col">Operation <button style="border: none;" id="addProductBtn"><i class='bx bx-plus'></i></button></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        sqlsrv_free_stmt($result_order_detail);
                        $result_order_detail = sqlsrv_query($conn,$sql_order_detail);
                        if ($result_order_detail) {
                            while ($row = sqlsrv_fetch_array($result_order_detail)) {
                    ?>
                                <tr>
                                    <td>PS<?php echo $row['ProductID'] ?></td>
                                    <td><?php echo $row['ProductName'] ?></td>
                                    <td><?php echo $row['Quantity'] ?></td>
                                    <td><?php echo $row['PricePerUnit'] ?></td>
                                    <td><?php echo $row['Discount'] ?>%</td>
                                    <td><?php echo $row['TotalPrice'] ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-sm btn-warning me-2 edit-product-btn" data-productid="<?php echo $row['ProductID'] ?>" data-quantity="<?php echo $row['Quantity'] ?>" data-price="<?php echo $row['PricePerUnit'] ?>" data-discount="<?php echo $row['Discount'] ?>"><i class='bx bx-edit bx-sm'></i></button>
                                            <button type="button" class="btn btn-sm btn-danger me-2 delete-product-btn" data-productid="<?php echo $row['ProductID'] ?>"><i class='bx bx-sm bx-trash me-1'></i></button>
                                            <a href="product_detail.php?product_id=<?php echo $row['ProductID']; ?>&order_id=<?php echo $order_id; ?>&select=<?php echo $select; ?>" class="btn btn-sm btn-info"><i class='bx bxs-show bx-sm'></i></a>
                                        </div>
                                    </td>
                                </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="px-5 mt-2 bg-body-tertiary">
        <div class="row">
            <div class="col-md-5 me-4">
                <strong>Total price:</strong>
            </div>
            <div class="col-md-5 text-end ms-3">
                <?php
                    $totalPrice = 0;
                    sqlsrv_free_stmt($result_order_detail);
                    $result_order_detail = sqlsrv_query($conn, $sql_order_detail);
                    while ($row = sqlsrv_fetch_array($result_order_detail)) {
                        $totalPrice += $row['TotalPrice'];
                    }
                    echo $totalPrice.' VND';
                ?>
            </div>
        </div>
    </div>
</div>

</div>
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel">Edit order information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editOrderForm" action="components/Order/process.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                    <input type="hidden" name="select" value="<?php echo $select;?>">
                    <input type="hidden" name="total" value="<?php echo $totalPrice; ?>">
                    <!-- Ngày đặt hàng -->
                    <div class="mb-3">
                        <label for="order_date" class="form-label">Order date:</label>
                        <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo $formatted_date_detail ?>">
                    </div>
                    <!-- Ghi chú -->
                    <div class="mb-3">
                        <label for="note" class="form-label">Note:</label>
                        <textarea class="form-control" id="note" name="note" rows="3"><?php echo $row_order_detail['Note'] ?></textarea>
                    </div>
                    <?php if($select == 1) { ?>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">Customer Name :</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $row_order_detail['full_name'] ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="customer" class="form-label">Customer ID :</label>
                                <input type="number" class="form-control" id="customer" name="customer" value="<?php echo $row_order_detail['customer_id'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Status" class="form-label">Order Status :</label>
                                <select class="form-select" id="Status" name="Status" required onchange="toggleDeliveryFields()">
                                    <option value="" disabled selected>Choose Status</option>
                                    <option value="Confirmed" <?php echo ($row_order_detail['Status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="Pending" <?php echo ($row_order_detail['Status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Completed" <?php echo ($row_order_detail['Status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                    <option value="Deleted" <?php echo ($row_order_detail['Status'] == 'Deleted') ? 'selected' : ''; ?>>Deleted</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="deliveryStatusContainer" style="display: none;">
                                <label for="delivery_status" class="form-label">Delivery Status:</label>
                                <select class="form-select" id="delivery_status" name="delivery_status" required>
                                    <option value="" disabled selected>Choose Status</option>
                                    <option value="Delivered" <?php echo ($row_order_detail['delivery_status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                    <option value="Scheduled" <?php echo ($row_order_detail['delivery_status'] == 'Scheduled') ? 'selected' : ''; ?>>Scheduled</option>
                                    <option value="Failed" <?php echo ($row_order_detail['delivery_status'] == 'Failed') ? 'selected' : ''; ?>>Failed</option>
                                    <option value="In Transit" <?php echo ($row_order_detail['delivery_status'] == 'In Transit') ? 'selected' : ''; ?>>In Transit</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3" id="employeeContainer" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="employee_name" class="form-label">Employee Delivery :</label>
                                <input type="text" class="form-control" id="employee_name" name="employee_name" value="<?php echo $row_order_detail['employee_delivery'] ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="employee" class="form-label">Employee ID :</label>
                                <input type="number" class="form-control" id="employee" name="employee" value="<?php echo $row_order_detail['employee_id'];?>">
                            </div>
                        </div>
                    </div>
                    <?php }else{ ?>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="employee_name" class="form-label">Employee Name :</label>
                                <input type="text" class="form-control" id="employee_name" name="employee_name" value="<?php echo $row_order_detail['employee'] ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="employee" class="form-label">Employee ID :</label>
                                <input type="number" class="form-control" id="employee" name="employee" value="<?php echo $row_order_detail['employee_id'];?>">
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btn_edit_order">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Product Form -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit product infomation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProductForm" action="components/Order/process.php?" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="edit_product_id">
                    <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                    <input type="hidden" name="select" value="<?php echo $select;?>">
                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="edit_quantity" class="form-label">Quantity:</label>
                        <input type="text" class="form-control" id="edit_quantity" name="edit_quantity">
                    </div>
                    <!-- Price Per Unit -->
                    <div class="mb-3">
                        <label for="edit_price_per_unit" class="form-label">Price:</label>
                        <input type="text" class="form-control" id="edit_price_per_unit" name="edit_price_unit">
                    </div>
                    <!-- Discount -->
                    <div class="mb-3">
                        <label for="edit_discount" class="form-label">Discount (%):</label>
                        <input type="text" class="form-control" id="edit_discount" name="edit_discount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btn_edit_product">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Confirm product deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteProductForm" action="components/Order/process.php" method="POST">
                <div class="modal-body">
                    <p>Are you sure you want to remove this product from your order?</p>
                    <input type="hidden" name="product_id" id="delete_product_id">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <input type="hidden" name="select" value="<?php echo $select;?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="btn_delete_product">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProductForm" action="components/Order/process.php?order_id=<?php echo $order_id; ?>&select=<?php echo $select;?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                    <input type="hidden" name="select" value="<?php echo $select;?>">
                    <!-- Product ID -->
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product ID:</label>
                        <input type="text" class="form-control" id="product_id" name="product_id">
                    </div>
                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="text" class="form-control" id="quantity" name="quantity">
                    </div>
                    <!-- Discount -->
                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount (%):</label>
                        <input type="text" class="form-control" id="discount" name="discount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btn_add_product">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script>
        const editButton = document.querySelector('#editButton');
        const editOrderModal = document.querySelector('#editOrderModal');
        editButton.addEventListener('click', function() {
            editOrderModal.style.display = 'block';
        });
        const closeModalButton = document.querySelector('.btn-close');
        closeModalButton.addEventListener('click', function() {
            editOrderModal.style.display = 'none';
        });

</script>
<script>
    // Handle click on edit button
    $(document).on("click", ".edit-product-btn", function () {
        var product_id = $(this).data('productid');
        var quantity = $(this).data('quantity');
        var price = $(this).data('price');
        var discount = $(this).data('discount');

        // Set values in the edit form
        $('#edit_product_id').val(product_id);
        $('#edit_quantity').val(quantity);
        $('#edit_price_per_unit').val(price);
        $('#edit_discount').val(discount);

        // Show the edit modal
        $('#editProductModal').modal('show');
    });

        // Handle click on delete button
    $(document).on("click", ".delete-product-btn", function () {
        var product_id = $(this).data('productid');

        // Set product ID in the delete form
        $('#delete_product_id').val(product_id);

        // Show the delete modal
        $('#deleteProductModal').modal('show');
    });
    // Show add product form
    $(document).on("click", "#addProductBtn", function () {
        $('#addProductModal').modal('show');
    });
    function toggleDeliveryFields() {
        const status = document.getElementById('Status').value;
        const deliveryStatusContainer = document.getElementById('deliveryStatusContainer');
        const employeeContainer = document.getElementById('employeeContainer');

        if (status === 'Confirmed') {
            deliveryStatusContainer.style.display = 'block';
            employeeContainer.style.display = 'block';
        } else {
            deliveryStatusContainer.style.display = 'none';
            employeeContainer.style.display = 'none';
        }
    }

    // Initialize the fields visibility based on the current value
    document.addEventListener('DOMContentLoaded', function() {
        toggleDeliveryFields();
    });
</script>
