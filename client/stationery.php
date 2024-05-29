<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Văn phòng phẩm</title>
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
    include ("components/home/category.php");
    include ("components/card/card.php");

    $sqlh4 ="SELECT TOP 7 od.others_product_name, p.product_image, p.product_price, p.product_id
    FROM others_products  od
    JOIN products p ON od.product_id = p.product_id 
    WHERE od.others_product_name LIKE 'bút%'
    EXCEPT
    SELECT od.others_product_name, p.product_image, p.product_price, p.product_id
    FROM others_products  od
    JOIN products p ON od.product_id = p.product_id 
    WHERE od.others_product_name LIKE 'bút gel%'";
    card_display($sqlh4, "Đồ dùng học tập", $conn);

    $sqlh5 = "SELECT TOP 6 od.others_product_name, p.product_image, p.product_price, p.product_id
    FROM others_products  od
    JOIN products p ON od.product_id = p.product_id 
    WHERE od.others_product_name LIKE '%Thiên Long%'";
    card_display($sqlh5, "Sản phẩm Thiên Long", $conn);

    $sqlh6 ="SELECT TOP 3 od.others_product_name, p.product_image, p.product_price, p.product_id
    FROM others_products  od
    JOIN products p ON od.product_id = p.product_id 
    WHERE od.others_product_name LIKE 'máy tính%'
    UNION
    SELECT TOP 3 od.others_product_name, p.product_image, p.product_price, p.product_id
    FROM others_products  od
    JOIN products p ON od.product_id = p.product_id 
    WHERE od.others_product_name LIKE '%gel%'";
    card_display($sqlh6, "Đồ dùng văn phòng", $conn);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>