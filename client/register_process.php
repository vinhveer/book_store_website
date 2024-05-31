<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include the database connection file
    include 'connect.php';

    // Receive data from the form and sanitize input to prevent XSS attacks
    $fullname = htmlspecialchars($_POST['full_name']);
    $date_of_birth = htmlspecialchars($_POST['date_of_birth']);
    $gender = htmlspecialchars($_POST['gender']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Prepare the SQL query with placeholders
    $sql = "EXEC RegisterUser ?, ?, ?, ?, ?, ?, ?, ?";
    
    // Prepare the statement
    $params = array(
        &$fullname,
        &$date_of_birth,
        &$gender,
        &$phone,
        &$address,
        &$email,
        &$username,
        &$password
    );

    $stmt = sqlsrv_prepare($conn, $sql, $params);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        $errors = sqlsrv_errors();
        $errorMessage = "Failed to prepare the SQL statement.";
        if ($errors) {
            foreach ($errors as $error) {
                $errorMessage .= " SQLSTATE: ".$error['SQLSTATE']." Code: ".$error['code']." Message: ".$error['message'].";";
            }
        }
        die(json_encode(['status' => 'error', 'message' => $errorMessage]));
    }

    // Execute the statement
    if (sqlsrv_execute($stmt)) {
        // Fetch the response from the stored procedure
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $register_status = $row['register_status'];
            $message = $row['message'];

            if ($register_status === 'Success') {
                echo json_encode(['status' => 'success', 'message' => $message]);
            } else {
                echo json_encode(['status' => 'error', 'message' => $message]);
            }
        } else {
            $errors = sqlsrv_errors();
            $errorMessage = "An error occurred while fetching the registration result.";
            if ($errors) {
                foreach ($errors as $error) {
                    $errorMessage .= " SQLSTATE: ".$error['SQLSTATE']." Code: ".$error['code']." Message: ".$error['message'].";";
                }
            }
            echo json_encode(['status' => 'error', 'message' => $errorMessage]);
        }
    } else {
        // Error executing the statement
        $errors = sqlsrv_errors();
        $errorMessage = "An error occurred while executing the database query.";
        if ($errors) {
            foreach ($errors as $error) {
                $errorMessage .= " SQLSTATE: ".$error['SQLSTATE']." Code: ".$error['code']." Message: ".$error['message'].";";
            }
        }
        die(json_encode(['status' => 'error', 'message' => $errorMessage]));
    }

    // Free the statement and close the connection
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
