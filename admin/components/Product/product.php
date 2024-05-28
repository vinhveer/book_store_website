<div class="container">
        <h2 class="mb-4">Danh sách sản phẩm</h2>

        <!-- Tìm kiếm và lọc danh mục -->
        <div class="row mb-4">
            <div class="col-md-6 d-flex">
                <input type="search" id="search" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                <button class="btn btn-outline-primary ms-2" id="searchBtn">Tìm</button>
            </div>
            <div class="col-md-4 d-flex">
                <select id="categoryFilter" class="form-select">
                    <option value="">Tất cả danh mục</option>
                    <option value="Book">Sách</option>
                    <option value="Stationery">Văn phòng phẩm</option>
                </select>
                <button class="btn btn-outline-primary ms-2" id="searchBtn">Lọc</button>
            </div>
            <div class="col-md-2">
                <a href="product_add.php" class="btn btn-success btn-block">Thêm sản phẩm</a>
            </div>
        </div>

        <!-- Bảng danh sách sản phẩm -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Số lượng</th>
                    <th>Tình trạng</th>
                    <th>Giá tiền</th>
                    <th>Danh mục</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody id="productList">
                <tr>
                    <td>001</td>
                    <td>Tiếng Anh</td>
                    <td><img src="https://via.placeholder.com/50" alt="Tiếng Anh"></td>
                    <td>10</td>
                    <td>Còn hàng</td>
                    <td>20,000 VND</td>
                    <td>Sách</td>
                    <td>
                        <button class="btn btn-info btn-sm">Xem</button>
                        <button class="btn btn-warning btn-sm">Sửa</button>
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </td>
                </tr>
                <tr>
                    <td>002</td>
                    <td>Tiếng Việt</td>
                    <td><img src="https://via.placeholder.com/50" alt="Tiếng Việt"></td>
                    <td>15</td>
                    <td>Còn hàng</td>
                    <td>50,000 VND</td>
                    <td>Sách</td>
                    <td>
                        <button class="btn btn-info btn-sm">Xem</button>
                        <button class="btn btn-warning btn-sm">Sửa</button>
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </td>
                </tr>
                <tr>
                    <td>003</td>
                    <td>Công nghệ phần mềm</td>
                    <td><img src="https://via.placeholder.com/50" alt="Công nghệ phần mềm"></td>
                    <td>8</td>
                    <td>Còn hàng</td>
                    <td>200,000 VND</td>
                    <td>Sách</td>
                    <td>
                        <button class="btn btn-info btn-sm">Xem</button>
                        <button class="btn btn-warning btn-sm">Sửa</button>
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </td>
                </tr>
                <tr>
                    <td>004</td>
                    <td>Giấy A2</td>
                    <td><img src="https://via.placeholder.com/50" alt="Giấy A2"></td>
                    <td>5</td>
                    <td>Còn hàng</td>
                    <td>2,000 VND</td>
                    <td>Văn phòng phẩm</td>
                    <td>
                        <button class="btn btn-info btn-sm">Xem</button>
                        <button class="btn btn-warning btn-sm">Sửa</button>
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </td>
                </tr>
                <tr>
                    <td>005</td>
                    <td>Bút bi</td>
                    <td><img src="https://via.placeholder.com/50" alt="Bút bi"></td>
                    <td>20</td>
                    <td>Còn hàng</td>
                    <td>5,000 VND</td>
                    <td>Văn phòng phẩm</td>
                    <td>
                        <button class="btn btn-info btn-sm">Xem</button>
                        <button class="btn btn-warning btn-sm">Sửa</button>
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
