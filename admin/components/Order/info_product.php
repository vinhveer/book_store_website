<?php
    include_once 'config/connect.php';
    $order_id = $_GET['order_id'];
    $select = $_GET['select'];
    $product_id = $_GET['product_id'];
    $sql_product_detail = "SELECT
    CASE
        WHEN b.product_id IS NOT NULL THEN 'Book'
        ELSE 'Stationery'
    END AS product_type,
    CAST(p.product_price AS INT) AS PricePerUnit,
    p.product_image,
    p.product_status,
    COALESCE(b.product_id, op.product_id) AS product_id,
    COALESCE(b.book_name, op.others_product_name) AS product_name,
    COALESCE(b.book_description, op.others_product_description) AS product_description,
    COALESCE(bc.book_category_name, NULL) AS category_name,
    COALESCE(bl.book_language, NULL) AS language,
    COALESCE(b.book_publication_year, NULL) AS publication_year,
    COALESCE(b.book_packaging_size, op.others_product_size) AS packaging_size,
    COALESCE(b.book_format, NULL) AS book_format,
    COALESCE(b.book_ISBN, NULL) AS ISBN,
    COALESCE(bp.book_publisher_name, NULL) AS publisher_name,
    COALESCE(op.others_product_brand_id, NULL) AS brand_id,
    COALESCE(br.brand_name, NULL) AS brand_name,
    COALESCE(op.others_product_color, NULL) AS color,
    COALESCE(op.others_product_material, NULL) AS material,
    COALESCE(op.others_product_weight, NULL) AS weight
    FROM
        products p
    LEFT JOIN books b ON p.product_id = b.product_id
    LEFT JOIN others_products op ON p.product_id = op.product_id
    LEFT JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    LEFT JOIN book_languages bl ON b.book_language_id = bl.book_language_id
    LEFT JOIN book_publishers bp ON b.book_publisher_id = bp.book_publisher_id
    LEFT JOIN brands br ON op.others_product_brand_id = br.brand_id
    WHERE
        p.product_id = $product_id";
    $result_product_detail = sqlsrv_query($conn,$sql_product_detail);
    $row_product_detail = sqlsrv_fetch_array($result_product_detail);
?>
        <div class="container-fluid">
            <div class="header">
                <h3><a style="color:black;" href="order_detail.php?order_id=<?php echo $order_id;?>&select=<?php echo $select;?>"><i class='bx bxs-chevrons-left me-3' ></i></a>Product Information</h3>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center d-flex justify-content-center align-items-center">
                        <img src="<?php echo $row_product_detail['product_image'];?>" alt="Profile Image" class="img-fluid"
                                style="width: 200px; height: 300px;">
                    </div>
                    <div class="col-md-8">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list-group-item-light">
                            <div class="d-flex align-items-center">
                                <strong style="margin-right: 75px">Product Type</strong>
                                <p style="margin-bottom: 0px"><?php echo $row_product_detail['product_type'];?></p>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action list-group-item-light">
                            <div class="d-flex align-items-center">
                                <strong style="margin-right: 75px">Product Code</strong>
                                <p style="margin-bottom: 0px">DH00<?php echo $product_id?></p>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action list-group-item-light">
                            <div class="d-flex align-items-center">
                                <strong style="margin-right: 95px">Product Name:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['product_name'];?></p>
                            </div>
                        </li>

                        <?php if($row_product_detail['product_type']=='Book'){ ?>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Language:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['language'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Category:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['category_name'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Publisher:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['publisher_name'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Publication Year:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['publication_year'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Book Format:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['book_format'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Book Size:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['packaging_size'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">ISBN:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['ISBN'];?></p>
                                </div>
                            </li>
                        <?php }else { ?>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Brand:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['brand_name'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Product Color:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['color'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Material:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['material'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Weight:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['weight'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Size:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['packaging_size'];?></p>
                                </div>
                            </li>
                        <?php }?>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Product Description:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['product_description'];?></p>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Status:</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['product_status'];?></p>
                            </div>
                            </li>
                            <li class="list-group-item list-group-item-action list-group-item-light">
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right: 50px">Product Price</strong>
                                    <p style="margin-bottom: 0px"><?php echo $row_product_detail['PricePerUnit'];?> VND</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
