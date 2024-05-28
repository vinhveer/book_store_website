<?php
$sql_order_index = "SELECT
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Pending') AS pending_orders,
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Confirmed') AS confirmed_orders,
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Deleted') AS deleted_orders,
    (SELECT COUNT(*) FROM orders_online WHERE status_on = 'Completed') AS completed_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'In Transit') AS in_transit_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'Failed') AS failed_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'Delivered') AS delivered_orders,
    (SELECT COUNT(*) FROM shipper WHERE delivery_status = 'Scheduled') AS scheduled_orders,
    (SELECT COUNT(*) FROM orders_offline) AS offline_orders
";

$result_order_index = sqlsrv_query($conn, $sql_order_index);
$row = sqlsrv_fetch_array($result_order_index);
?>

<div class="header">
    <div class="left ms-3">
        <h1>Order</h1>
    </div>
    <div class="d-flex">
        <a href="order_list.php" class="report">
            <i class='bx bx-calendar'></i>
            <span>Order detail</span>
        </a>
    </div>
</div>
<div class="container-fluid">
    <div class="insights">
        <div class="li">
            <i class='bx bx-calendar-edit'></i>
            <span class="info">
                <h3><?php echo $row['confirmed_orders']; ?></h3>
                <p>Paid Order</p>
            </span>
        </div>
        <div class="li">
            <i class='bx bx-time'></i>
            <span class="info">
                <h3><?php echo $row['pending_orders']; ?></h3>
                <p>Pending Order</p>
            </span>
        </div>
        <div class="li">
            <i class='bx bx-calendar-check'></i>
            <span class="info">
                <h3><?php echo $row['completed_orders'] + $row['offline_orders']; ?></h3>
                <p>Completed Orders</p>
            </span>
        </div>
        <div class="li">
            <i class='bx bx-x-circle'></i>
            <span class="info">
                <h3><?php echo $row['deleted_orders']; ?></h3>
                <p>Failed Order</p>
            </span>
        </div>
    </div>
    <div class="row mt-3">
        <div class="bg-light p-3 col-md-6">
            <h5 class="card-title">Order chart</h5>
            <hr>
            <canvas id="orderChart" width="200" height="100"></canvas>
        </div>
        <div class="bg-light p-3 col-md-6">
            <h5 class="card-title">Order chart</h5>
            <hr>
            <canvas id="orderChart1" width="200" height="100"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get data from PHP and assign to JavaScript variables
    var completed_orders = <?php echo $row['completed_orders'] + $row['offline_orders']; ?>;
    var deleted_orders = <?php echo $row['deleted_orders']; ?>;
    var pending_orders = <?php echo $row['pending_orders']; ?>;
    var confirmed_orders = <?php echo $row['confirmed_orders']; ?>;
    var in_transit_orders = <?php echo $row['in_transit_orders']; ?>;
    var failed_orders = <?php echo $row['failed_orders']; ?>;
    var delivered_orders = <?php echo $row['delivered_orders']; ?>;
    var scheduled_orders = <?php echo $row['scheduled_orders']; ?>;

    // Get the canvas element
    var ctx = document.getElementById('orderChart').getContext('2d');
    var ctx1 = document.getElementById('orderChart1').getContext('2d');

    // Data from PHP for the chart
    var data = {
        labels: ['Completed', 'Pending', 'Cancelled', 'Paid'],
        datasets: [{
            label: 'Order statistics',
            data: [completed_orders, pending_orders, deleted_orders, confirmed_orders],
            backgroundColor: [
                'rgba(13, 131, 51, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(13, 131, 51, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 2
        }]
    };

    var data_ship = {
        labels: ['Delivered', 'Scheduled', 'Failed', 'In Transit'],
        datasets: [{
            label: 'Shipping statistics',
            data: [delivered_orders, scheduled_orders, failed_orders, in_transit_orders],
            backgroundColor: [
                'rgba(13, 131, 51, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(13, 131, 51, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 2
        }]
    };

    // Create the charts
    var orderChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var orderChart1 = new Chart(ctx1, {
        type: 'bar',
        data: data_ship,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
