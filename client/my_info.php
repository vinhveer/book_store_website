<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="my_info.css">
</head>

<body data-bs-theme="light">

    <?php
    $path = "";
    include 'connect.php';
    include ("components/navbar/navbar.php");
    include ("login.php");

    $user_id = $_SESSION['user_id'];
    // Truy vấn thông tin người dùng
    $sql_user = "SELECT * FROM users WHERE user_id = $user_id";
    $result_user = sqlsrv_query($conn, $sql_user);
    $row_user = sqlsrv_fetch_array($result_user);
    ?>

    <main class="container">
        <div class="row">
            <div class="col-md-3">
                <h5 class="mb-2 p-2">Account Settings</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action list-group-item-light active_item"><a
                            href="my_info.php">Profile information</a></li>
                    <li class="list-group-item list-group-item-action list-group-item-light"><a
                            href="authenciation.php">Authenciation</a></li>
                </ul>
            </div>

            <div class="col-md-9">
                <section id="personal-info">
                    <div class="container mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 style="margin-bottom: 0px">Profile information</h4>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-primary float-end" href="my_info_edit.php">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row header">
                            <div class="col-md-2">
                                <!-- Hiển thị ảnh đại diện của người dùng -->
                                <img src="../../../../<?php echo $row_user['image_user'] ?>" alt="Avatar"
                                    class="avatar_header">
                            </div>
                            <div class="col-md-10">
                                <!-- Hiển thị tên và email của người dùng -->
                                <h3><?php echo $row_user['full_name'] ?>
                                </h3>
                                <p><?php echo $row_user['email'] ?></p>
                            </div>
                            <div class="mt-5">
                                <ul class="list-group list-group-flush">
                                    <!-- Hiển thị thông tin cá nhân của người dùng -->
                                    <li class="list-group-item list-group-item-action list-group-item-light">
                                        <div class="d-flex align-items-center">
                                            <strong style="margin-right: 92px">Gender</strong>
                                            <p style="margin-bottom: 0px">
                                                <?php echo $row_user['gender'] == 1 ? "Female" : "Male" ?>
                                            </p>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-light">
                                        <div class="d-flex align-items-center">
                                            <strong style="margin-right: 50px">Date Of Birth</strong>
                                            <!-- Hiển thị ngày sinh của người dùng -->
                                            <p style="margin-bottom: 0px">
                                                <?php echo date_format($row_user['date_of_birth'], 'd/m/Y') ?>
                                            </p>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-light">
                                        <div class="d-flex align-items-center">
                                            <strong style="margin-right: 85px">Address</strong>
                                            <!-- Hiển thị địa chỉ của người dùng -->
                                            <p style="margin-bottom: 0px"><?php echo $row_user['address'] ?></p>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-light">
                                        <div class="d-flex align-items-center">
                                            <strong style="margin-right: 95px">Phone</strong>
                                            <!-- Hiển thị số điện thoại của người dùng -->
                                            <p style="margin-bottom: 0px"><?php echo $row_user['phone'] ?></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

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
