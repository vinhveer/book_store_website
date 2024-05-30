<?php
    include_once 'config/connect.php';
    $product_id = $_GET['product_id'];

    $sql = "
        SELECT
            p.product_price, p.product_image, p.product_quantity, p.product_status,
            op.others_product_name, op.others_product_description, op.others_product_color,
            op.others_product_material, op.others_product_weight, op.others_product_size,
            pc.category_id, pc.category_name, s.supplier_name, s.supplier_id, b.brand_id, b.brand_name
        FROM others_products op
        JOIN products p ON op.product_id = p.product_id
        JOIN product_categories pc ON p.category_id = pc.category_id
        JOIN suppliers s ON s.supplier_id = p.supplier_id
        JOIN brands b ON op.others_product_brand_id = b.brand_id
        WHERE op.product_id = ?";
    $params = array($product_id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row_product_detail = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if($row_product_detail === null) {
        echo "Product not found.";
        exit();
    }
?>
<div class="container-fluid mt-3">
    <h3><a style="color:black;" href="other_product.php"><i class='bx bxs-chevrons-left me-3'></i></a>Sửa Thông Tin Sản Phẩm</h3>
    <hr>
    <div class="mb-3">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSupplierModal"><i class='bx bx-folder-plus'></i> Thêm Nhà Cung Cấp</button>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductTypeModal"><i class='bx bx-folder-plus'></i> Thêm Loại Sản Phẩm</button>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBrandModal"><i class='bx bx-folder-plus'></i> Thêm Thương Hiệu</button>
    </div>
    <hr>
    <form action="components/Product/process.php?product_id=<?php echo $product_id; ?>&page=<?php echo $_GET['page']; ?>" method="post" enctype="multipart/form-data">
      <div class="row">
          <div class="mb-3 col-md-3">
            <label for="productName" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="productName" name="other_product_name" value="<?php echo $row_product_detail['others_product_name']; ?>">
          </div>
          <div class="mb-3 col-md-3">
            <?php
                 $sql_supplier = "SELECT * FROM suppliers";
                 $query_supplier = sqlsrv_query($conn, $sql_supplier);
            ?>
            <label for="supplier" class="form-label">Nhà cung cấp</label>
            <select class="form-select" id="supplier" name="supplier">
              <option value="" disabled selected>- Chọn nhà cung cấp -</option>
              <?php
                   while($row_supplier = sqlsrv_fetch_array($query_supplier)) {?>
                    <option value="<?php echo $row_supplier['supplier_id'] ?>" <?php echo ($row_supplier['supplier_id'] == $row_product_detail['supplier_id']) ? 'selected' : ''; ?>><?php echo $row_supplier['supplier_name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3 col-md-3">
            <?php
                 $sql_product_categories = "SELECT * FROM product_categories Where category_name <> 'Books'";
                 $query_product_categories = sqlsrv_query($conn, $sql_product_categories);
            ?>
            <label for="officeType" class="form-label">Loại văn phòng phẩm</label>
            <select class="form-select" id="officeType" name="category">
              <option value="" disabled selected>- Chọn mục SP -</option>
              <?php
                  while($row_product_categories = sqlsrv_fetch_array($query_product_categories)) {?>
                    <option value="<?php echo $row_product_categories['category_id'] ?>" <?php echo ($row_product_categories['category_id'] == $row_product_detail['category_id']) ? 'selected' : ''; ?>><?php echo $row_product_categories['category_name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3 col-md-3">
            <?php
                 $sql_brands = "SELECT * FROM brands";
                 $query_brands = sqlsrv_query($conn, $sql_brands);
            ?>
            <label for="brand" class="form-label">Thương hiệu</label>
            <select class="form-select" id="brand" name="brand">
              <option value="" disabled selected>- Chọn thương hiệu -</option>
              <?php
                  while($row_brands = sqlsrv_fetch_array($query_brands)) {?>
                    <option value="<?php echo $row_brands['brand_id'] ?>" <?php echo ($row_brands['brand_id'] == $row_product_detail['brand_id']) ? 'selected' : ''; ?>><?php echo $row_brands['brand_name'] ?></option>
              <?php } ?>
            </select>
          </div>
      </div>
      <div class="row">

          <div class="mb-3 col-md-3">
            <label for="color" class="form-label">Màu sắc</label>
            <input type="text" class="form-control" id="color" name="color" value="<?php echo $row_product_detail['others_product_color'] ?>">
          </div>
          <div class="mb-3 col-md-3">
            <label for="material" class="form-label">Chất liệu</label>
            <input type="text" class="form-control" id="material" name="material" value="<?php echo $row_product_detail['others_product_material'] ?>">
          </div>
          <div class="mb-3 col-md-3">
            <label for="weight" class="form-label">Trọng lượng</label>
            <input type="text" class="form-control" id="weight" name="weight" value="<?php echo $row_product_detail['others_product_weight'] ?>">
          </div>
          <div class="mb-3 col-md-3">
            <label for="size" class="form-label">Kích thước</label>
            <input type="text" class="form-control" id="size" name="size" value="<?php echo $row_product_detail['others_product_size'] ?>">
          </div>
      </div>
      <div class="row">
          <div class="mb-3 col-md-3">
            <label for="quantity" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $row_product_detail['product_quantity'] ?>">
          </div>
          <div class="mb-3 col-md-3">
            <label for="price" class="form-label">Giá bán 1 SP:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $row_product_detail['product_price'] ?>">
          </div>
          <div class="mb-3 col-md-3">
            <label for="status" class="form-label">Tình trạng</label>
                <select class="form-select" id="status" required name="status">
                    <option value="Available" <?php echo ($row_product_detail['product_status'] == "Available") ? 'selected' : ''; ?>>Còn hàng</option>
                    <option value="Unavailable" <?php echo ($row_product_detail['product_status'] == "Unavailable") ? 'selected' : ''; ?>>Hết hàng</option>
                </select>
          </div>
          <div class="mb-3 col-md-3">
                <label for="image" class="form-label">Ảnh sản phẩm</label>
                <input type="file" class="form-control" id="image" name="image_other_product">
          </div>
      </div>
      <div class="mb-3">
          <label for="description" class="mb-2">Mô tả sản phẩm</label>
          <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $row_product_detail['others_product_description'] ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary float-end" name="sbm_edit_other">Cập nhật</button>
    </form>
  </div>

  <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSupplierModalLabel">Thêm Nhà Cung Cấp</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form thêm nhà cung cấp -->
        <form action="components/Product/process.php?type=2&page=<?php echo $_GET['page']; ?>&product_id=<?php echo $product_id; ?>" method="POST">
          <div class="mb-3">
            <label for="supplierName" class="form-label">Tên nhà cung cấp</label>
            <input type="text" class="form-control" id="supplierName" name="supplierName" required>
          </div>
          <div class="mb-3">
            <label for="supplierOrigin" class="form-label">Xuất xứ</label>
            <input type="text" class="form-control" id="supplierOrigin" name="supplierOrigin" required>
          </div>
          <button type="submit" class="btn btn-primary float-end" name="sbm_other_supplier">Thêm</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Thêm loại sản phẩm modal -->
<div class="modal fade" id="addProductTypeModal" tabindex="-1" aria-labelledby="addProductTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductTypeModalLabel">Thêm Loại Sản Phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form thêm loại sản phẩm -->
        <form action="components/Product/process.php?type=2&page=<?php echo $_GET['page']; ?>&product_id=<?php echo $product_id; ?>" method="POST">
          <div class="mb-3">
            <label for="productType" class="form-label">Tên loại sản phẩm</label>
            <input type="text" class="form-control" id="productType" name="productType" required>
          </div>
          <button type="submit" class="btn btn-primary float-end" name="sbm_add_cag">Thêm</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Thêm thương hiệu modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBrandModalLabel">Thêm Thương Hiệu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form thêm thương hiệu -->
        <form action="components/Product/process.php?type=2&page=<?php echo $_GET['page']; ?>&product_id=<?php echo $product_id; ?>" method="POST">
          <div class="mb-3">
            <label for="brandName" class="form-label">Tên thương hiệu</label>
            <input type="text" class="form-control" id="brandName" name="brandName" required>
          </div>
          <div class="mb-3">
            <label for="brandOrigin" class="form-label">Nguồn gốc</label>
            <input type="text" class="form-control" id="brandOrigin" name="brandOrigin" required>
          </div>
          <div class="mb-3">
            <label for="brandImage" class="form-label">Ảnh thương hiệu URL</label>
            <input type="text" class="form-control" id="brandImage" name="brandImage" required>
          </div>
          <button type="submit" class="btn btn-primary float-end" name="sbm_brand">Thêm</button>
        </form>
      </div>
    </div>
  </div>
</div>
