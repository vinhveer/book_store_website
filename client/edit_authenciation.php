<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản và bảo mật</title>
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
                    <li class="list-group-item list-group-item-action list-group-item-light"><a
                            href="my_info.php">Profile information</a></li>
                    <li class="list-group-item list-group-item-action list-group-item-light active_item"><a
                            href="authenciation.php">Authenciation</a></li>
                </ul>
            </div>

            <form class="col-md-9" action="process.php" method="POST">
                <section id="personal-info">
                    <div class="container mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 style="margin-bottom: 0px">Edit authentication</h4>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary float-end" type="submit" name="update_auth">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <?php
                        $sql_auth = "SELECT ua.username, ua.password FROM users us
                        INNER JOIN user_roles ur ON us.user_id = ur.user_id
                        INNER JOIN user_accounts ua ON ua.user_role_id = ur.user_role_id
                        WHERE us.user_id = " . $_SESSION['user_id'];

                        $result_auth = sqlsrv_query($conn, $sql_auth);

                        $row_auth = sqlsrv_fetch_array($result_auth, SQLSRV_FETCH_ASSOC);
                        ?>
                        <div class="form">
                            <div class="mt-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="@<?php echo $row_auth['username'] ?>">
                                <small id="usernameError" class="text-danger"></small>
                            </div>
                            <div class="mt-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter new password">
                                <small id="passwordError" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </section>
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