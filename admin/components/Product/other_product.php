<?php
$limit = 7; // Number of products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page or default to 1
$offset = ($page - 1) * $limit; // Calculate the offset

// Query to get the total number of products in the category 'Sách'
$total_query = "SELECT COUNT(*) FROM products
                JOIN product_categories ON products.category_id = product_categories.category_id
                WHERE product_categories.category_name <> 'Books'";
$total_result = sqlsrv_query($conn, $total_query);
$total_rows = sqlsrv_fetch_array($total_result, SQLSRV_FETCH_NUMERIC)[0];
$total_pages = ceil($total_rows / $limit);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search_query = $_POST['search_query']; // Lấy giá trị tìm kiếm từ biểu mẫu
    // Query tìm kiếm sản phẩm dựa trên tên sản phẩm hoặc mục sách
    $query = "SELECT *
            FROM others_products
            INNER JOIN products ON others_products.product_id = products.product_id
            INNER JOIN product_categories ON products.category_id = product_categories.category_id
            INNER JOIN brands ON others_products.others_product_brand_id = brands.brand_id
            WHERE (others_products.others_product_name LIKE '%$search_query%' OR product_categories.category_name = '$search_query')
            ORDER BY others_products.product_id
            OFFSET $offset ROWS
            FETCH NEXT $limit ROWS ONLY";
    $result = sqlsrv_query($conn, $query);
} else {
// Query to get the products with pagination
    $query = "SELECT *
                FROM others_products
                INNER JOIN products ON others_products.product_id = products.product_id
                INNER JOIN product_categories ON products.category_id = product_categories.category_id
                INNER JOIN brands ON others_products.others_product_brand_id = brands.brand_id
                WHERE product_categories.category_name <> 'Books'
                ORDER BY others_products.product_id
                OFFSET $offset ROWS
                FETCH NEXT $limit ROWS ONLY";
}
$result = sqlsrv_query($conn, $query);
?>
<div class="container">
    <h2 class="mb-4">Danh sách sản phẩm</h2>
    <!-- Tìm kiếm và lọc danh mục -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="POST" action="other_product.php" class="d-flex">
                <input type="text" name="search_query" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                <button type="submit" name="search" class="btn btn-outline-primary ms-2">Tìm</button>
            </form>
        </div>
        <div class="col-md-4">
            <form action="book.php" method="POST" class="d-flex">
                <select id="categoryFilter" class="form-select" name="filter">
                    <option value="Stationery">Văn phòng phẩm</option>
                    <option value="Book">Sách</option>
                </select>
                <button class="btn btn-outline-primary ms-2" id="searchBtn" name="sbm">Lọc</button>
            </form>
        </div>
        <div class="col-md-2">
            <a href="other_product_add.php" class="btn btn-success btn-block float-end">Thêm sản phẩm</a>
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
                <th>Loại sản phẩm</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo $row['others_product_name']; ?></td>
                <td><img src="<?php echo $row['product_image']; ?>" alt="<?php echo $row['others_product_name']; ?>" width="30"></td>
                <td><?php echo $row['product_quantity']; ?></td>
                <td><?php echo $row['product_status']; ?></td>
                <td><?php echo number_format($row['product_price'], 0, ',', '.'); ?> VND</td>
                <td><?php echo $row['category_name']; ?></td>
                <td>
                    <div class="d-flex">
                        <a href="other_product_info.php?product_id=<?php echo $row['product_id']; ?>&page=<?php echo (isset($_GET['page']))?$_GET['page']:'1'?>" class="btn btn-info btn-sm d-flex align-items-center me-1"><i class='bx bxs-show bx-sm me-1'></i>Xem</a>
                        <button class="btn btn-danger btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo $row['product_id']; ?>"><i class='bx bx-sm bx-trash me-1'></i>Xóa</button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="d-flex align-items-center justify-content-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php
                // Display only three page links
                $start = max(1, $page - 1);
                $end = min($start + 2, $total_pages);
                for($i = $start; $i <= $end; $i++):
            ?>
            <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?php if($page >= $total_pages) { echo 'disabled'; } ?>">
                <a class="page-link" href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="components/Product/process.php?type=2&page=<?php echo (isset($_GET['page']))?$_GET['page']:'1'?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa sản phẩm này không?
                    <input type="hidden" name="product_id" id="deleteProductId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" name="sbm_delete_product">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var productId = button.getAttribute('data-id');
        var modalInput = deleteModal.querySelector('#deleteProductId');
        modalInput.value = productId;
    });
});
</script>
