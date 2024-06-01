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
    ?>

    <div class="container-fluid mt-4 ps-4 pe-4">
        <div class="row">
            <div class="col-md-6">
                <h4>Thanh toán</h4>
            </div>
            <div class="col-md-6">
                <a class="btn btn-primary float-end" href="index.php">Hủy thanh toán</a>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4 ps-4 pe-4">
        <form class="row" action="payment_success.php" method="post">
            <div class="col-md-8">
                <h5>Thanh toán qua thẻ quốc tế</h5>
                <p>Chúng tôi hỗ trợ thanh toán qua Visa và MasterCard</p>
                <div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Số thẻ</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputEmail1" class="form-label">Ngày hết hạn</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputEmail1" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="payment_ok">Thanh toán</button>
                </div>
            </div>
            <div class="col-md-4">
                <h5>Chuyển khoản</h5>
                <p>Chuyển khoản qua tài khoản ngân hàng</p>
                <img src="assets/momo.jpg" class="w-50">
                <button type="submit" class="btn btn-primary" name="payment_ok">Tôi đã chuyển khoản thành công</button>
            </div>
            
        </form>
    </div>

    <?php
    include ("components/footer/footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>