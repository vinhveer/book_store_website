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
    include ("components/card/card.php");
    ?>

    <?php
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        ?>

        <div class="container-fluid ps-4 pe-4">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-8">
                    <h3>Kết quả tìm kiếm</h3>
                    <p>Cho từ khóa "<?php echo $search ?>"</p>
                </div>
                <div class="col-md-4">
                    <a href="" class="btn btn-primary float-end">Trở về trang chủ</a>
                </div>
            </div>
        </div>
        <?php
        $search = $_GET['search'];
        $sql_search_book = "SELECT * FROM dbo.FindBooks('$search');";
        card_display($sql_search_book, "Các sách tìm được", $conn);

        $sql_search_others_product = "SELECT * FROM dbo.FindOthersProduct('$search');";
        card_display($sql_search_others_product, "Các sản phẩm khác", $conn);

    } else {
        ?>
        <div class="container-fluid ps-4 pe-4">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-8">
                    <h3>Không tìm thấy kết quả</h3>
                    <p>Vui lòng thử lại với từ khóa khác</p>
                </div>
                <div class="col-md-4">
                    <a href="" class="btn btn-primary float-end">Trở về trang chủ</a>
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
                window.addEventListener('scroll', function () {
                    const navbar = document.querySelector('.navbar');
                    if (window.scrollY > 700) {
                        navbar.classList.add('bg-body-tertiary');
                    } else {
                        navbar.classList.remove('bg-body-tertiary');
                    }
                });
            </script>
</body>

</html>