<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sách</title>
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
    include ("components/home/category_book.php");
    include ("components/card/card.php");
    ?>

    <div id="entertainment-education">
        <?php
        $sqlh7 = "SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
        FROM books b
        JOIN products p ON b.product_id = p.product_id
        JOIN book_categories bc ON b.book_category_id = bc.book_category_id
        WHERE bc.book_category_name = 'Comic Books'
        UNION
        SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
        FROM books b
        JOIN products p ON b.product_id = p.product_id
        JOIN book_categories bc ON b.book_category_id = bc.book_category_id
        WHERE bc.book_category_name = 'Games & Activities'
        UNION
        SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
        FROM books b
        JOIN products p ON b.product_id = p.product_id
        JOIN book_categories bc ON b.book_category_id = bc.book_category_id
        WHERE bc.book_category_name = 'Home & Garden'";
        card_display($sqlh7, "Giải trí và Giáo dục", $conn);
        ?>
    </div>

    <div id="science-society">
        <?php
        $sqlh8 = "SELECT TOP 6 * FROM (
            SELECT b.book_name, p.product_image, p.product_price, p.product_id
                FROM books b
                JOIN products p ON b.product_id = p.product_id
                JOIN book_categories bc ON b.book_category_id = bc.book_category_id
                WHERE bc.book_category_name = 'Philosophy'
                UNION
                SELECT b.book_name, p.product_image, p.product_price, p.product_id
                FROM books b
                JOIN products p ON b.product_id = p.product_id
                JOIN book_categories bc ON b.book_category_id = bc.book_category_id
                WHERE bc.book_category_name = 'History'
                UNION
                SELECT b.book_name, p.product_image, p.product_price, p.product_id
                FROM books b
                JOIN products p ON b.product_id = p.product_id
                JOIN book_categories bc ON b.book_category_id = bc.book_category_id
                WHERE bc.book_category_name = 'Social Sciences'
            ) AS book";
        card_display($sqlh8, "Khoa học và Xã hội", $conn);
        ?>
    </div>

    <div id="literature-art">
        <?php
        $sqlh9 = "SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
        FROM books b
        JOIN products p ON b.product_id = p.product_id
        JOIN book_categories bc ON b.book_category_id = bc.book_category_id
        WHERE bc.book_category_name = 'Art'
        UNION
        SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
        FROM books b
        JOIN products p ON b.product_id = p.product_id
        JOIN book_categories bc ON b.book_category_id = bc.book_category_id
        WHERE bc.book_category_name = 'Cooking'
        UNION
        SELECT TOP 2 b.book_name, p.product_image, p.product_price, p.product_id
        FROM books b
        JOIN products p ON b.product_id = p.product_id
        JOIN book_categories bc ON b.book_category_id = bc.book_category_id
        WHERE bc.book_category_name = 'Computer Science'";
        card_display($sqlh9, "Văn học và Nghệ thuật", $conn);
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>