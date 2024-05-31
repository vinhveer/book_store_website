<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="components/navbar/navbar.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary ps-3 pe-3 fixed-top pt-1 pb-1">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="<?php echo $path . 'assets/light_theme_logo.png'; ?>" alt="Logo" srcset="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="book.php">Sách</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="stationery.php">Văn phòng phẩm</a>
                    </li>
                </ul>
                <form class="search d-flex me-auto w-50" action="search.php" method="GET" role="search">
                    <input class="form-control input-search rounded-start rounded-0" name="search" type="search" placeholder="Tìm kiếm sản phẩm" aria-label="Search">
                    <button class="btn btn-search rounded-end rounded-0" type="submit" style="width: 100px">
                        <span>Tìm kiếm</span>
                    </button>
                </form>

                <?php
                if (!isset($_SESSION["login_success"])) {
                    ?>
                    <div class="d-flex">
                        <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</button>
                        <button class="btn btn-register ms-2 m-0" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký</button>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="d-flex pe-2 align-items-center">
                        <a class="btn btn-cart cart" href="cart.php">
                            <i class="bi bi-basket"></i> <span>Giỏ hàng của tôi</span>
                        </a>
                    </div>

                    <?php
                    $user_id = $_SESSION["user_id"];
                    $sql = "SELECT image_user FROM users WHERE user_id = ?";
                    $params = array($user_id);
                    $result = sqlsrv_query($conn, $sql, $params);
                    if ($result) {
                        $row = sqlsrv_fetch_array($result);
                        $image_user = $row["image_user"];
                    } else {
                        $image_user = 'assets/images/avatar/noavatar.jpg'; // Đường dẫn mặc định nếu không tìm thấy hình ảnh
                    }
                    ?>

                    <button class="d-flex btn p-0 align-items-center avatar" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <img src="<?php echo '../' . $image_user; ?>" class="img-avatar">
                    </button>

                    <?php
                }
                ?>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="p-3">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <?php
        if (isset($user_id)) {
            $sql = "SELECT full_name, email FROM users WHERE user_id = ?";
            $params = array($user_id);
            $result = sqlsrv_query($conn, $sql, $params);
            if ($result) {
                $row = sqlsrv_fetch_array($result);
                $full_name = $row["full_name"];
                $email = $row["email"];
            } else {
                $full_name = "Unknown";
                $email = "Unknown";
            }
        }
        ?>

        <div class="offcanvas-body">
            <div class="d-flex align-items-center justify-content-center">
                <img src="<?php echo '../' . $image_user; ?>" class="img-offcanva">
            </div>
            <div class="text-center mt-3">
                <h3><?php echo $full_name; ?></h3>
                <h6><?php echo $email; ?></h6>
            </div>
            <ul class="list-group list-group-flush mt-3">
                <a href="my_info.php" class="text-decoration-none">
                    <li class="list-group-item d-flex align-items-center">
                        <span><i class="bi bi-person-circle"></i></span> Thông tin cá nhân
                    </li>
                </a>

                <a href="my_order.php" class="text-decoration-none">
                    <li class="list-group-item d-flex align-items-center">
                        <span><i class="bi bi-bag"></i></span> Đơn hàng
                    </li>
                </a>

                <a href="../logout.php" class="text-decoration-none">
                    <li class="list-group-item d-flex align-items-center">
                        <span><i class="bi bi-box-arrow-left"></i></span> Đăng xuất
                    </li>
                </a>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
