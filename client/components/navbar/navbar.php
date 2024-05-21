<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="components/navbar/navbar.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary ps-3 pe-3 fixed-top">
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

                <div class="d-flex">
                    <button href="#" class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng
                        nhập</button>
                    <button href="#" class="btn btn-register ms-2 m-0" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký</button>
                </div>
            </div>
        </div>
    </nav>


    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="loginModalLabel">Đăng nhập</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        <div class="mt-3">
                            Chưa có tài khoản? <a href="#" class="text-decoration-none">Đăng ký ngay.</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="registerModalLabel">Đăng ký</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                        <div class="mt-3">
                            Đã có tài khoản? <a href="#" class="text-decoration-none" data-bs-dismiss="modal"
                                data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập ngay.</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>