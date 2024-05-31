<?php
include '../../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_add_product"])) {
    $book_name = $_POST['book_name'];
    $product_price = $_POST['price'];
    $product_image = $_FILES['image_product']['name'];
    $product_quantity = $_POST['quantity'];
    $supplier_id = $_POST['supplier'];
    $product_status = $_POST['status'];
    $book_category_id = $_POST['book_category'];
    $book_description = $_POST['description'];
    $book_language_id = $_POST['book_language'];
    $book_publication_year = $_POST['year'];
    $book_packaging_size = $_POST['size_book'];
    $book_format = $_POST['format'];
    $book_ISBN = $_POST['ISBN'];
    $book_publisher_id = $_POST['publisher'];
    $author_name = $_POST['author'];

    // File upload handling
    $target_image = "assets/images/product/". basename($product_image);
    $target_file = "../../".$target_image;
    move_uploaded_file($_FILES["image_product"]["tmp_name"],$target_file);

    $sql = "EXEC sp_InsertProductAndBook ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";

    $params = array(
        $book_name,
        1,
        $product_price,
        $target_image,
        $product_quantity,
        $supplier_id,
        $product_status,
        $book_category_id,
        $book_description,
        $book_language_id,
        $book_publication_year,
        $book_packaging_size,
        $book_format,
        $book_ISBN,
        $book_publisher_id,
        $author_name
    );

    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($stmt)) {
        echo "Product and Book added successfully.";
        header ("location: ../../book.php");
    } else {
        echo "Error in executing statement.\n";
        die(print_r(sqlsrv_errors(), true));
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_add_other"])) {
    // Retrieve and sanitize form inputs
    $category_id = $_POST['category'];
    $product_price = $_POST['price'];
    $product_image = $_FILES['image_other_product']['name'];
    $product_quantity = $_POST['quantity'];
    $supplier_id = $_POST['supplier'];
    $product_status = $_POST['status'];
    $others_product_name = $_POST['other_product_name'];
    $others_product_description = $_POST['description'];
    $others_product_brand_id = $_POST['brand'];
    $others_product_color = $_POST['color'];
    $others_product_material = $_POST['material'];
    $others_product_weight = $_POST['weight'];
    $others_product_size = $_POST['size'];

    // Handle file upload
    $target_image = "assets/images/product/". basename($product_image);
    $target_file ="../../".$target_image ;
    move_uploaded_file($_FILES["image_other_product"]["tmp_name"], $target_file);

    // Prepare the SQL statement
    $sql = "EXEC sp_InsertProductAndOtherProduct ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";

    $params = array(
        $category_id,
        $product_price,
        $target_image,
        $product_quantity,
        $supplier_id,
        $product_status,
        $others_product_name,
        $others_product_description,
        $others_product_brand_id,
        $others_product_color,
        $others_product_material,
        $others_product_weight,
        $others_product_size
    );

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Product and Other Product added successfully.";
        header ("location: ../../other_product.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_edit_product"])) {
    $product_id = $_GET['product_id']; $page=$_GET['page'];
    $book_name = $_POST['book_name'];
    $product_price = $_POST['price'];
    $product_quantity = $_POST['quantity'];
    $supplier_id = $_POST['supplier'];
    $product_status = $_POST['status'];
    $book_category_id = $_POST['book_category'];
    $book_description = $_POST['description'];
    $book_language_id = $_POST['book_language'];
    $book_publication_year = $_POST['year'];
    $book_packaging_size = $_POST['size_book'];
    $book_format = $_POST['format'];
    $book_ISBN = $_POST['ISBN'];
    $book_publisher_id = $_POST['publisher'];
    $author_name = $_POST['author'];
    $sql_select_pro = "SELECT * FROM products Where product_id=$product_id";
    $query_select = sqlsrv_query($conn,$sql_select_pro);
    $row_select = sqlsrv_fetch_array($query_select);
    if(isset($_FILES['image_product']) && $_FILES['image_product']['error'] === UPLOAD_ERR_OK) {
        $product_image = $_FILES['image_product']['name'];
        $target_image = "assets/images/product/". basename($product_image);
        $target_file = "../../".$target_image;
         move_uploaded_file($_FILES["image_product"]["tmp_name"],$target_file);
    }else{
        $target_image ="";
    }
    if($target_image == NULL){
        $target_image = $row_select['product_image'];
    }
    $sql = "EXEC UpdateProductAndBook ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";

    $params = array(
        $product_id,
        $book_name,
        1,
        $product_price,
        $target_image,
        $product_quantity,
        $supplier_id,
        $product_status,
        $book_category_id,
        $book_description,
        $book_language_id,
        $book_publication_year,
        $book_packaging_size,
        $book_format,
        $book_ISBN,
        $book_publisher_id,
        $author_name
    );

    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($stmt)) {
        echo "Product and Book edited successfully.";
        header ("location: ../../book.php?page=$page");
    } else {
        echo "Error in executing statement.\n";
        die(print_r(sqlsrv_errors(), true));
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_edit_other"])) {
    $page=$_GET['page'];
    $product_id = $_GET['product_id'];
    $category_id = $_POST['category'];
    $product_price = $_POST['price'];
    $product_quantity = $_POST['quantity'];
    $supplier_id = $_POST['supplier'];
    $product_status = $_POST['status'];
    $others_product_name = $_POST['other_product_name'];
    $others_product_description = $_POST['description'];
    $others_product_brand_id = $_POST['brand'];
    $others_product_color = $_POST['color'];
    $others_product_material = $_POST['material'];
    $others_product_weight = $_POST['weight'];
    $others_product_size = $_POST['size'];

    $sql_select_pro = "SELECT * FROM products Where product_id=$product_id";
    $query_select = sqlsrv_query($conn,$sql_select_pro);
    $row_select = sqlsrv_fetch_array($query_select);
    if(isset($_FILES['image_other_product']) && $_FILES['image_other_product']['error'] === UPLOAD_ERR_OK) {
        $product_image = $_FILES['image_other_product']['name'];
        $target_image = "assets/images/product/". basename($product_image);
        $target_file = "../../".$target_image;
         move_uploaded_file($_FILES["image_other_product"]["tmp_name"],$target_file);
    }else{
        $target_image ="";
    }
    if($target_image == NULL){
        $target_image = $row_select['product_image'];
    }

    // Prepare the SQL statement
    $sql = "EXEC sp_EditOtherProduct ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";

    $params = array(
        $product_id,
        $category_id,
        $product_price,
        $target_image,
        $product_quantity,
        $supplier_id,
        $product_status,
        $others_product_name,
        $others_product_description,
        $others_product_brand_id,
        $others_product_color,
        $others_product_material,
        $others_product_weight,
        $others_product_size
    );

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Product and Other Product edited successfully.";
        header ("location: ../../other_product.php?page=$page");

    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_add_supplier"])) {
    $type=$_GET['type'];
    $page= (isset($_GET['page']))?$_GET['page']:'1';
    $product_id = (isset($_GET['product_id']))?$_GET['product_id']:'';
    $supplier_name = $_POST['supplierName'];
    $supplier_origin = $_POST['supplierOrigin'];
    $sql_supplier_add = "INSERT INTO suppliers(supplier_name,supplier_origin) VALUES (N'$supplier_name',N'$supplier_origin')";
    $query_add_supplier = sqlsrv_query($conn,$sql_supplier_add);
    if ($query_add_supplier === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Product and Other Product edited successfully.";
        if($type==1) header ("location: ../../book_add.php");
        else if($type == 2) header ("location: ../../book_edit.php?page=$page&product_id=$product_id");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_other_supplier"])) {
    $type=$_GET['type'];
    $page= (isset($_GET['page']))?$_GET['page']:'1';
    $product_id = (isset($_GET['product_id']))?$_GET['product_id']:'';
    $supplier_name = $_POST['supplierName'];
    $supplier_origin = $_POST['supplierOrigin'];
    $sql_supplier_add = "INSERT INTO suppliers(supplier_name,supplier_origin) VALUES (N'$supplier_name',N'$supplier_origin')";
    $query_add_supplier = sqlsrv_query($conn,$sql_supplier_add);
    if ($query_add_supplier === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Product and Other Product edited successfully.";
        if($type==1) header ("location: ../../other_product_add.php");
        else if($type == 2) header ("location: ../../book_edit.php?page=$page&product_id=$product_id");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_bookType"])) {
    $type=$_GET['type'];
    $page= (isset($_GET['page']))?$_GET['page']:'1';
    $product_id = (isset($_GET['product_id']))?$_GET['product_id']:'';
    $bookTypeName = $_POST['bookTypeName'];
    $bookTypeImage = $_POST['bookTypeImage'];
    $sql_book_categories_add = "INSERT INTO book_categories(book_category_name,image_category) VALUES (N'$bookTypeName','$bookTypeImage')";
    $query_book_categories_add = sqlsrv_query($conn,$sql_book_categories_add);
    if($type==1) header ("location: ../../book_add.php");
    else if($type == 2) header ("location: ../../book_edit.php?page=$page&product_id=$product_id");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_language"])) {
    $type=$_GET['type'];
    $page= (isset($_GET['page']))?$_GET['page']:'1';
    $product_id = (isset($_GET['product_id']))?$_GET['product_id']:'';
    $languageName = $_POST['languageName'];
    $sql_book_languages_add = "INSERT INTO book_languages(book_language) VALUES (N'$languageName')";
    $query_book_languages_add = sqlsrv_query($conn,$sql_book_languages_add);
    if($type==1) header ("location: ../../book_add.php");
    else if($type == 2) header ("location: ../../book_edit.php?page=$page&product_id=$product_id");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_publisher"])) {
    $type=$_GET['type'];
    $page= (isset($_GET['page']))?$_GET['page']:'1';
    $product_id = (isset($_GET['product_id']))?$_GET['product_id']:'';
    $publisherName = $_POST['publisherName'];
    $sql_book_publishers_add = "INSERT INTO book_publishers(book_publisher_name) VALUES (N'$publisherName')";
    $query_book_publishers_add = sqlsrv_query($conn,$sql_book_publishers_add);
    if ($query_book_publishers_add === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Product and Other Product edited successfully.";
        if($type==1) header ("location: ../../book_add.php");
        else if($type == 2) header ("location: ../../book_edit.php?page=$page&product_id=$product_id");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_add_cag"])) {
    $type=$_GET['type'];
    $page= (isset($_GET['page']))?$_GET['page']:'1';
    $product_id = (isset($_GET['product_id']))?$_GET['product_id']:'';
    $productType = $_POST['productType'];
    $sql_product_categories_add = "INSERT INTO product_categories(category_name) VALUES (N'$productType')";
    $query_product_categories_add = sqlsrv_query($conn,$sql_product_categories_add);
    if($type==1) header ("location: ../../other_product_add.php");
    else if($type == 2) header ("location: ../../book_edit.php?page=$page&product_id=$product_id");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_brand"])) {
    $type=$_GET['type'];
    $page= (isset($_GET['page']))?$_GET['page']:'1';
    $product_id = (isset($_GET['product_id']))?$_GET['product_id']:'';
    $brandName = $_POST['brandName'];
    $brandOrigin = $_POST['brandOrigin'];
    $brandImage = $_POST['brandImage'];
    $sql_brands_add = "INSERT INTO brands (brand_name,brand_origin,brand_image) VALUES (N'$brandName',N'$brandOrigin','$brandImage')";
    $query_brands_add = sqlsrv_query($conn,$sql_brands_add);
    if ($query_brands_add === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Product and Other Product edited successfully.";
        if($type==1) header ("location: ../../other_product_add.php");
        else if($type == 2) header ("location: ../../book_edit.php?page=$page&product_id=$product_id");
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_delete_product"])) {
    $type = $_GET['type'];
    $product_id = $_POST['product_id'];
    $page = $_GET['page'];
    $sql_delete_pro = "DELETE FROM products where product_id = $product_id";
    $query_delete_pro = sqlsrv_query($conn,$sql_delete_pro);
    if ($query_delete_pro === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    if($type==1) header ("location: ../../book.php?page=$page");
    else if($type==2) header ("location: ../../other_product.php?page=$page");
}
?>
