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

            <form class="col-md-9" action="process.php" method="POST" enctype="multipart/form-data">
                <div class="container mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 style="margin-bottom: 0px">Edit profile information</h4>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary float-end" type="submit">Save</button>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row header">
                        <div class="col-md-2">
                            <img src="../../../../<?php echo $row_user['image_user'] ?>" alt="" srcset=""
                                class="avatar_header" style="width: 100px">
                        </div>
                        <div class="col-md-10">
                            <h5>Upload your avatar if you need change</h5>
                            <input type="file" name="avatar_image" class="form-control">
                        </div>
                        <div class="mt-5 mb-5">
                            <form action="" class="form-control">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="first_name" class="form-label">Full-name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="<?php echo $row_user['full_name'] ?>">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?php echo $row_user['email'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="<?php echo $row_user['phone'] ?>">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="dob" name="dob"
                                            value="<?php echo $row_user['date_of_birth']->format('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select" id="gender" name="gender">
                                            <option value="1" <?php if ($row_user['gender'] == 'male')
                                                echo 'selected'; ?>>Male</option>
                                            <option value="2" <?php if ($row_user['gender'] == 'female')
                                                echo 'selected'; ?>>Female</option>
                                            <option value="3" <?php if ($row_user['gender'] == 'other')
                                                echo 'selected'; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address"
                                            name="address"><?php echo $row_user['address'] ?></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
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