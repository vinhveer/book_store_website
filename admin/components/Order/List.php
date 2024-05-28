<?php
include_once 'config/connect.php';

// Define the number of results per page
$results_per_page = 6;

// Determine which page number visitor is currently on
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// Determine the SQL LIMIT starting number for the results on the displaying page
$start_from = ($page - 1) * $results_per_page;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $keyword = strtolower(trim($keyword));
    $select_order = $_GET['select'];
    if ($select_order == 1) {
        $sql_order = "SELECT oo.order_id, oo.order_date_on,
                        COALESCE(s.delivery_status, 'Scheduled') AS delivery_status,
                        u.full_name, ue.full_name as employee_name,
                        oo.status_on, oo.note_on
                        FROM orders_online AS oo
                        JOIN customers AS c ON oo.customer_id = c.customer_id
                        JOIN users AS u ON c.user_id = u.user_id
                        LEFT JOIN shipper AS s ON oo.order_id = s.order_id
                        LEFT JOIN employees AS e ON s.employee_id = e.employee_id
                        LEFT JOIN users AS ue ON e.user_id = ue.user_id
                        WHERE LOWER(CONCAT('DH00', CAST(oo.order_id AS NVARCHAR(MAX)))) LIKE '%' + '$keyword' + '%'
                        ORDER BY oo.order_date_on DESC
                        OFFSET $start_from ROWS FETCH NEXT $results_per_page ROWS ONLY;";
        $result_order = sqlsrv_query($conn, $sql_order);
    }
    if ($select_order == 0) {
        $sql_order = "SELECT ue.full_name as employee_name, o.order_id, o.order_date_off, o.note_off
                      FROM orders_offline AS o
                      JOIN employees AS e ON o.employee_id = e.employee_id
                      JOIN users AS ue ON e.user_id = ue.user_id
                      WHERE LOWER(CONCAT('DH00', CAST(order_id AS NVARCHAR(MAX)))) LIKE '%' + '$keyword' + '%'
                      ORDER BY o.order_date_off DESC
                      OFFSET $start_from ROWS FETCH NEXT $results_per_page ROWS ONLY;";
        $result_order = sqlsrv_query($conn, $sql_order);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sbm_select_order'])) {
    $select_order = $_POST['order'];
    if ($select_order == 1) {
        $sql_order = "SELECT oo.order_id, oo.order_date_on,
                    COALESCE(s.delivery_status, 'Scheduled') AS delivery_status,
                    u.full_name, ue.full_name as employee_name,
                    oo.status_on, oo.note_on
                    FROM orders_online AS oo
                    JOIN customers AS c ON oo.customer_id = c.customer_id
                    JOIN users AS u ON c.user_id = u.user_id
                    LEFT JOIN shipper AS s ON oo.order_id = s.order_id
                    LEFT JOIN employees AS e ON s.employee_id = e.employee_id
                    LEFT JOIN users AS ue ON e.user_id = ue.user_id
                    ORDER BY oo.order_date_on DESC
                    OFFSET $start_from ROWS FETCH NEXT $results_per_page ROWS ONLY;
                    ";
        $result_order = sqlsrv_query($conn, $sql_order);
    }
    if ($select_order == 0) {
        $sql_order = "SELECT ue.full_name as employee_name, o.order_id, o.order_date_off, o.note_off
                      FROM orders_offline o
                      JOIN employees e ON o.employee_id = e.employee_id
                      JOIN users AS ue ON e.user_id = ue.user_id
                      ORDER BY o.order_date_off DESC
                      OFFSET $start_from ROWS FETCH NEXT $results_per_page ROWS ONLY;";
        $result_order = sqlsrv_query($conn, $sql_order);
    }
} else {
    $select_order = (isset($_GET['select'])) ? $_GET['select'] : 1;
    if ($select_order == 1) {
        $sql_order = "SELECT oo.order_id, oo.order_date_on,
                    COALESCE(s.delivery_status, 'Scheduled') AS delivery_status,
                    u.full_name, ue.full_name as employee_name,
                    oo.status_on, oo.note_on
                    FROM orders_online AS oo
                    JOIN customers AS c ON oo.customer_id = c.customer_id
                    JOIN users AS u ON c.user_id = u.user_id
                    LEFT JOIN shipper AS s ON oo.order_id = s.order_id
                    LEFT JOIN employees AS e ON s.employee_id = e.employee_id
                    LEFT JOIN users AS ue ON e.user_id = ue.user_id
                    ORDER BY oo.order_date_on DESC
                    OFFSET $start_from ROWS FETCH NEXT $results_per_page ROWS ONLY;
                    ";
        $result_order = sqlsrv_query($conn, $sql_order);
    }
    if ($select_order == 0) {
        $sql_order = "SELECT ue.full_name as employee_name, o.order_id, o.order_date_off, o.note_off
                      FROM orders_offline o
                      JOIN employees e ON o.employee_id = e.employee_id
                      JOIN users AS ue ON e.user_id = ue.user_id
                      ORDER BY o.order_date_off DESC
                      OFFSET $start_from ROWS FETCH NEXT $results_per_page ROWS ONLY;";
        $result_order = sqlsrv_query($conn, $sql_order);
    }
}

// Find the total number of results in the database
$sql_count = "SELECT COUNT(*) AS total FROM orders_online";
if ($select_order == 0) {
    $sql_count = "SELECT COUNT(*) AS total FROM orders_offline";
}
$result_count = sqlsrv_query($conn, $sql_count);
$row_count = sqlsrv_fetch_array($result_count);
$total_pages = ceil($row_count['total'] / $results_per_page);
?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h3><a style="color:black;" href="order.php"><i class='bx bxs-chevrons-left me-3'></i></a>List of orders</h3>
        </div>
        <div class="col-md-5">
            <form class="d-flex" action="order_list.php?select=<?php echo $select_order ?>" method="POST">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                       name="keyword" value="">
                <button class="btn btn-outline-primary" type="submit" name="search" value="find">Search</button>
            </form>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) { ?>
                <div class="row mt-3">
                    <div class="">
                        <?php
                        $keyword = $_POST['keyword'];
                        echo "<span>Search with keyword: '<strong>$keyword</strong>'</span>";
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-3 text-right">
            <button class="btn btn-primary float-end">Export to Excel</button>
        </div>
    </div>
</div>
<div class="container">
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-body">
                <form action="order_list.php" method="post">
                    <div class="row">
                        <div class="col-md-5">
                            <h5 class="card-title">Order List</h5>
                        </div>
                        <div class="col-md-7 text-end">
                            <div class="row d-flex">
                                <div class="col-md-6"></div>
                                <div class="col-md-3 text-end ">
                                    <select class="form-select" id="order" name="order" required>
                                        <option value="" disabled selected>Select order type</option>
                                        <option value="1" <?php echo ($select_order == '1') ? 'selected' : ''; ?>>
                                            Online orders
                                        </option>
                                        <option value="0" <?php echo ($select_order == '0') ? 'selected' : ''; ?>>
                                            Offline orders
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-outline-success" name="sbm_select_order">Filter
                                        orders
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">Order Date</th>
                        <?php if ($select_order == 1) { ?>
                            <th scope="col">Employee Delivery</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Delivery Status</th>
                        <?php }else{ ?>
                            <th scope="col">Employee</th>
                        <?php }?>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = ($page - 1) * $results_per_page;
                    while ($row_order = sqlsrv_fetch_array($result_order)) {
                        $i++;
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i ?></th>
                            <td>OD00<?php echo $row_order['order_id']; ?></td>
                            <?php
                            if ($select_order == 1) $order_date = $row_order['order_date_on'];
                            else $order_date = $row_order['order_date_off'];
                            $formatted_date = $order_date->format('Y-m-d'); ?>
                            <td><?php echo $formatted_date; ?></td>
                            <?php if ($select_order == 1) { ?>
                                <td><?php echo $row_order['employee_name']; ?></td>
                                <td><?php echo $row_order['full_name']; ?></td>
                                <td><?php echo $row_order['delivery_status']; ?></td>
                                <td><?php echo $row_order['status_on']; ?></td>
                            <?php } else { ?>
                                <td><?php echo $row_order['employee_name']; ?></td>
                                <td>Completed</td>
                            <?php } ?>
                            <td>
                                <div class="d-flex">
                                    <?php if ($select_order == 1) { ?>
                                        <a href="order_detail.php?order_id=<?php echo $row_order['order_id']; ?>&select=1"
                                           class="btn btn-sm btn-info me-2 d-flex align-items-center"><i class='bx bxs-show bx-sm me-1'></i>View</a>
                                        <button class="btn btn-sm btn-danger delete-btn me-2"
                                                data-order-id="<?php echo $row_order['order_id']; ?>"><i class='bx bx-sm bx-trash me-1'></i>Delete
                                        </button>
                                    <?php } else { ?>
                                        <a href="order_detail.php?order_id=<?php echo $row_order['order_id']; ?>&select=0"
                                           class="btn btn-sm btn-info me-2 d-flex align-items-center"><i class='bx bxs-show bx-sm me-1'></i>View</a>
                                        <button class="btn btn-sm btn-danger delete-btn me-2"
                                                data-order-id="<?php echo $row_order['order_id']; ?>"><i class='bx bx-sm bx-trash me-1'></i>Delete
                                        </button>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="d-flex align-items-center justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                <a class="page-link" href="order_list.php?page=<?php echo $page - 1; ?>&select=<?php echo $select_order; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php
                            // Determine the start and end page for pagination
                            $start_page = max(1, $page - 1);
                            $end_page = min($total_pages, $page + 1);

                            // Adjust if there are fewer than 3 pages
                            if ($end_page - $start_page + 1 < 3) {
                                if ($start_page == 1) {
                                    $end_page = min(3, $total_pages);
                                } else if ($end_page == $total_pages) {
                                    $start_page = max(1, $total_pages - 2);
                                }
                            }

                            // Display page links
                            for ($i = $start_page; $i <= $end_page; $i++) { ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="order_list.php?page=<?php echo $i; ?>&select=<?php echo $select_order; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>
                            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                <a class="page-link" href="order_list.php?page=<?php echo $page + 1; ?>&select=<?php echo $select_order; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this order?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="components/Order/process.php" method="POST">
                    <input type="hidden" name="order_id" id="order_id_input">
                    <input type="hidden" name="select" id="" value="<?php echo $select_order; ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="btn_delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script>
    // JavaScript to handle delete button click and pass order ID to the confirmation modal
    $(document).ready(function () {
        $('.delete-btn').click(function () {
            var orderId = $(this).data('order-id');
            $('#order_id_input').val(orderId);
            $('#deleteConfirmationModal').modal('show');
        });
    });
</script>
