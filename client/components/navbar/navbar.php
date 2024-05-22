<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="components/navbar/navbar.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary ps-3 pe-3 fixed-top pt-1 pb-1">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src=<?php echo $path . "assets/light_theme_logo.png" ?> alt="" srcset="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
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
                <form class="search d-flex me-auto w-50" role="search">
                    <input class="form-control input-search rounded-start rounded-0" type="search"
                        placeholder="Tìm kiếm sản phẩm" aria-label="Search">
                    <button class="btn btn-search rounded-end rounded-0" type="submit">
                        Search
                    </button>
                </form>

                <?php
                session_start();
                $_SESSION["login_success"] = true;
                $_SESSION["username"] = "Doge";
                if ($_SESSION["login_success"] == false) {
                    ?>
                    <div class="d-flex">
                        <button href="#" class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng
                            nhập</button>
                        <button href="#" class="btn btn-register ms-2 m-0" data-bs-toggle="modal"
                            data-bs-target="#registerModal">Đăng ký</button>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="d-flex pe-2 align-items-center">
                        <a class="btn btn-cart cart" href="cart.php">
                            <i class="bi bi-basket"></i> <span>Giỏ hàng của tôi</span>
                        </a>
                    </div>

                    <button class="d-flex btn p-0 align-items-center avatar" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <img src="assets/Original_Doge_meme.jpg" class="img-avatar">
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
        <div class="offcanvas-body">
            <div class="d-flex align-items-center justify-content-center">
                <img src="assets/Original_Doge_meme.jpg" class="img-offcanva">
            </div>
            <div class="text-center mt-3">
                <h3>Nguyen Quang Vinh</h3>
                <h6>vinh.nqu.64cntt@ntu.edu.vn</h6>
            </div>
            <ul class="list-group list-group-flush mt-3">
                <li class="list-group-item d-flex align-items-center">
                    <span><i class="bi bi-person-circle"></i></span> Thông tin cá nhân
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <span><i class="bi bi-bag"></i></span> Đơn hàng
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <span><i class="bi bi-box-arrow-left"></i></span>
                    Đăng xuất
                </li>
            </ul>
        </div>
    </div>

    <?php include ("components/login/login.php") ?>
</body>

</html>