<?php
    include_once 'config/connect.php';
    $product_id = $_GET['product_id'];

    $sql = "
        SELECT
            p.product_price, p.product_image, p.product_quantity, p.product_status,
            op.others_product_name, op.others_product_description, op.others_product_color,
            op.others_product_material, op.others_product_weight, op.others_product_size, pc.category_name,
            p.product_quantity, s.supplier_name, b.brand_name
        FROM others_products op
        JOIN products p ON op.product_id = p.product_id
        JOIN suppliers s ON s.supplier_id = p.supplier_id
        JOIN product_categories pc ON pc.category_id = p.category_id
        JOIN brands b ON op.others_product_brand_id = b.brand_id
        WHERE op.product_id = ?";
    $params = array($product_id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row_product_detail = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if($row_product_detail === null) {
        echo "Product not found.";
        exit();
    }
?>
        <div class="container-fluid">
        <div class="header">
            <h3><a style="color:black;" href="other_product.php?page=<?php echo $_GET['page']; ?>"><i class='bx bxs-chevrons-left me-3' ></i></a>Product Information</h3>
            <div class="d-flex justify-content-end">
                <a href="other_product_edit.php?product_id=<?php echo $product_id; ?>&page=<?php echo $_GET['page']; ?>" type="button" class="btn btn-warning">
                    <i class='bx bx-sm bx-edit-alt me-1'></i>Edit Information
                </a>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center d-flex justify-content-center align-items-center">
                        <img src="<?php echo $row_product_detail['product_image']; ?>" alt="Profile Image" class="img-fluid"
                                style="width: 200px; height: 300px;">
                    </div>
                    <div class="col-md-8">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 75px">Product Code:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $product_id; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 95px">Product Name:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['others_product_name']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Supplier:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['supplier_name']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Category name:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['category_name']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Brand:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['brand_name']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Product Color:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['others_product_color']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Material:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['others_product_material']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Weight:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['others_product_weight']; ?>g</p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Size:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['others_product_size']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Quantity:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['product_quantity']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Product Description:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['others_product_description']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Status:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['product_status']; ?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Product Price:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['product_price']; ?> VND</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
