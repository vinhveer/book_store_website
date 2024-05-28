<div class="container-fluid mt-3">
    <h3>Thêm sản phẩm</h3>
    <hr>
    <div class="mb-3">
      <button class="btn btn-success"><i class='bx bx-folder-plus'></i> Nhà cung cấp</button>
      <button class="btn btn-success"><i class='bx bx-folder-plus'></i> Tình trạng</button>
      <button class="btn btn-success"><i class='bx bx-folder-plus'></i> Danh mục</button>
      <!-- Nếu là sách -->
      <button class="btn btn-success"><i class='bx bx-folder-plus'></i> Loại sách</button>
      <button class="btn btn-success"><i class='bx bx-folder-plus'></i> Ngôn ngữ</button>
      <button class="btn btn-success"><i class='bx bx-folder-plus'></i> Nhà xuất bản</button>
      <!-- Nếu là văn phòng phẩm -->
      <button class="btn btn-success"><i class='bx bx-folder-plus'></i> Thương hiệu</button>
      <button class="btn btn-success"><i class='bx bx-folder-plus'></i> Loại VPP</button>
    </div>
    <hr>
    <form>
      <div class="row">
          <div class="mb-3 col-md-6">
            <label for="productCode" class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" id="productCode">
          </div>
          <div class="mb-3 col-md-6">
            <label for="productName" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="productName">
          </div>
      </div>
      <div class="row">
          <div class="mb-3 col-md-4">
            <label for="quantity" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="quantity">
          </div>
          <div class="mb-3 col-md-4">
            <label for="status" class="form-label">Tình trạng</label>
            <select class="form-select" id="status">
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
              <option value="3">Option 3</option>
            </select>
          </div>
          <div class="mb-3 col-md-4">
            <label for="category" class="form-label">Danh mục</label>
            <select class="form-select" id="category">
              <option value="">- Chọn danh mục -</option>
              <!-- Các danh mục ở đây -->
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
              <option value="3">Option 3</option>
            </select>
          </div>
      </div>
      <!-- Các trường cho sách -->
      <div class="row">
          <div class="mb-3 col-md-3">
            <label for="author" class="form-label">Tác giả</label>
            <input type="text" class="form-control" id="author">
          </div>
          <div class="mb-3 col-md-3">
            <label for="bookType" class="form-label">Loại sách</label>
            <select class="form-select" id="bookType">
              <option value="">- Chọn loại sách -</option>
              <!-- Các loại sách ở đây -->
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
              <option value="3">Option 3</option>
            </select>
          </div>
          <div class="mb-3 col-md-3">
            <label for="language" class="form-label">Ngôn ngữ</label>
            <select class="form-select" id="language">
              <option value="">- Chọn ngôn ngữ -</option>
              <!-- Các ngôn ngữ ở đây -->
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
              <option value="3">Option 3</option>
            </select>
          </div>
        <div class="mb-3 col-md-3">
            <label for="publisher" class="form-label">Nhà xuất bản</label>
            <select class="form-select" id="publisher">
            <option value="">- Chọn nhà xuất bản -</option>
            <!-- Các nhà xuất bản ở đây -->
            <option value="1">Option 1</option>
            <option value="2">Option 2</option>
            <option value="3">Option 3</option>
            </select>
        </div>
      </div>

      <!-- Các trường cho văn phòng phẩm -->
      <div class="row">
          <div class="mb-3 col-md-6">
            <label for="brand" class="form-label">Thương hiệu</label>
            <select class="form-select" id="brand">
              <option value="">- Chọn thương hiệu -</option>
              <!-- Các thương hiệu ở đây -->
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
              <option value="3">Option 3</option>
            </select>
          </div>
          <div class="mb-3 col-md-6">
            <label for="officeType" class="form-label">Loại văn phòng phẩm</label>
            <select class="form-select" id="officeType">
              <option value="">- Chọn loại văn phòng phẩm -</option>
              <!-- Các loại văn phòng phẩm ở đây -->
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
              <option value="3">Option 3</option>
            </select>
          </div>
      </div>
      <div class="row">
          <div class="mb-3 col-md-4">
            <label for="supplier" class="form-label">Nhà cung cấp</label>
            <select class="form-select" id="supplier">
              <option value="">- Chọn nhà cung cấp -</option>
              <!-- Các nhà cung cấp ở đây -->
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
              <option value="3">Option 3</option>
            </select>
          </div>
          <div class="mb-3 col-md-4">
            <label for="price" class="form-label">Giá bán</label>
            <input type="number" class="form-control" id="price">
          </div>
            <div class="mb-3 col-md-4">
                <label for="image" class="form-label">Ảnh sản phẩm</label>
                <input type="file" class="form-control" id="image">
            </div>
      </div>
      <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
    </form>
  </div>
