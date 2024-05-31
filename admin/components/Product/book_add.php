<div class="container-fluid mt-3">
    <h3><a style="color:black;" href="book.php"><i class='bx bxs-chevrons-left me-3'></i></a>Thêm Sản Phẩm</h3>
    <hr>
    <div class="mb-3">
        <button type="button" class="btn btn-success" id="addSupplierBtn" data-bs-toggle="modal" data-bs-target="#addSupplierModal"><i class='bx bx-folder-plus'></i> Thêm nhà cung cấp</button>
        <button type="button" class="btn btn-success" id="addBookTypeBtn" data-bs-toggle="modal" data-bs-target="#addBookTypeModal"><i class='bx bx-folder-plus'></i> Thêm mục sách</button>
        <button type="button" class="btn btn-success" id="addLanguageBtn" data-bs-toggle="modal" data-bs-target="#addLanguageModal"><i class='bx bx-folder-plus'></i> Thêm ngôn ngữ</button>
        <button type="button" class="btn btn-success" id="addPublisherBtn" data-bs-toggle="modal" data-bs-target="#addPublisherModal"><i class='bx bx-folder-plus'></i> Thêm nhà xuất bản</button>
    </div>
    <hr>
    <form action="components/Product/process.php" method="post" enctype="multipart/form-data">
      <div class="row">
          <div class="mb-3 col-md-4">
            <label for="productName" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="productName" required name="book_name">
          </div>
          <div class="mb-3 col-md-4">
            <?php
                 $sql_supplier = "SELECT * FROM suppliers";
                 $query_supplier = sqlsrv_query($conn, $sql_supplier);
            ?>
            <label for="supplier" class="form-label">Nhà cung cấp</label>
            <select class="form-select" id="supplier" required name="supplier">
              <option value="">- Chọn nhà cung cấp -</option>
              <?php
                  while($row_supplier = sqlsrv_fetch_array($query_supplier)) {?>
                    <option value="<?php echo $row_supplier['supplier_id'] ?>"><?php echo $row_supplier['supplier_name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3 col-md-4">
            <label for="author" class="form-label">Tác giả</label>
            <input type="text" class="form-control" id="author" required name="author">
          </div>
      </div>
      <div class="row">
          <div class="mb-3 col-md-4">
            <?php
                 $sql_book_categories = "SELECT * FROM book_categories";
                 $query_book_categories = sqlsrv_query($conn, $sql_book_categories);
            ?>
            <label for="bookType" class="form-label">Loại sách</label>
            <select class="form-select" id="bookType" required name="book_category">
              <option value="">- Chọn loại sách -</option>
              <?php
                  while($row_book_categories = sqlsrv_fetch_array($query_book_categories)) {?>
                    <option value="<?php echo $row_book_categories['book_category_id'] ?>"><?php echo $row_book_categories['book_category_name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3 col-md-4">
            <?php
                 $sql_book_languages = "SELECT * FROM book_languages";
                 $query_book_languages = sqlsrv_query($conn, $sql_book_languages);
            ?>
            <label for="language" class="form-label">Ngôn ngữ</label>
            <select class="form-select" id="language" required name="book_language">
              <option value="">- Chọn ngôn ngữ -</option>
              <?php
                  while($row_book_languages = sqlsrv_fetch_array($query_book_languages)) {?>
                    <option value="<?php echo $row_book_languages['book_language_id'] ?>"><?php echo $row_book_languages['book_language'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3 col-md-4">
            <label for="size" class="form-label">Kích thước</label>
            <input type="text" class="form-control" id="size" required name="size_book">
          </div>
      </div>
      <div class="row">
          <div class="mb-3 col-md-3">
          <?php
                 $sql_book_publishers = "SELECT * FROM book_publishers";
                 $query_book_publishers = sqlsrv_query($conn, $sql_book_publishers);
            ?>
            <label for="publisher" class="form-label">Nhà xuất bản</label>
            <select class="form-select" id="publisher" required name="publisher">
              <option value="">- Chọn nhà xuất bản -</option>
              <?php
                  while($row_book_publishers = sqlsrv_fetch_array($query_book_publishers)) {?>
                    <option value="<?php echo $row_book_publishers['book_publisher_id'] ?>"><?php echo $row_book_publishers['book_publisher_name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3 col-md-3">
            <label for="year" class="form-label">Năm xuất bản</label>
            <input type="number" class="form-control" id="year" required name="year">
          </div>
          <div class="mb-3 col-md-3">
            <label for="format" class="form-label">Định dạng sách</label>
            <input type="text" class="form-control" id="format" required name="format">
          </div>
          <div class="mb-3 col-md-3">
            <label for="ISBN" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="ISBN" required name="ISBN">
          </div>
      </div>
      <!-- Các trường cho sách -->

      <div class="row">
          <div class="mb-3 col-md-3">
            <label for="quantity" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="quantity" required name="quantity">
          </div>
          <div class="mb-3 col-md-3">
            <label for="price" class="form-label">Giá bán 1 SP:</label>
            <input type="number" class="form-control" id="price" required name="price">
          </div>
          <div class="mb-3 col-md-3">
            <label for="status" class="form-label">Tình trạng</label>
            <select class="form-select" id="status" required name="status">
              <option value="Available">Còn hàng</option>
              <option value="Unavailable">Hết hàng</option>
            </select>
          </div>
          <div class="mb-3 col-md-3">
                <label for="image" class="form-label">Ảnh sản phẩm</label>
                <input type="file" class="form-control" id="image" required name="image_product">
          </div>
      </div>
      <div class="mb-3">
          <label for="description" class="mb-2">Mô tả sản phẩm</label>
          <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary float-end"  name="sbm_add_product">Thêm Sản Phẩm</button>
    </form>
</div>

<!-- Modal Thêm Nhà Cung Cấp -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSupplierModalLabel">Thêm Nhà Cung Cấp</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form thêm nhà cung cấp -->
        <form id="addSupplierForm" action="components/Product/process.php?type=1" method="POST">
          <div class="mb-3">
            <label for="supplierName" class="form-label">Tên nhà cung cấp</label>
            <input type="text" class="form-control" id="supplierName" name="supplierName" required>
          </div>
          <div class="mb-3">
            <label for="supplierOrigin" class="form-label">Xuất xứ</label>
            <input type="text" class="form-control" id="supplierOrigin" name="supplierOrigin" required>
          </div>
          <button type="submit" class="btn btn-primary float-end" name="sbm_add_supplier">Thêm</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Thêm Mục Sách -->
<div class="modal fade" id="addBookTypeModal" tabindex="-1" aria-labelledby="addBookTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBookTypeModalLabel">Thêm Mục Sách</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form thêm mục sách -->
        <form id="addBookTypeForm" action="components/Product/process.php?type=1" method="POST">
          <div class="mb-3">
            <label for="bookTypeName" class="form-label">Tên mục sách</label>
            <input type="text" class="form-control" id="bookTypeName" name="bookTypeName" required>
          </div>
          <div class="mb-3">
            <label for="bookTypeImage" class="form-label">Hình ảnh loại sách URL</label>
            <input type="text" class="form-control" id="bookTypeImage" name="bookTypeImage" required>
          </div>
          <button type="submit" class="btn btn-primary float-end" name="sbm_bookType">Thêm</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Thêm Ngôn Ngữ -->
<div class="modal fade" id="addLanguageModal" tabindex="-1" aria-labelledby="addLanguageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLanguageModalLabel">Thêm Ngôn Ngữ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form thêm ngôn ngữ -->
        <form id="addLanguageForm" action="components/Product/process.php?type=1" method="POST">
          <div class="mb-3">
            <label for="languageName" class="form-label">Tên ngôn ngữ</label>
            <input type="text" class="form-control" id="languageName" name="languageName" required>
          </div>
          <button type="submit" class="btn btn-primary float-end" name="sbm_language">Thêm</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Thêm Nhà Xuất Bản -->
<div class="modal fade" id="addPublisherModal" tabindex="-1" aria-labelledby="addPublisherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPublisherModalLabel">Thêm Nhà Xuất Bản</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form thêm nhà xuất bản -->
        <form id="addPublisherForm" action="components/Product/process.php?type=1" method="POST">
          <div class="mb-3">
            <label for="publisherName" class="form-label">Tên nhà xuất bản</label>
            <input type="text" class="form-control" id="publisherName" name="publisherName" required>
          </div>
          <button type="submit" class="btn btn-primary float-end" name="sbm_publisher">Thêm</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function(){
    $("#addSupplierBtn").click(function(){
      $("#addSupplierModal").modal('show');
    });
    $("#addBookTypeBtn").click(function(){
      $("#addBookTypeModal").modal('show');
    });
    $("#addLanguageBtn").click(function(){
      $("#addLanguageModal").modal('show');
    });
    $("#addPublisherBtn").click(function(){
      $("#addPublisherModal").modal('show');
    });
  });
</script>
