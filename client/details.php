<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="details.css">
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
    include ("components/navbar/navbar.php");
    include ("login.php");
    ?>

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Check if the product is a book or another type of product
        $checkSql = "SELECT * FROM products WHERE product_id = $id";
        $checkResult = sqlsrv_query($conn, $checkSql);
        $product = sqlsrv_fetch_array($checkResult, SQLSRV_FETCH_ASSOC);

        if (!$product) {
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-12 p-5">
                        <h5 class="text-center display-5">Sản phẩm không tồn tại</h5>
                        <div class="button d-flex justify-content-center p-3">
                            <a href="index.php" class="btn btn-primary text-center ps-5 pe-5 pt-3 pb-3">Về trang chủ</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            // Determine the type of product and query accordingly
            $productTypeSql = "SELECT * FROM books WHERE product_id = $id";
            $productTypeResult = sqlsrv_query($conn, $productTypeSql);
            $isBook = sqlsrv_fetch_array($productTypeResult, SQLSRV_FETCH_ASSOC);

            if ($isBook) {
                // Fetch book details
                $sql = "SELECT * 
                FROM books bo
                INNER JOIN products pr ON bo.product_id = pr.product_id
                INNER JOIN book_author ba ON bo.product_id = ba.product_id
                INNER JOIN author au ON au.author_id = ba.author_id
                INNER JOIN book_categories bc ON bc.book_category_id = bo.book_category_id
                INNER JOIN book_languages bl ON bl.book_language_id = bo.book_language_id
                INNER JOIN book_publishers pb ON pb.book_publisher_id = bo.book_publisher_id
                WHERE bo.product_id = $id";

                $result = sqlsrv_query($conn, $sql);
                $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                ?>

                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-2">
                            <img class="book_image" src="<?php echo $row['product_image'] ?>" alt="<?php echo $row['book_name'] ?>">
                            <p class="text-center"><?php echo $row['book_ISBN'] ?></p>
                        </div>
                        <div class="col-md-7">
                            <h6 style="font-size: 18px;"><?php echo $row['author_name'] ?></h6>
                            <h3 class="display-6" style="font-size: 35px"><?php echo $row['book_name'] ?></h3>
                            <p style="padding-top: 20px"><?php echo $row['book_description'] ?></p>
                            <small
                                class="d-inline-flex mb-3 px-2 py-1 fw-semibold text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle rounded-2"><?php echo $row['book_language'] ?></small>
                            <small
                                class="d-inline-flex mb-3 px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2"><?php echo $row['book_category_name'] ?></small>
                        </div>
                        <div class="col-md-3">
                            <p style="font-size: 30px; font-weight: bold"><?php echo $row['product_price'] ?>đ</p>
                            <button class="btn btn-success"><i class="bi bi-cart-plus fw-2"></i>Add to cart</button>
                            <button class="btn btn-warning"><i class="bi bi-credit-card fw-2"></i>Buy now </button>
                        </div>
                    </div>
                </div>

                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <h5>Details</h5>
                            <table class="table">
                                <thead>
                                    <th></th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-weight: bold;">Publisher</td>
                                        <td><?php echo $row['book_publisher_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Publication Year</td>
                                        <td><?php echo $row['book_publication_year'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Packaging size</td>
                                        <td><?php echo $row['book_packaging_size'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Format</td>
                                        <td><?php echo $row['book_format'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">ISBN</td>
                                        <td><?php echo $row['book_ISBN'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php
            } else {
                // Fetch other product details
                $sql = "SELECT ot.others_product_name, pr.product_image, pr.product_price, pr.product_quantity, pr.product_status, 
                pc.category_name, su.supplier_name, su.supplier_origin, br.brand_name
                FROM products pr
                INNER JOIN others_products ot ON pr.product_id = ot.product_id
                INNER JOIN brands br ON ot.others_product_brand_id = br.brand_id
                INNER JOIN product_categories pc ON pr.category_id = pc.category_id
                INNER JOIN suppliers su ON pr.supplier_id = su.supplier_id
                WHERE pr.product_id = $id";

                $result = sqlsrv_query($conn, $sql);
                $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                ?>

                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-2">
                            <img class="book_image" src="<?php echo $row['product_image'] ?>" alt="<?php echo $row['others_product_name'] ?>">
                        </div>
                        <div class="col-md-7">
                            <h6 style="font-size: 18px;"><?php echo $row['brand_name'] ?></h6>
                            <h3 class="display-6" style="font-size: 35px"><?php echo $row['others_product_name'] ?></h3>
                            <small
                                class="d-inline-flex mb-3 px-2 py-1 fw-semibold text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle rounded-2"><?php echo $row['product_quantity'] ?></small>
                            <small
                                class="d-inline-flex mb-3 px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2"><?php echo $row['category_name'] ?></small>
                        </div>
                        <div class="col-md-3">
                            <p style="font-size: 30px; font-weight: bold"><?php echo $row['product_price'] ?>đ</p>
                            <button class="btn btn-success"><i class="bi bi-cart-plus fw-2"></i>Add to cart</button>
                            <button class="btn btn-warning"><i class="bi bi-credit-card fw-2"></i>Buy now </button>
                        </div>
                    </div>
                </div>

                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <h5>Details</h5>
                            <table class="table">
                                <thead>
                                    <th></th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-weight: bold;">Supplier name</td>
                                        <td><?php echo $row['supplier_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Supplier origin</td>
                                        <td><?php echo $row['supplier_origin'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Brand name</td>
                                        <td><?php echo $row['brand_name'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php
            }
        }
    } else {
        ?>
        <div class="container">
            <div class="row">
                <div class="col-12 p-5">
                    <h5 class="text-center display-5">Sản phẩm không tồn tại</h5>
                    <div class="button d-flex justify-content-center p-3">
                        <a href="index.php" class="btn btn-primary text-center ps-5 pe-5 pt-3 pb-3">Về trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.querySelector('.navbar');
            navbar.classList.remove('bg-body-tertiary');
        });

        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY < 700) {
                navbar.classList.remove('bg-body-tertiary');
            } else {
                navbar.classList.add('bg-body-tertiary');
            }
        });
    </script>
</body>

</html>