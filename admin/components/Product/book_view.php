<?php
$product_id = $_GET['product_id'];
// SQL query to fetch book details
$sql = "
    SELECT
        p.product_id,
        p.product_image,
        p.product_status,
        p.product_quantity,
        p.product_price,
        b.book_name,
        b.book_description,
        b.book_publication_year,
        b.book_packaging_size,
        b.book_format,
        b.book_ISBN,
        s.supplier_name,
        c.book_category_name,
        l.book_language,
        a.author_name,
        pub.book_publisher_name
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    JOIN suppliers s ON s.supplier_id = p.supplier_id
    JOIN book_categories c ON b.book_category_id = c.book_category_id
    JOIN book_languages l ON b.book_language_id = l.book_language_id
    JOIN book_publishers pub ON b.book_publisher_id = pub.book_publisher_id
    JOIN book_author ba ON ba.product_id = b.product_id
    JOIN author a ON a.author_id =  ba.author_id
    WHERE p.product_id = ?
";

// Prepare and execute the query
$params = array($product_id);
$stmt = sqlsrv_query($conn, $sql, $params);

// Check if the query was successful
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the book details
$book = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
?>

<div class="container-fluid">
    <div class="header">
        <h3><a style="color:black;" href="book.php?page=<?php echo $_GET['page']; ?>"><i class='bx bxs-chevrons-left me-3'></i></a>Product Information</h3>
        <div class="d-flex justify-content-end">
            <a href="book_edit.php?product_id=<?php echo $product_id; ?>&page=<?php echo $_GET['page']; ?>" class="btn btn-warning">
                <i class='bx bx-sm bx-edit-alt me-1'></i>Edit Information
            </a>
        </div>
    </div>
</div>
<hr>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center d-flex justify-content-center align-items-center">
                <img src="<?php echo $book['product_image']; ?>" alt="Profile Image" class="img-fluid"
                     style="width: 200px; height: 300px;">
            </div>
            <div class="col-md-8">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 75px">Product Code:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['product_id']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 95px">Product Name:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['book_name']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Author:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['author_name']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Language:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['book_language']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Supplier:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['supplier_name']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Category:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['book_category_name']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Publisher:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['book_publisher_name']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Publication Year:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['book_publication_year']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Book Format:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['book_format']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Book Size:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['book_packaging_size']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">ISBN:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['book_ISBN']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Quantity:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['product_quantity']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Product Description:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['book_description']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Status:</strong>
                            <p style="margin-bottom: 0px"><?php echo $book['product_status']; ?></p>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex align-items-center">
                            <strong style="margin-right: 50px">Product Price:</strong>
                            <p style="margin-bottom: 0px"><?php echo number_format($book['product_price'], 0); ?> VND</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
