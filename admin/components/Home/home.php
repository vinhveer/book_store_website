<?php
    include_once 'config/connect.php';
    $sql_product_sold = "SELECT SUM(quantity) AS total_sold_quantity
    FROM (
        SELECT quantity
        FROM order_details_on odo
        INNER JOIN orders_online oo ON odo.order_id = oo.order_id
        WHERE oo.status_on = 'Completed'
        UNION ALL
            SELECT quantity
        FROM order_details_off odf
    ) AS all_orders;";
    $result_product_sold = sqlsrv_query($conn,$sql_product_sold);
    $row_product_sold = sqlsrv_fetch_array($result_product_sold);

    $sql_order_count = "SELECT COUNT(*) AS total_orders
    FROM (
        SELECT order_id FROM orders_online

        UNION ALL
            SELECT order_id FROM orders_offline
    ) AS all_orders;
    ";
    $result_order_count = sqlsrv_query($conn,$sql_order_count);
    $row_order_count = sqlsrv_fetch_array($result_order_count);

    $sql_account_count = "SELECT COUNT(*) AS total_accounts
    FROM user_accounts;";
    $result_account_count = sqlsrv_query($conn,$sql_account_count);
    $row_account_count = sqlsrv_fetch_array($result_account_count);

    $sql_total_revenue = "SELECT CAST(SUM(total_amount) AS INT) AS total_revenue
    FROM (
        SELECT total_amount_on AS total_amount
        FROM orders_online
        UNION ALL
        SELECT total_amount_off AS total_amount
        FROM orders_offline
    ) AS all_orders;";
    $result_total_revenue = sqlsrv_query($conn,$sql_total_revenue);
    $row_total_revenue = sqlsrv_fetch_array($result_total_revenue);

    $sql_order_online = "SELECT TOP 3
    c.customer_id,u.image_user,
	u.full_name,
    oo.order_date_on,
    oo.status_on
    FROM
        orders_online oo
    INNER JOIN
        customers c ON oo.customer_id = c.customer_id
    INNER JOIN
        users u ON c.user_id = u.user_id
    ORDER BY
        oo.order_date_on DESC;";
    $result_order_online = sqlsrv_query($conn,$sql_order_online);
    $sql_notification = "SELECT TOP 3 notif_title, notif_content,notif_date
    FROM notiffication ORDER BY notif_date DESC ";
    $result_notification = sqlsrv_query($conn,$sql_notification);
?>

        <div class="header">
            <div class="left">
                <h1>Home</h1>
            </div>
            <a href="#" class="report">
                <i class='bx bx-cloud-download'></i>
                <span>Download CSV</span>
            </a>
        </div>
        <div class="insights">
                <div class="li">
                    <i class='bx bx-calendar-check'></i>
                    <span class="info">
                        <h3>
                            <?php echo $row_order_count['total_orders'] ?>
                        </h3>
                        <p>Number of Order</p>
                    </span>
                </div>
                <div class="li">
                    <i class='bx bx-user-circle'></i>
                    <span class="info">
                        <h3>
                            <?php echo $row_account_count['total_accounts'] ?>
                        </h3>
                        <p>Account User</p>
                    </span>
                </div>
                <div class="li">
                    <i class='bx bx-calendar-edit'></i>
                    <span class="info">
                        <h3>
                            <?php echo $row_product_sold['total_sold_quantity'] ?>
                        </h3>
                        <p>Products sold</p>
                    </span>
                </div>
                <div class="li">
                    <i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3>
                            $<?php echo $row_total_revenue['total_revenue'] ?>
                        </h3>
                        <p>Total revenue</p>
                    </span>
                </div>
        </div>
        <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <a href="order_list.php"><i class='bx bx-receipt'></i></a>
                        <h3>Recent Orders</h3>
                        <i class='bx bx-filter'></i>
                        <a href="order_list.php"><i class='bx bx-search'></i></a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Order Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while ($row_order_online = sqlsrv_fetch_array($result_order_online)) {?>
                            <tr>
                                <td>
                                    <img src="<?php echo $row_order_online['image_user'] ?>">
                                    <p><?php echo $row_order_online['full_name'] ?></p>
                                </td>
                                <?php $order_date = $row_order_online['order_date_on'];
                                    $formatted_date = $order_date->format('Y-m-d'); ?>
                                <td><?php echo $formatted_date; ?></td>
                                <?php if($row_order_online['status_on'] == "Completed"){ ?>
                                    <td><span class="status completed">Completed</span></td>
                                <?php } if($row_order_online['status_on'] == "Pending"){?>
                                    <td><span class="status pending">Pending</span></td>
                                <?php } if($row_order_online['status_on'] == "Unpaid"){?>
                                    <td><span class="status unpaid">Unpaid</span></td>
                                <?php } if($row_order_online['status_on'] == "Shipped"){?>
                                    <td><span class="status process">Shipped</span></td>
                                <?php } if($row_order_online['status_on'] == "Deleted"){?>
                                    <td><span class="status delete">Deleted</span></td>
                                <?php } if($row_order_online['status_on'] == "Confirmed"){?>
                                    <td><span class="status confirmed">Confirmed</span></td>
                                <?php }?>
                            </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>

                <!-- Reminders -->
                <div class="reminders">
                    <div class="header">
                        <a href="nofitication.php"><i class='bx bx-note'></i></a>
                        <h3>Notifications</h3>
                        <i class='bx bx-filter'></i>
                        <a href="nofitication.php"><i class='bx bx-plus'></i></a>
                    </div>
                        <ul class="task-list">
                        <?php
                        while ($row_notification = sqlsrv_fetch_array($result_notification)) {?>
                            <li class="completed">
                                <div class="task-title">
                                    <i class='bx bx-check-circle'></i>
                                    <p><?php echo $row_notification['notif_title'] ;?></p>
                                </div>
                                <a href="nofitication.php"><i class='bx bx-dots-vertical-rounded'></i></a>
                            </li>
                            <?php }?>
                        </ul>
                </div>
            </div>
        </div>
