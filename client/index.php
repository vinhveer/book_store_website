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
</head>

<body data-bs-theme="light">

    <?php
    $path = "";

    include 'connect.php';
    include ("components/navbar/navbar.php");
    include ("login.php");
    include ("components/home/header.php");
    include ("components/home/category.php");
    include ("components/card/card.php");

    $sql = "SELECT TOP 6 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id;";
    card_display($sql, "Các loại sách phổ biến", $conn);
    
    $sqlh2 = "SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Self-Help'
    UNION
    SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Health & Wellness'
    UNION
    SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN book_categories bc ON b.book_category_id = bc.book_category_id
    WHERE bc.book_category_name = 'Mind & Body'";
    card_display($sqlh2, "Phát triển bản thân", $conn);
    
    // $sql = "SELECT TOP 6 b.book_name, p.product_image, p.product_price, p.product_id
    // FROM books b
    // JOIN products p ON b.product_id = p.product_id;";
    // card_display($sql, "Các loại sách phổ biến", $conn);
    

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