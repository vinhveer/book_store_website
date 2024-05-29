<?php
include 'connect.php'; // Ensure this file correctly sets up the $conn variable

header('Content-Type: application/json');

// Check if the JSON input is valid
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    exit;
}

// Log input data and session data for debugging
error_log('Input data: ' . print_r($data, true));
error_log('Session data: ' . print_r($_SESSION, true));

// Check if required data is set
if (isset($data['product_id']) && isset($data['quantity']) && isset($_SESSION['user_id'])) {
    $productId = $data['product_id'];
    $quantity = $data['quantity'];
    $userId = $_SESSION['user_id'];

    // Construct SQL query
    $sql = "IF EXISTS (SELECT 1 FROM carts WHERE user_id = ? AND product_id = ?)
            BEGIN
                UPDATE carts SET quantity = quantity + ?, created_at = ?, status = ? WHERE user_id = ? AND product_id = ?
            END
            ELSE
            BEGIN
                INSERT INTO carts (user_id, product_id, quantity, created_at, status) VALUES (?, ?, ?, ?, ?)
            END";

    // Set parameters
    $params = [
        $userId, $productId,
        $quantity, date("Y-m-d H:i:s"), 1,
        $userId, $productId,
        $userId, $productId, $quantity, date("Y-m-d H:i:s"), 1
    ];

    // Prepare and execute the query
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    if ($stmt) {
        if (sqlsrv_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            error_log('SQL Execution error: ' . print_r(sqlsrv_errors(), true));
            echo json_encode(['success' => false, 'error' => 'Database execution error']);
        }
    } else {
        error_log('SQL Preparation error: ' . print_r(sqlsrv_errors(), true));
        echo json_encode(['success' => false, 'error' => 'Database preparation error']);
    }

    sqlsrv_free_stmt($stmt);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input or session not set']);
}

sqlsrv_close($conn);
